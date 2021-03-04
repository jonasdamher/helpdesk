<?php

declare(strict_types=1);

class PointOfSaleModel extends BaseModel
{

    private int $id;
    private int $idCompany;
    private int $idStatus;
    private string $name;
    private ?string $companyCode;
    private ?int $idCountry;
    private ?string $province;
    private ?string $locality;
    private ?int $postalCode;
    private ?string $address;

    public function __construct()
    {
        $this->table = 'points_of_sales';
    }

    // GET & SET

    public function getId(): int
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $this->validate($id)->require()->int();
    }

    public function getIdCompany(): int
    {
        return $this->idCompany;
    }

    public function setIdCompany($idCompany): void
    {
        $this->idCompany = $this->validate($idCompany)->require()->int();
    }

    public function getIdStatus(): int
    {
        return $this->idStatus;
    }

    public function setIdStatus($status): void
    {
        $this->idStatus = $this->validate($status)->require()->int();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $this->validate($name)->string();
    }

    public function getCompanyCode()
    {
        return $this->companyCode;
    }

    public function setCompanyCode(?string $companyCode): void
    {
        $this->companyCode = $this->validate($companyCode)->string();
    }

    public function getIdCountry()
    {
        return $this->idCountry;
    }

    public function setIdCountry(?int $idCountry): void
    {
        $this->idCountry = $this->validate($idCountry)->int();
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince(?string $province): void
    {
        $this->province = $this->validate($province)->string();
    }

    public function getLocality()
    {
        return $this->locality;
    }

    public function setLocality(?string $locality): void
    {
        $this->locality = $this->validate($locality)->string();
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): void
    {
        $this->postalCode = $this->validate($postalCode)->int();
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $this->validate($address)->string();
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryPointOfSale(): array
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, 
        $this->table.name, 
        $this->table.created, 
        $this->table.company_code, 
        $this->table._id_status, 
        $this->table._id_company, 
        pto_status.status, companies.business_name, companies.cif");

        $build->setFrom($this->table);

        $build->setInner("INNER JOIN companies ON $this->table._id_company = companies._id
        INNER JOIN pto_status ON $this->table._id_status = pto_status._id");

        $build->setSearch("$this->table.name LIKE :search OR
        $this->table.company_code LIKE :search OR
        companies.cif LIKE :search OR
        companies.business_name LIKE :search OR
        companies.tradename LIKE :search");

        return $build->query();
    }

    //  PUBLICS METHODS

    public function create(): array
    {
        try {

            $new = Database::connect()->prepare(
                "INSERT 
                INTO $this->table 
                (_id_company, 
                _id_status, 
                name, 
                company_code,
                _id_country, 
                province, 
                locality,
                postal_code,
                address) 
                VALUES (:idCompany, 
                :idStatus, 
                :name, 
                :companyCode, 
                :country, 
                :province, 
                :locality, 
                :postalCode, 
                :address)"
            );

            $new->bindValue(':idCompany', $this->getIdCompany(), PDO::PARAM_INT);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $new->bindValue(':companyCode', $this->getCompanyCode(), PDO::PARAM_STR);
            $new->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $new->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $new->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $new->bindValue(':postalCode', $this->getPostalCode(), PDO::PARAM_INT);
            $new->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);

            $new->execute();

            $id = ['id' => Database::connect()->lastInsertId()];
            $this->success($id, 'Punto de venta registrado.');
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $new = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function read(): array
    {
        return $this->getById($this->getId());
    }

    public function readAll(): array
    {
        return $this->getAllQuery($this->queryPointOfSale());
    }

    public function update(): array
    {
        try {

            $update = Database::connect()->prepare(
                "UPDATE 
                $this->table 
                SET 
                _id_company = :company, 
                _id_status = :status, 
                name = :name, 
                company_code = :code, 
                _id_country = :country, 
                province = :province, 
                locality = :locality,
                postal_code = :postal_code,
                address = :address
                WHERE _id = :id"
            );

            $update->bindValue(':company', $this->getIdCompany(), PDO::PARAM_INT);
            $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);
            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':code', $this->getCompanyCode(), PDO::PARAM_STR);
            $update->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $update->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $update->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $update->bindValue(':postal_code', $this->getPostalCode(), PDO::PARAM_INT);
            $update->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $update->execute();

            $id = ['id' => $this->getId()];
            $this->success($id);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function delete(): array
    {
        return $this->deleteById($this->getId());
    }

    public function getDetails(): array
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT 
                $this->table.name,
                $this->table.company_code,
                $this->table._id_country,
                $this->table.province,
                $this->table.locality,
                $this->table.postal_code,
                $this->table.address,
                $this->table.created,
                pto_status.status,
                companies.tradename,
                companies.cif,
                companies.business_name,
                countries.name as namecountry
                FROM $this->table
                INNER JOIN
                pto_status
                ON $this->table._id_status = pto_status._id
                INNER JOIN
                companies
                ON $this->table._id_company = companies._id
                LEFT JOIN
                countries
                ON $this->table._id_country = countries._id
                WHERE $this->table._id = :id"
            );

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
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

    // OTHERS METHODS

    public function paginations(): array
    {
        return $this->pagination('paginations', $this->queryPointOfSale());
    }

    public function getCompanies(): array
    {
        try {
            $get = Database::connect()->prepare(
                "SELECT _id, business_name
                FROM companies
                WHERE _id_status = :status"
            );

            $get->bindValue(':status', 1, PDO::PARAM_INT);
            $get->execute();
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            $this->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->fail($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function getStatus(): array
    {
        return $this->getAllOtherTable('pto_status');
    }

    public function getCountries(): array
    {
        return $this->getAllOtherTable('countries');
    }
}
