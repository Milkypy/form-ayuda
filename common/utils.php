<?php

require_once __DIR__ . '../../db/conexion.php';

/**
 * Clase Utils
 * 
 * Clase que contiene metodos de utilidad para el sistema, comun a todas las clases
 */
class Utils extends Conexion
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Metodo para proteger los datos de entrada
     * 
     * @param string $data
     * @return string
     */
    public function sanitizar(array|string $data): string|array
    {
        //si es un array
        if (is_array($data)) {
            $data = array_map('trim', $data);
            $data = array_map('stripslashes', $data);
            $data = array_map('htmlspecialchars', $data);
            return $data;
        } else {
            //si es un string
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    }

    /**
     * Metodo para validar un email
     * 
     * @param string $email
     * @return bool
     */
    public function validarEmail(string $email): bool
    {
        //regex para validar email
        $email = $this->sanitizar($email);
        $regEX = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
        return preg_match($regEX, $email);
    }

    /**
     * Metodo para validar un password
     * 
     * @param string $password
     * @return bool
     */
    public function validarPassword(string $password): bool
    {
        //regex para validar password
        $password = $this->sanitizar($password);
        $regEX = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/';
        return preg_match($regEX, $password);
    }

    /**
     * Metodo para validar un rut
     * 
     * @param string $rut
     * @return bool
     */
    public function validarRut(string $rut): bool
    {
        //regex para validar rut
        $rut = $this->sanitizar($rut);
        $regEX = '/^[0-9]{7,8}-[0-9Kk]$/';
        return preg_match($regEX, $rut);
    }

    /**
     * Metodo para validar un telefono
     * 
     * @param string $telefono
     * @return bool
     */
    public function validarTelefono(string $telefono): bool
    {
        //regex para validar telefono
        $telefono = $this->sanitizar($telefono);
        $regEX = '/^[0-9]{9}$/';
        return preg_match($regEX, $telefono);
    }

    //obtener sectores
    public function getSectores()
    {
        $sql = "SELECT * FROM sectores";
        $stmt = sqlsrv_query($this->conexion, $sql);
        $sectores = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $sectores[] = $row;
        }
        return $sectores == [] ? 'No hay sectores' : $sectores;
    }

    //obtener items
    public function getItems()
    {
        $sql = "SELECT item_id, item FROM items WHERE estado=1";
        $stmt = sqlsrv_query($this->conexion, $sql);
        $items = array();
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $items[] = $row;
        }
        return $items == [] ? 'No hay items' : $items;
    }


}