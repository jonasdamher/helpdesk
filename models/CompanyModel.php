<?php

declare(strict_types=1);

class CompanyModel extends BaseModel
{

    private int $id;
    private string $tradename;
    private string $businessName;
    private string $cif;
    private int $idStatus;

    public function __construct()
    {
        $this->table = 'companies';
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

    public function getTradename()
    {
        return $this->tradename;
    }

    public function setTradename(string $tradename)
    {
        $this->tradename = $tradename;
    }

    public function getbusinessName()
    {
        return $this->businessName;
    }

    public function setbusinessName(string $business_name)
    {
        $this->businessName = $business_name;
    }

    public function getCif()
    {
        return $this->cif;
    }

    public function setCif(string $cif)
    {
        $this->cif = $cif;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus(int $idStatus)
    {
        $this->idStatus = $idStatus;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryCompany()
    {
        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, $this->table.tradename, $this->table.business_name, $this->table.cif, $this->table._id_status, $this->table.created, comp_status.status");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN comp_status ON $this->table._id_status = comp_status._id");
        $build->setSearch("$this->table.tradename LIKE :search OR $this->table.business_name LIKE :search OR $this->table.cif LIKE :search");

        return $build->query();
    }

    //  PUBLICS METHODS
    public function read()
    {
        return $this->getById($this->getId());
    }

    public function readAll()
    {
        return $this->getAllQuery($this->queryCompany());
    }

    public function create()
    {
        try {
            $existCif = $this->getBy('cif', $this->getCif());
            if ($existCif['valid']) {
                throw new Exception('El cif "' . $this->getCif() . '" ya está registrado.');
            }

            $existBusinessName = $this->getBy('business_name', $this->getbusinessName());
            if ($existBusinessName['valid']) {
                throw new Exception('La razón social "' . $this->getbusinessName() . '" ya está registrada.');
            }

            $new = Database::connect()->prepare(
                "INSERT INTO $this->table 
                (tradename, business_name, cif, _id_status) 
                VALUES (:tradename, :business, :cif, :idStatus)"
            );
            $new->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
            $new->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
            $new->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_STR);
            $new->execute();

            $result = ['id' => Database::connect()->lastInsertId()];
            $this->success($result, 'Empresa registrado.');
        } catch (Exception $e) {
            $this->status(500)->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $new = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function update()
    {
        try {
            $existCif = $this->getBy('cif', $this->getCif());
            if (!($existCif['valid'] && $existCif['result']['_id'] != $this->getId())) {
                throw new Exception('El cif "' . $this->getCif() . '" ya está registrado.');
            }

            $existBusinessName = $this->getBy('business_name', $this->getbusinessName());
            if (!($existBusinessName['valid'] && $existBusinessName['result']['_id'] != $this->getId())) {
                throw new Exception('El nombre comercial "' . $this->getbusinessName() . '" ya está registrado.');
            }

            $update = Database::connect()->prepare("UPDATE $this->table SET tradename = :tradename, business_name = :business, cif = :cif, _id_status = :status WHERE _id = :id");
            $update->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
            $update->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
            $update->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
            $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $update->execute();

            $result = ['id' => $this->getId()];
            $this->success($result, 'Empresa registrado.');
        } catch (Exception $e) {
            $this->status(500)->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryCompany());
    }

    public function getStatus()
    {
        return $this->getAllOtherTable('comp_status');
    }
}
