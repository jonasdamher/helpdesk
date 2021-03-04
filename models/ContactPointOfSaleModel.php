<?php

declare(strict_types=1);

class ContactPointOfSaleModel extends BaseModel
{

    private int $id;
    private string $name;
    private ?int $phone;
    private ?string $email;
    private int $idPto;

    public function __construct()
    {
        $this->table = 'pto_contacts';
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name =  $this->validate($name)->require()->string();
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone): void
    {
        $this->phone = $this->validate($phone)->int();
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $this->validate($email)->require()->email();
    }

    public function getIdPto(): int
    {
        return $this->idPto;
    }

    public function setIdPto($idPto): void
    {
        $this->idPto = $this->validate($idPto)->require()->int();
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryContact(): array
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect('_id, name, phone, email');
        $build->setFrom('pto_contacts');
        $build->setWhere('_id_pto = :id');
        $build->setById($this->getIdPto());

        return $build->query();
    }

    //  PUBLICS METHODS

    public function create(): array
    {
        try {

            $new = Database::connect()->prepare(
                "INSERT 
                INTO $this->table (name, phone, email, _id_pto) 
                VALUES (:name, :phone, :email, :idPto)"
            );

            $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $new->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $new->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $new->bindValue(':idPto', $this->getIdPto(), PDO::PARAM_INT);
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

    public function read(): array
    {
        return $this->getById($this->getId());
    }

    public function readAll(): array
    {
        return $this->getAllQuery($this->queryContact());
    }

    public function update(): array
    {
        try {

            $update = Database::connect()->prepare(
                "UPDATE $this->table SET
                name = :name, 
                phone = :phone, 
                email = :email
                WHERE _id = :id"
            );

            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $update->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
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

    public function delete(): array
    {
        return $this->deleteById($this->getId());
    }

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryContact());
    }
}
