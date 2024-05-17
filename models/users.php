<?php
class User extends Conexion
{
    private $id;
    private $name;
    private $email;

    protected function __construct($id, $name, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    //get user by id
    protected function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = sqlsrv_query($this->conexion, $sql, array($id));
        $user = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $user = $row;
        }
        return $user;
    }

    //get all users
    protected function getUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = sqlsrv_query($this->conexion, $sql);
        if (!$stmt) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al obtener los usuarios';
        }
        $users = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $users[] = $row;
        }
        return $users == [] ? 'No hay usuarios' : $users;
    }


    //create user
    protected function createUser($user)
    {
        $sql = "INSERT INTO [dbo].[users]
                   ([name]
                   ,[email])
                VALUES
                     (?,?)";
        $stmt = sqlsrv_query($this->conexion, $sql, array($user['name'], $user['email']));
        if (!$stmt) {
            return sqlsrv_errors()[0]['message'] ?? 'Error al crear el usuario';
        }
        return 'Usuario creado con éxito';
    }
}