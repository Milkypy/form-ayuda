<?php
require_once __DIR__ . '../../models/users.php';
class UserCtrl extends User
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsersCtrl()
    {
        $users = $this->getUsers();

        if (!is_array($users)) {
            return array('error' => $users);
        }

        if ($users == null || empty($users)) {
            return array('error' => 'No hay usuarios registrados');
        }
        return $users;
    }
    public function getUserCtrl($id)
    {
        $user = $this->getUserById($id);
        return $user;
    }
    public function createUserCtrl($user)
    {
        //limpiar datos
        $user = array_map('trim', $user);
        $user = array_map('strip_tags', $user);
        $user = array_map('htmlspecialchars', $user);
        $user = array_map('ucfirst', $user);
        $user = array_map('ucwords', $user);
        $user = array_map('strtolower', $user);

        //agregar estado y fecha de creación y modificación
        $user['estado'] = 1;
        $user['fecha_creado'] = new DateTime('now');
        $user['last_mod'] = new DateTime('now');

        return $this->createUser($user);
    }

    public function updateUserCtrl($user)
    {
        //limpiar datos
        $user = array_map('trim', $user);
        $user = array_map('strip_tags', $user);
        $user = array_map('htmlspecialchars', $user);
        $user = array_map('ucfirst', $user);
        $user = array_map('ucwords', $user);
        $user = array_map('strtolower', $user);

        //agregar fecha de modificación
        $user['last_mod'] = new DateTime('now');

        return $this->updateUser($user);
    }

    public function deleteUserCtrl($id)
    {
        //limpiar datos
        $id = strip_tags($id);
        $id = htmlspecialchars($id);
        $id = trim($id);
        return $this->deleteUser($id);
    }
}

