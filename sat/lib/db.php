<?php


if (file_exists(__DIR__ . "/server.php")) {
    require_once __DIR__ . "/server.php";
}

class DB {

    private $server;
    private $name;
    private $user;
    private $pass;
    private $charset;

    public function __construct(){
        $this->server   = DB_SERVER;
        $this->name     = DB_NAME;
        $this->user     = DB_USER;
        $this->pass     = DB_PASS;
        $this->charset  = 'utf8mb4';
    }

    // Método para obtener la conexión PDO
    public function conectar() {
       try {
            $dsn = "mysql:host=" . $this->server . ";dbname=" . $this->name . ";charset=" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $pdo = new PDO($dsn, $this->user, $this->pass, $options);
           
        return $pdo;

    }catch(PDOException $e){
        print_r('Error connection: ' . $e->getMessage());
    }   
}

}
