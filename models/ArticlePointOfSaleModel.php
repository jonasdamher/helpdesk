<?php

declare(strict_types=1);

class ArticlePointOfSaleModel extends BaseModel
{

    private int $id;
    private int $idPto;
    private int $idType;
    private int $idIncidence;
    private string $name;
    private ?string $barcode;
    private ?string $serial;
    private ?string $code;
    private ?string $observations;

    public function __construct()
    {
        $this->table = 'articles_point_of_sales';
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

    public function getIdPto()
    {
        return $this->idPto;
    }

    public function setIdPto(int $idPto)
    {
        $this->idPto = $idPto;
    }

    public function getIdType()
    {
        return $this->idType;
    }

    public function setIdType(int $idType)
    {
        $this->idType = $idType;
    }

    public function getIdIncidence()
    {
        return $this->idIncidence;
    }

    public function setIdIncidence(int $idIncidence)
    {
        $this->idIncidence = $idIncidence;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode)
    {
        $this->barcode = $barcode;
    }

    public function getSerial()
    {
        return $this->serial;
    }

    public function setSerial(?string $serial)
    {
        $this->serial = $serial;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode(?string $code)
    {
        $this->code = $code;
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setObservations(?string $observations)
    {
        $this->observations = $observations;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryArticlePto()
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("
        $this->table._id, 
        $this->table.name,
        $this->table.serial, 
        $this->table.barcode, 
        $this->table.code,
        $this->table.observations,
        art_types.type");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN art_types ON $this->table._id_type = art_types._id");
        $build->setWhere("$this->table._id_incidence = :id");
        $build->setById($this->getIdIncidence());

        return $build->query();
    }

    // PUBLICS METHODS

    public function create()
    {
        try {

            $new = Database::connect()->prepare(
                "INSERT INTO $this->table 
                (_id_pto, serial, barcode, name, observations, _id_type, code, _id_incidence) 
                VALUES 
                (:idPto, :serial, :barcode, :name, :observations, :idType, :code, :idIncidence)"
            );

            $new->bindValue(':idPto', $this->getIdPto(), PDO::PARAM_INT);
            $new->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $new->bindValue(':barcode', $this->getBarcode(), PDO::PARAM_STR);
            $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $new->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $new->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);
            $new->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $new->bindValue(':idIncidence', $this->getIdIncidence(), PDO::PARAM_INT);

            return ($new->execute()) ? ['valid' => true, 'id' => Database::connect()->lastInsertId()] : ['valid' => false];
        } catch (PDOexception $e) {
            return ['valid' => false, 'error' => $e->getMessage()];
        }
    }

    public function read(): array
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table.name,
                $this->table.serial,
                $this->table.barcode,
                $this->table.code,
                $this->table.observations,
                $this->table._id_type,
                art_types.type
                FROM
                $this->table
                INNER JOIN
                art_types
                ON $this->table._id_type = art_types._id
                WHERE $this->table._id = :id"
            );

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $get->execute();
            if (!$get->rowCount()) {
                throw new Exception('Artículo no encontrado.');
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
        return $this->getAllQuery($this->queryArticlePto());
    }

    public function update()
    {
        try {
            $update = Database::connect()->prepare(
                "UPDATE $this->table SET
                name = :name,
                serial = :serial,
                barcode = :barcode,
                code = :code,
                observations = :observations,
                _id_type = :idType
                WHERE _id = :id"
            );
            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $update->bindValue(':barcode', $this->getBarcode(), PDO::PARAM_STR);
            $update->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $update->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $update->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);
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

    public function delete()
    {
        return ($this->deleteById($this->getId())) ? ['valid' => true] : ['valid' => false];
    }

    public function articlesIncidence()
    {
        return $this->getAllOtherById('_id_incidence', $this->getIdIncidence());
    }

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryArticlePto());
    }

    public function getTypes()
    {
        return $this->getAllOtherTable('art_types');
    }
}
