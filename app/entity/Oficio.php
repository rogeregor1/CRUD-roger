<?php
namespace app\entity;

use app\entity\Categoria;
use PDO;
use PDOException;
use app\models\mainModel;

class Oficio
{
    private int $oficioId;
    private string $categoria;
    private string $tipo;
    private $db;

    public function __construct(int $oficioId=null, string $categoria="", string $tipo="")
    {
        $this->oficioId = $oficioId;
        $this->tipo = $tipo;
        $this->categoria = $categoria;
        $this->db = mainModel::getInstance()->conectar();
    }
}