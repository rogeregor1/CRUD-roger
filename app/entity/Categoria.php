<?php
namespace app\entity;

use PDO;
use PDOException;
use app\models\mainModel;

class Categoria
{
    private int $catId;
    private string $catName;
    private $db;

    public function __construct(int $catId=null, string $catName="")
    {
        $this->catId = $catId;
        $this->catName = $catName;
        $this->db = mainModel::getInstance()->conectar();
    }
}