<?php

declare(strict_types=1);

class GeneralArticleModel extends BaseModel
{

    private int $id;
    private string $name;
    private ?string $description;
    private string $barcode;
    private ?float $cost;
    private ?float $pvp;
    private int $idProvider;
    private int $idType;
    private $image;

    public function __construct()
    {
        $this->table = 'articles';
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

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(?string $description)
    {
        $this->description = $description;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

    public function setBarcode(string $barcode)
    {
        $this->barcode = $barcode;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost(?float $cost)
    {
        $this->cost = $cost;
    }

    public function getPvp()
    {
        return $this->pvp;
    }

    public function setPvp(?float $pvp)
    {
        $this->pvp = $pvp;
    }

    public function getIdProvider()
    {
        return $this->idProvider;
    }

    public function setIdProvider(int $idProvider)
    {
        $this->idProvider = $idProvider;
    }

    public function getIdType()
    {
        return $this->idType;
    }

    public function setIdType(int $idType)
    {
        $this->idType = $idType;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryArticle()
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, $this->table.name, $this->table.barcode, $this->table.units, $this->table.created, $this->table.image, $this->table._id_provider, art_types.type, suppliers.business_name");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN art_types ON $this->table._id_type = art_types._id INNER JOIN suppliers ON $this->table._id_provider = suppliers._id");
        $build->setSearch("$this->table.name LIKE :search OR $this->table.barcode LIKE :search OR suppliers.business_name LIKE :search OR suppliers.tradename LIKE :search OR suppliers.cif LIKE :search");

        return $build->query();
    }

    //  PUBLICS METHODS

    public function create()
    {
        try {

            $existBarcode = $this->getBy('barcode', $this->getBarcode());

            if ($existBarcode) {
                return 'El código de barras "' . $this->getBarcode() . '" ya está registrado.';
            }

            $imageUpload = $this->Image('articles', $this->getImage());

            if ($imageUpload['valid']) {

                $new = Database::connect()->prepare(
                    "INSERT INTO $this->table ( 
                        name, description, barcode, cost, pvp, _id_provider, _id_type, image
                    )
                    VALUES (
                    :name, :description, :barcode, :cost, :pvp, :idProvider, :idType, :image
                    )"
                );

                $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
                $new->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
                $new->bindValue(':barcode', $this->getBarcode(), PDO::PARAM_STR);
                $new->bindValue(':cost', $this->getCost(), PDO::PARAM_STR);
                $new->bindValue(':pvp', $this->getPvp(), PDO::PARAM_STR);
                $new->bindValue(':idProvider', $this->getIdProvider(), PDO::PARAM_INT);
                $new->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);
                $new->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);

                if ($new->execute()) {
                    return 'Artículo registrado.';
                } else {
                    return 'Hubo un error al intentar registrar, intentelo mas tarde.';
                }
            } else {
                return $imageUpload['errors'];
            }
        } catch (PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function read()
    {
        return $this->getById($this->getId());
    }

    public function readAll()
    {
        return $this->getAllQuery($this->queryArticle());
    }

    public function update()
    {
        try {

            $existBarcode = $this->getBy('barcode', $this->getBarcode());

            if ($existBarcode && $existBarcode['_id'] != $this->getId()) {
                return 'El código de barras "' . $this->getBarcode() . '" ya está registrado.';
            }

            $article = $this->read();
            $imageUpload = $this->Image('articles', ['CurrentimageName' => $article['image'], 'updateImage' => $this->getImage()], 'update');

            if ($imageUpload['valid']) {
                $image = !is_null($imageUpload['filename']) ? ', image = :image' : '';

                $update = Database::connect()->prepare(
                    "UPDATE $this->table SET
                    name = :name,
                    description = :description,
                    barcode = :barcode, 
                    cost = :cost, 
                    pvp = :pvp,
                    _id_provider = :idProvider,
                    _id_type = :idType
                    $image
                    WHERE _id = :id"
                );

                $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
                $update->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
                $update->bindValue(':barcode', $this->getBarcode(), PDO::PARAM_STR);
                $update->bindValue(':cost', $this->getCost(), PDO::PARAM_STR);
                $update->bindValue(':pvp', $this->getPvp(), PDO::PARAM_STR);
                $update->bindValue(':idProvider', $this->getIdProvider(), PDO::PARAM_INT);
                $update->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);

                if (!is_null($imageUpload['filename'])) {
                    $update->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);
                }

                $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

                if ($update->execute()) {
                    header('Location: ' . URL_BASE . $_GET['controller'] . '/' . $_GET['action'] . '/' . $_GET['id'] . '?status=1');
                } else {
                    header('Location: ' . URL_BASE . $_GET['controller'] . '/' . $_GET['action'] . '/' . $_GET['id'] . '?status=0');
                }
            } else {
                return $imageUpload['errors'];
            }
        } catch (PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function delete()
    {
    }

    public function getDetails()
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT 
                $this->table._id,
                $this->table.name, 
                $this->table.description, 
                $this->table.barcode, 
                $this->table.units, 
                $this->table.cost, 
                $this->table.pvp, 
                $this->table.image, 
                $this->table.created, 
                suppliers.business_name, 
                art_types.type
                FROM $this->table
                INNER JOIN suppliers
                ON $this->table._id_provider = suppliers._id
                INNER JOIN art_types
                ON $this->table._id_type = art_types._id
                WHERE $this->table._id = :id
            "
            );

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $get->execute();
            $result = $get->fetch(PDO::FETCH_ASSOC);

            $get = null;
            return $result;
        } catch (PDOexception $e) {
            return $e->getMessage();
        }
    }

    // OTHERS METHODS

    public function paginations()
    {
        return $this->pagination('paginations', $this->queryArticle());
    }

    public function getArticlesTypes()
    {
        return $this->getAllOtherTable('art_types');
    }

    public function getProviders()
    {
        return $this->getAllOtherTable('suppliers');
    }

    public function addUnit()
    {
        try {

            $update = Database::connect()->prepare(
                "UPDATE 
                $this->table 
                SET 
                units = units + (1)
                WHERE _id = :id"
            );

            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            return ($update->execute()) ? ['valid' => true] : ['valid' => false];
        } catch (PDOexception $e) {

            return $e->getMessage();
        }
    }

    public function removeUnit()
    {
        try {

            $update = Database::connect()->prepare(
                "UPDATE 
                $this->table 
                SET 
                units = units - (1)
                WHERE _id = :id"
            );

            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            return ($update->execute()) ? ['valid' => true] : ['valid' => false];
        } catch (PDOexception $e) {

            return $e->getMessage();
        }
    }
}
