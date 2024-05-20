<?php
require_once __DIR__ . '/../db/conexion.php';
class User extends Conexion
{
    private $id;
    private $name;
    private $email;

    public function __construct()
    {
        parent::__construct();
    }

    //get user by id
    protected function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = sqlsrv_query($this->getConexion(), $sql, array($id));
        $user = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $user = $row;
        }
        return $user;
    }

    //get all users
    protected function getUsers()
    {
        $sql = "SELECT user_id, nombre, usuario, estado, fecha_creado, last_mod, rol, email FROM usuarios";
        $stmt = sqlsrv_query($this->getConexion(), $sql);
        if (!$stmt) {
            sqlsrv_free_stmt($stmt);
            return sqlsrv_errors()[0]['message'] ?? 'Error al obtener los usuarios';
        }
        $users = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $users[] = $row;
        }
        return $users ?? [];
    }


    //create user
    protected function createUser($user)
    {
        $sql = "INSERT INTO [dbo].[usuarios]
                    ([nombre]
                    ,[email]
                    ,[usuario]
                    ,[pass]
                    ,[rol]
                    ,[estado]
                    ,[fecha_creado]
                    ,[last_mod])
                VALUES
                     (?,?,?,
                        ?,
                     ?,?,?,?)";
        $params = array(
            $user['nombre'],
            $user['email'],
            $user['usuario'],
            $this->hashPassword($user['password']),
            $user['rol'],
            $user['estado'],
            $user['fecha_creado'],
            $user['last_mod']
        );
        $stmt = sqlsrv_prepare($this->getConexion(), $sql, $params);
        if (!$stmt) {
            sqlsrv_close($this->getConexion());
            return array(
                'success' => false,
                'error' => sqlsrv_errors()[0]['message'] ?? 'Error al crear el usuario',
            );

        }
        if (!sqlsrv_execute($stmt)) {
            sqlsrv_close($this->getConexion());
            return array(
                'success' => false,
                'error' => sqlsrv_errors()[0]['message'] ?? 'Error al crear el usuario',
            );
        }
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($this->getConexion());
        return array(
            'success' => true,
            'message' => 'Usuario creado correctamente',
        );
    }

    //update user
    protected function updateUser($user)
    {
        $sql = "UPDATE [dbo].[usuarios]
                SET [nombre] = ?
                    ,[email] = ?
                    ,[usuario] = ?
                    ,[pass] = ISNULL(?, pass)
                    ,[rol] = ?
                    ,[estado] = ?
                    ,[last_mod] = ?
                WHERE user_id = ?";
        $params = array(
            $user['nombre'],
            $user['email'],
            $user['usuario'],
            isset($user['password']) ? $this->hashPassword($user['password']) : null,
            $user['rol'],
            $user['estado'],
            $user['last_mod'],
            $user['user_id']
        );
        $stmt = sqlsrv_query($this->getConexion(), $sql, $params);
        if (!$stmt) {
            sqlsrv_free_stmt($stmt);
            return array(
                'success' => false,
                'error' => sqlsrv_errors()[0]['message'] ?? 'Error al actualizar el usuario',
            );
        }
        sqlsrv_free_stmt($stmt);
        return array(
            'success' => true,
            'message' => 'Usuario actualizado correctamente',
        );
    }

    //delete user
    protected function deleteUser($id)
    {
        $sql = "DELETE FROM [dbo].[usuarios] WHERE user_id = ?";
        $stmt = sqlsrv_query($this->getConexion(), $sql, array($id));
        if (!$stmt) {
            sqlsrv_free_stmt($stmt);
            return array(
                'success' => false,
                'error' => sqlsrv_errors()[0]['message'] ?? 'Error al eliminar el usuario',
            );
        }
        sqlsrv_free_stmt($stmt);
        return array(
            'success' => true,
            'message' => 'Usuario eliminado correctamente',
        );
    }

    private function hashPassword($password)
    {
        //limpiar datos
        $password = strip_tags($password);
        $password = htmlspecialchars($password);
        $password = trim($password);
        return hash('sha256', $password);
    }
}