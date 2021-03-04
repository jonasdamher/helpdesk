<?php

declare(strict_types=1);

class ArticleBorrowedModel extends BaseModel
{

    private int $id;
    private int $idArticle;
    private int $idIncidence;
    private int $idPto;

    public function __construct()
    {
        $this->table = 'articles_borrowed_point_of_sales';
    }

    // GET & SET

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getIdArticle()
    {
        return $this->idArticle;
    }

    public function setIdArticle(int $idArticle)
    {
        $this->idArticle = $idArticle;
    }

    public function getIdIncidence()
    {
        return $this->idIncidence;
    }

    public function setIdIncidence(int $idIncidence)
    {
        $this->idIncidence = $idIncidence;
    }

    public function getIdPto()
    {
        return $this->idPto;
    }

    public function setIdPto(int $idPto)
    {
        $this->idPto = $idPto;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryArticleBorrowed()
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("
        $this->table._id,
        articles_only.serial,
        articles_only.code,
        articles_only.observations,
        articles.name, 
        articles.barcode");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN
        articles_only
        ON $this->table._id_article_only = articles_only._id
        INNER JOIN
        articles
        ON articles_only._id_article = articles._id");
        $build->setWhere("$this->table._id_incidence = :id");
        $build->setById($this->getIdIncidence());

        return $build->query();
    }

    private function articleExistInIncidence()
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table._id_article_only
                FROM
                $this->table
                INNER JOIN
                articles_only
                ON $this->table._id_article_only = articles_only._id
                WHERE $this->table._id_incidence = :idIncidence AND $this->table._id_article_only = :idArticle"
            );
            $get->bindValue(':idIncidence', $this->getIdIncidence(), PDO::PARAM_INT);
            $get->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);

            $this->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    private function articleCurrentBorrowed()
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT _id
                FROM articles_only
                WHERE _id = :idArticle AND _id_borrowed_status = 2"
            );
            $get->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);

            $this->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    private function changeBorrowedStatusArticleOnly($currentArticle)
    {
        try {
            $updateBorrowedArticleOnly = Database::connect()->prepare(
                "UPDATE articles_only SET
            _id_borrowed_status = :status
            WHERE _id = :id"
            );

            // SI ES DIFERENTE CAMBIA EL ESTADO DE PRESTAMO DEL ARTICULO ANTERIOR * ESTADO ALMACÉN
            $updateBorrowedArticleOnly->bindValue(':status', 1, PDO::PARAM_INT);
            $updateBorrowedArticleOnly->bindValue(':id', $currentArticle['_id_article_only'], PDO::PARAM_INT);
            $updateBorrowedArticleOnly->execute();

            $id = ['id' => $this->getId()];
            $this->success($id);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $updateBorrowedArticleOnly = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // PUBLICS METHODS

    public function create()
    {
        try {
            $articleExistInIncidence = $this->articleExistInIncidence();
            if ($articleExistInIncidence['valid']) {
                throw new Exception('Ese artículo está en la lista.');
            }

            $articleCurrentBorrowed = $this->articleCurrentBorrowed();
            if ($articleCurrentBorrowed['valid']) {
                throw new Exception('Ese artículo está en prestamo.');
            }

            $new = Database::connect()->prepare("INSERT INTO $this->table (_id_article_only, _id_incidence, _id_pto) VALUES (:idArticle, :idIncidence, :idPto)");
            $new->execute();
            $new->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $new->bindValue(':idIncidence', $this->getIdIncidence(), PDO::PARAM_INT);
            $new->bindValue(':idPto', $this->getIdPto(), PDO::PARAM_INT);

            $id = ['id' => Database::connect()->lastInsertId()];
            $this->success($id);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
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
                $this->table._id_article_only,
                articles_only.serial,
                articles_only.code,
                articles_only.observations,
                articles_only._id_borrowed_status,
                articles.name,
                articles.barcode
                FROM
                $this->table
                INNER JOIN
                articles_only
                ON $this->table._id_article_only = articles_only._id
                INNER JOIN
                articles
                ON articles_only._id_article = articles._id
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
        return $this->getAllQuery($this->queryArticleBorrowed());
    }

    public function update()
    {
        try {

            // COGER FICHA DE ARTICULO EN PRESTAMO
            $currentArticle = $this->getById($this->getId());
            // COMPARA SI EL ID DEL ARTICULO NUEVO ESTÁ EN LA LISTA ACTUAL Y SI ES DISTINTO AL ANTERIOR
            $articleExistInIncidence = $this->articleExistInIncidence();
            if ($articleExistInIncidence && $articleExistInIncidence['_id_article_only'] != $currentArticle['_id_article_only']) {
                throw new Exception('Ese artículo está en la lista.');
            }
            // COMPARA SI EL ID DEL ARTICULO NUEVO ESTA EN PRESTAMO Y SI ES DISTINTO AL ANTERIOR
            $articleCurrentBorrowed = $this->articleCurrentBorrowed();
            if ($articleCurrentBorrowed && $articleCurrentBorrowed['_id'] != $currentArticle['_id_article_only']) {
                throw new Exception('Ese artículo está en prestamo.');
            }
            // COMPARA EL ARTICULO ACTUAL CON EL NUEVO
            if ($currentArticle['result']['_id_article_only'] != $this->getIdArticle()) {

                $updateStatusBorrowed = $this->changeBorrowedStatusArticleOnly($currentArticle);
                if (!$updateStatusBorrowed['valid']) {
                    throw new Exception($updateStatusBorrowed['error']);
                }
            }

            $update = Database::connect()->prepare(
                "UPDATE $this->table SET
                _id_article_only = :idArticle
                WHERE _id = :id"
            );
            $update->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $update->execute();

            $id = ['id' => $this->getId()];
            $this->success($id);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
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
        return $this->deleteById($this->getId());
    }

    public function articlesIncidence()
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT
                articles_only.serial,
                articles_only.code,
                articles.barcode,
                articles.name
                FROM
                $this->table
                INNER JOIN
                articles_only
                ON $this->table._id_article_only = articles_only._id
                INNER JOIN
                articles
                ON articles_only._id_article = articles._id
                WHERE $this->table._id_incidence = :idIncidence AND articles_only._id_borrowed_status = :idBorrowed"
            );
            $get->bindValue(':idIncidence', $this->getIdIncidence(), PDO::PARAM_INT);
            $get->bindValue(':idBorrowed', 2, PDO::PARAM_INT);
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

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryArticleBorrowed());
    }

    public function getTypes()
    {
        return $this->getAllOtherTable('art_types');
    }

    public function getBorrowedStatus()
    {
        return $this->getAllOtherTable('art_borrowed_status');
    }
}
