<?php

declare(strict_types=1);

class UserModel extends BaseModel
{

    private int $id;
    private string $name;
    private string $lastname;
    private string $email;
    private string $password;
    private int $idRol;
    private int $idStatus;
    private $image;

    public function __construct()
    {
        $this->table = 'users';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getIdRol()
    {
        return $this->idRol;
    }

    public function setIdRol(int $id_rol): void
    {
        $this->idRol = $id_rol;
    }

    public function getIdStatus()
    {
        return $this->idStatus;
    }

    public function setIdStatus(int $id_status): void
    {
        $this->idStatus = $id_status;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
     */

    private function queryUsers(): array
    {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, $this->table.name, $this->table.lastname, $this->table.email, $this->table._id_rol, $this->table._id_status, $this->table.image, $this->table.created, usr_rol.rol, usr_status.status");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN usr_rol ON $this->table._id_rol = usr_rol._id INNER JOIN usr_status ON $this->table._id_status = usr_status._id");
        $build->setSearch("$this->table.name LIKE :search OR $this->table.lastname LIKE :search OR $this->table.email LIKE :search");

        return $build->query();
    }

    private function passHas(): string
    {
        return password_hash($this->getPassword(), PASSWORD_DEFAULT);
    }

    private function sessionUser($userData): void
    {
        $_SESSION['user_init'] = (int) $userData['_id'];
        $_SESSION['name'] = $userData['name'];
        $_SESSION['lastname'] = $userData['lastname'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['rol'] = (int) $userData['_id_rol'];
        $_SESSION['image'] = $userData['image'];
    }

    private function permissionPage(): void
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT
                    page.name,
                    page_section.title,
                    page_section.control,
                    menu.icon, 
                    concat_ws('/',page.name,page_section.control) as url,
                    menu.orderBy,
                    menu.priority
                FROM 
                $this->table
                INNER JOIN usr_rol
                ON $this->table._id_rol = usr_rol._id
                inner join page_permission 
                on usr_rol._id = page_permission._id_rol
                inner join page_section 
                on page_permission._id_section = page_section._id
                inner join page 
                on page_section._id_page = page._id
                left join menu 
                on page_section._id = menu._id_section
                WHERE 
                $this->table._id = :id and 
                $this->table._id_rol = :idRol and 
                page_section.disabled = :disSection and 
                page.disabled = :disPag 
                order by menu.orderBy"
            );

            $get->bindValue(':id', $_SESSION['user_init'], PDO::PARAM_INT);
            $get->bindValue(':idRol', $_SESSION['rol'], PDO::PARAM_INT);
            $get->bindValue(':disPag', 0, PDO::PARAM_INT);
            $get->bindValue(':disSection', 0, PDO::PARAM_INT);

            $get->execute();

            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            $get = null;
            Database::disconnect();

            $permissionPage = [];
            $menu = [];

            foreach ($result as $page) {

                if (!array_key_exists($page['name'], $permissionPage)) {
                    $permissionPage[$page['name']] = [];
                }

                if (array_key_exists($page['name'], $permissionPage)) {
                    array_push($permissionPage[$page['name']], [
                        'title' => $page['title'],
                        'action' => $page['control']
                    ]);
                }

                $menu[] = [
                    'title' => $page['title'],
                    'controller' => $page['name'],
                    'action' => $page['control'],
                    'icon' => $page['icon'],
                    'url' => $page['url'],
                    'orderBy' => $page['orderBy'],
                    'priority' => $page['priority']
                ];
            }
            $result = null;

            $_SESSION['permission_page'] = $permissionPage;
            $_SESSION['menu'] = $menu;
        } catch (PDOexception $e) {
            Database::disconnect();
            $this->status(500)->error($e->getMessage());
        }
    }

    //  PUBLICS METHODS

    public function create(): array
    {
        try {

            $existEmail = $this->getBy('email', $this->getEmail());

            if (is_null($existEmail['result'])) {
                $this->status(404);
                throw new Exception('El correo "' . $this->getEmail() . '" ya está registrado.');
            }

            $imageUpload = $this->Image('users', $this->getImage());

            if (!$imageUpload['valid']) {
                throw new Exception($imageUpload['errors']);
            }

            $userNew = Database::connect()->prepare(
                "INSERT 
                    INTO $this->table 
                    (name, lastname, 
                    email, password, 
                    _id_status, _id_rol,image) 
                    VALUES (:name, :lastname, 
                    :email, :password, 
                    :idStatus, :idRol, :image)"
            );

            $userNew->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $userNew->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
            $userNew->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $userNew->bindValue(':password', $this->passHas(), PDO::PARAM_STR);
            $userNew->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $userNew->bindValue(':idRol', $this->getIdRol(), PDO::PARAM_INT);
            $userNew->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);

            if ($userNew->execute()) {
                Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '?status=1');
            } else {
                Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '?status=0');
            }
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            return $this->send();
        }
    }

    public function read(): array
    {
        try {

            $get = Database::connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table.name,
                $this->table.lastname,
                $this->table.email,
                $this->table.password,
                $this->table._id_rol,
                $this->table._id_status,
                $this->table.created,
                $this->table.image,
                usr_status.status,
                usr_rol.rol
                FROM
                $this->table
                INNER JOIN
                usr_status
                ON $this->table._id_status = usr_status._id
                INNER JOIN
                usr_rol
                ON $this->table._id_rol = usr_rol._id
                WHERE $this->table._id = :id"
            );

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $get->execute();

            if (!$get->rowCount()) {
                $this->status(404);
                throw new Exception('Usuario no encontrado.');
            }

            $result = $get->fetch(PDO::FETCH_ASSOC);

            $this->success($result);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $get = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function readAll(): array
    {
        return $this->getAllQuery($this->queryUsers());
    }

    public function update()
    {
        try {

            $existEmail = $this->getBy('email', $this->getEmail());

            if (is_null($existEmail['result']) && $existEmail['result']['_id'] != $this->getId()) {
                $this->status(404);
                throw new Exception('El correo "' . $this->getEmail() . '" ya está registrado.');
            }

            $user = $this->read();

            $imageUpload = $this->Image('users', ['CurrentimageName' => $user['image'], 'updateImage' => $this->getImage()], 'update');

            if ($imageUpload['valid']) {
                throw new Exception($imageUpload['errors']);
            }

            $image = !is_null($imageUpload['filename']) ? ', image = :image' : '';

            $update = Database::connect()->prepare(
                "UPDATE 
                    $this->table 
                    SET 
                    name = :name, 
                    lastname = :lastname, 
                    email = :email, 
                    _id_rol = :rol, 
                    _id_status = :status
                    $image
                    WHERE _id = :id"
            );

            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
            $update->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $update->bindValue(':rol', $this->getIdRol(), PDO::PARAM_INT);
            $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);

            if (!is_null($imageUpload['filename'])) {

                $update->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);
            }

            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            if ($update->execute()) {

                if ($_SESSION['user_init'] == $user['_id']) {
                    $this->sessionUser($this->read());
                }
                Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '/' . $_GET['id'] . '?status=1');
            }
            Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '/' . $_GET['id'] . '?status=0');
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } catch (PDOexception $e) {
            $this->status(500)->error($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function updatePassword()
    {
        try {
            $update = Database::connect()->prepare(
                "UPDATE $this->table 
                SET password = :password
                WHERE _id = :id"
            );

            $update->bindValue(':password', $this->passHas(), PDO::PARAM_STR);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            if ($update->execute()) {
                Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '?status=1');
            } else {
                Utils::redirection($_GET['controller'] . '/' . $_GET['action'] . '?status=0');
            }
        } catch (PDOexception $e) {
            $this->fail($e->getMessage());
        } finally {
            $update = null;
            Database::disconnect();
            return $this->send();
        }
    }

    public function verifyPassword(): array
    {
        try {

            $userResponse = $this->read();

            if (!password_verify($this->getPassword(), $userResponse['result']['password'])) {
                throw new Exception('La contraseña actual no es correcta.');
            }

            $this->success(null);
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } finally {
            return $this->send();
        }
    }

    public function login(): array
    {
        try {

            $userResponse = $this->getBy('email', $this->getEmail());
            if (!$userResponse['valid']) {
                $this->status(404);
                throw new Exception('Usuario no encontrado.');
            }

            if ($userResponse['result']['_id_status'] != 1) {
                $this->status(401);
                throw new Exception('El usuario está bloqueado, contacta con el administrador.');
            }

            if (!password_verify($this->getPassword(), $userResponse['result']['password'])) {
                $this->status(401);
                throw new Exception('La contraseña o usuario no es correcto.');
            }

            $this->sessionUser($userResponse['result']);
            $this->permissionPage();
            Utils::redirection();
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        } finally {
            return $this->send();
        }
    }

    public function logout(): void
    {
        unset($_SESSION);
        session_destroy();
        session_regenerate_id(true);
        Utils::redirection('login/index');
    }

    // OTHERS METHODS

    public function paginations(): array
    {
        return $this->pagination('paginations', $this->queryUsers());
    }

    public function getRoles(): array
    {
        return $this->getAllOtherTable('usr_rol');
    }

    public function getStatus(): array
    {
        return $this->getAllOtherTable('usr_status');
    }
}
