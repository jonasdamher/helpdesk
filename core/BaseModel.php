<?php

declare(strict_types=1);

class BaseModel extends Validator
{

    protected string $table;

    // METHOS PRIVATES

    private function tableTotalRows($query)
    {

        $from = $query['from'];
        $inners = $query['inners'];
        $where = $query['where'];

        $get = Database::connect()->prepare("SELECT COUNT(*) FROM $from $inners $where");

        if (array_key_exists('search', $query['exec']) && !is_null($query['exec']['search'])) {

            $get->bindValue(':search', $query['exec']['search'], PDO::PARAM_STR);
        }

        if (array_key_exists('filter', $query['exec']) && !is_null($query['exec']['filter'])) {

            $get->bindValue(':filter', $query['exec']['filter'], PDO::PARAM_STR);
        }

        if (array_key_exists('id', $query['exec']) && !is_null($query['exec']['id'])) {

            $get->bindValue(':id', $query['exec']['id'], PDO::PARAM_INT);
        }

        $get->execute();

        return $get->fetchColumn();
    }

    // LIBS IN DIR libs/

    protected function pagination(string $method, array $query)
    {

        $rows = $this->tableTotalRows($query);
        require_once 'libs/Pagination.php';
        $pagination = new Pagination($rows);

        return $pagination->$method();
    }

    protected function Image(string $dir, $imageName, $type = 'new')
    {
        require_once 'libs/Image.php';
        $image = new Image($dir, $imageName, $type);
        return $image->upload();
    }

    // FINAL LIBS

    // METHODS CURRENT TABLE

    // GET BY SEARCH, FILTER, ORDER AND PER PAGE

    protected function getAllQuery(array $query)
    {
        try {

            $select = $query['select'];
            $from = $query['from'];
            $inners = $query['inners'];
            $where = $query['where'];
            $order = $query['order'];
            $pagination = $this->pagination('page', $query);

            $get = Database::connect()->prepare("SELECT $select FROM $from $inners $where ORDER BY $order LIMIT :offset, :limit");

            if (array_key_exists('search', $query['exec']) && !is_null($query['exec']['search'])) {

                $get->bindValue(':search', $query['exec']['search'], PDO::PARAM_STR);
            }

            if (array_key_exists('filter', $query['exec']) && !is_null($query['exec']['filter'])) {

                $get->bindValue(':filter', $query['exec']['filter'], PDO::PARAM_STR);
            }

            if (array_key_exists('id', $query['exec']) && !is_null($query['exec']['id'])) {

                $get->bindValue(':id', $query['exec']['id'], PDO::PARAM_INT);
            }

            $get->bindValue(':offset', $pagination['offset'], PDO::PARAM_INT);
            $get->bindValue(':limit', $pagination['limit'], PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // GET ALL
    protected function getAll()
    {
        try {
            $get = Database::connect()->prepare("SELECT * FROM $this->table");
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // GET ALL BY FIELD OR ID

    protected function getAllOtherById($where, $field)
    {
        try {
            $get = Database::connect()->prepare("SELECT * FROM $this->table WHERE $where = :id");
            $get->BindValue(':id', $field, PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // GET BY FIELD

    protected function getBy(string $where, string $field)
    {
        try {
            $get = Database::connect()->prepare("SELECT * FROM $this->table WHERE $where = :where");
            $get->bindValue(':where', $field, PDO::PARAM_STR);
            $get->execute();

            if (!$get->rowCount()) {
                throw new Exception('No se pudo encontrar.');
            }

            $result = $get->fetch(PDO::FETCH_ASSOC);
             $this->status(200)->success($result);
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

    // GET BY ID

    protected function getById(int $id)
    {
        try {
            $get = Database::connect()->prepare("SELECT * FROM $this->table WHERE _id = :id");
            $get->bindValue(':id', $id, PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // DELETE

    protected function deleteById(int $id)
    {
        try {
            $delete = Database::connect()->prepare("DELETE FROM $this->table WHERE _id = :id");
            $delete->bindValue(':id', $id, PDO::PARAM_INT);

            if (!$delete->rowCount()) {
                throw new Exception('No se pudo encontrar.');
            }
            $this->status(200)->success($id);
        } catch (Exception $e) {
            $this->status(404)->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $delete = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // FINAL CURRENT TABLE

    // METHODS OTHER TABLES
    // GET ALL BY FIELD

    protected function getByOtherTable(string $table, string $where, string $field)
    {
        try {
            $get = Database::connect()->prepare("SELECT * FROM $table WHERE $where = :where");
            $get->bindValue(':where', $field, PDO::PARAM_STR);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    // GET ALL

    protected function getAllOtherTable(string $table)
    {
        try {
            $get = Database::connect()->prepare('SELECT * FROM ' . $table);
            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);

            $this->status(200)->success($result);
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }
}
