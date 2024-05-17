<?php
require_once 'users.php';
class UserCtrl extends User
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsersCtrl()
    {
        $users = $this->getUsers();
        return $users;
    }
    public function getUserCtrl($id)
    {
        $user = $this->getUserById($id);
        return $user;
    }
    public function createUserCtrl($user)
    {
        $result = $this->createUser($user);
        return $result;
    }
}

