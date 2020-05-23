<?php 

class Database {

    private string $driver;
    private string $host;
    private int $port;
    private string $user;
    private string $pass;
    private string $database;
    private string $charset;
    
    public function __construct() {
        
        require_once 'libs/Dotenv.php';

        $dotenv = new DotEnv('.env');
        $env = $dotenv->env();
        
        $this->driver = $env['DRIVER'];
        $this->host = $env['HOST'];
        $this->port = $env['PORT'];
        $this->user = $env['USER'];
        $this->pass = $env['PASS'];
        $this->database = $env['DATABASE'];
        $this->charset = $env['CHARSET'];
    }

    public function connect() {
        try{
            $connection = new PDO("$this->driver:host=$this->host:$this->port; dbname=$this->database; charset=$this->charset", $this->user, $this->pass, [PDO::ATTR_PERSISTENT => false] );
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;

        }catch(PDOexception $e) {
            echo('Error al conectar con la base de datos, '.$e->getMessage());
            die();
        }
    }
}

?>