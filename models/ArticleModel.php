<?php

declare(strict_types=1);

class ArticleModel extends BaseModel
{

    private int $id;
    private int $idArticle;
    private int $idStatus;
    private int $idBorrowed;
    private ?string $serial;
    private ?string $code;
    private ?string $observations;

    public function __construct()
    {
        $this->table = 'articles_only';
    }

    // GET & SET

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $this->validate($id)->require()->int();
    }

    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    public function setIdStatus(int $idStatus): void
    {
        $this->idStatus = $this->validate($idStatus)->require()->int();
    }

    public function getSerial(): string
    {
        return $this->serial;
    }

    public function setSerial(?string $serial): void
    {
        $this->serial = $this->validate($serial)->string();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $this->validate($code)->string();
    }

    public function getIdArticle(): int
    {
        return $this->idArticle;
    }

    public function setIdArticle($idArticle): void
    {
        $this->idArticle = $this->validate($idArticle)->require()->int();
    }

    public function getIdBorrowed(): int
    {
        return $this->idBorrowed;
    }

    public function setIdBorrowed($idBorrowed): void
    {
        $this->idBorrowed = $this->validate($idBorrowed)->require()->int();
    }

    public function getObservations(): string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): void
    {
        $this->observations = $this->validate($observations)->string();
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryArticlesOnly()
    {
        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("
        $this->table._id, $this->table.serial, $this->table.observations, $this->table.created, $this->table.code, 
        art_status.status, art_borrowed_status.status as statusBorrowed,
        points_of_sales._id as idPointOfSale, points_of_sales.name,
        incidences._id as idIncidence");
        $build->setFrom("$this->table");
        $build->setInner("
        INNER JOIN art_status ON $this->table._id_status = art_status._id
        INNER JOIN art_borrowed_status ON $this->table._id_borrowed_status = art_borrowed_status._id
        LEFT JOIN articles_borrowed_point_of_sales ON $this->table._id_borrowed_status = 2 AND $this->table._id = articles_borrowed_point_of_sales._id_article_only
        LEFT JOIN points_of_sales ON articles_borrowed_point_of_sales._id_pto = points_of_sales._id
        LEFT JOIN incidences ON articles_borrowed_point_of_sales._id_incidence = incidences._id AND incidences._id_status != 3");
        $build->setWhere("$this->table._id_article = :id ");
        $build->setById($this->getIdArticle());

        return $build->query();
    }

    // PUBLICS METHODS

    public function create()
    {
        try {
            $new = Database::connect()->prepare(
                "INSERT INTO $this->table 
                (_id_article,serial,code,observations,_id_status) 
                VALUES (:idArticle,:serial,:code,:observations,:idStatus)"
            );

            $new->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $new->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $new->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $new->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $new->execute();

            $id = ['id' => Database::connect()->lastInsertId()];
            $this->success($id);
        } catch (PDOexception $e) {
            $this->error($e->getMessage());
        } finally {
            $new = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function read()
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table._id_article,
                $this->table.serial,
                $this->table.code,
                $this->table.observations,
                $this->table._id_status,
                $this->table.created,
                art_status.status,
                art_borrowed_status.status as statusBorrowed
                FROM
                $this->table
                INNER JOIN
                art_status
                ON $this->table._id_status = art_status._id
                INNER JOIN
                art_borrowed_status
                ON $this->table._id_borrowed_status = art_borrowed_status._id
                WHERE $this->table._id = :id"
            );

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $get->execute();
            if (!$get->rowCount()) {
                throw new Exception('Usuario no encontrado.');
            }
             $result = $get->fetch(PDO::FETCH_ASSOC);
            $this->success($result);
        } catch (Exception $e) {
            $this->status(404)->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function readAll()
    {
        return $this->getAllQuery($this->queryArticlesOnly());
    }

    public function update()
    {
        try {
            $update = Database::connect()->prepare(
                "UPDATE $this->table SET
                serial = :serial, 
                code = :code, 
                observations = :observations,
                _id_status = :idStatus
                WHERE _id = :id"
            );

            $update->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $update->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $update->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $update->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);

            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            $update->execute();

            $id = ['id' => $this->getId()];
            $this->success($id);
        } catch (PDOexception $e) {
            $this->error($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function delete()
    {
        try {
            $article = $this->getById($this->getId());
            if ($article['result']['_id_borrowed_status'] == 2) {
                throw new Exception('El artículo está en prestamo en una incidencia.');
            }

            $delete = $this->deleteById($this->getId());
            if (!$delete['valid']) {
                throw new Exception('Hubo un error al intentar eliminar el artículo.');
            }

            $this->success($delete['result']);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } finally {
            return $this->send();
        }
    }

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryArticlesOnly());
    }

    public function getStatus()
    {
        return $this->getAllOtherTable('art_status');
    }

    public function getNotBorrowed()
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table.serial,
                articles.name
                FROM
                $this->table
                INNER JOIN
                articles
                ON $this->table._id_article = articles._id
                WHERE $this->table._id_status = :idStatus"
            );
            $get->bindValue(':idStatus', 1, PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->success($result, 'Usuario actualizado.');
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function updateBorrowed()
    {
        try {
            $update = Database::connect()->prepare("UPDATE $this->table SET _id_borrowed_status = :idBorrowed WHERE $this->table._id = :id");
            $update->bindValue(':idBorrowed', $this->getIdBorrowed(), PDO::PARAM_INT);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $update->execute();

            $result = ['id' => $this->getId()];
            $this->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function totalBorrowed()
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT art_borrowed_status.status, COUNT(*) as total
                FROM $this->table
                INNER JOIN art_borrowed_status
                ON $this->table._id_borrowed_status = art_borrowed_status._id 
                WHERE $this->table._id_article = :id
                GROUP BY art_borrowed_status.status"
            );

            $get->bindValue(':id', $this->getIdArticle(), PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }
}
