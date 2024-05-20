<?php
class Conexion
{
    private $serverName;
    private $dbName;
    private $dbUser;
    private $dbPass;

    protected $connectionInfo; //* Array de Parametros de Conexion
    protected $conexion; //*objeto conexion

    function __construct()
    {
        $this->serverName = getenv('HOST_form');
        $this->dbName = getenv('DB_form');
        $this->dbPass = getenv('PWD_form');
        $this->dbUser = getenv('USER_form');
        $this->connectionInfo = array(
            "Database" => $this->dbName,
            "UID" => $this->dbUser,
            "PWD" => $this->dbPass,
            'ReturnDatesAsStrings' => true,
            "CharacterSet" => 'utf-8',
            "ConnectionPooling" => 0
        );
        $this->conexion = sqlsrv_connect($this->serverName, $this->connectionInfo);

        if (!$this->conexion) {
            echo "error al conectar con la base de Datos <br>";
            die(print_r(sqlsrv_errors(), true));
        }
    }
    protected function protect_text(string $string)
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);
        return $string;
    }

    protected function validateParams($params, $query)
    {   //Valida que el numero de parametros sea el correcto
        $actualCount = count($params);
        $expectedCount = substr_count($query, '?');

        if ($actualCount !== $expectedCount) {
            throw new Exception("Invalid number of parameters. Expected $expectedCount, got $actualCount.");
        }
    }
    public function getConexion()
    {
        return $this->conexion;
    }

}