<?php

class Dbc
{
    private $conString;
    private $pdo;

    function __construct($conString=false)
    {
        $this->pdo = $dbh = new PDO('pgsql:dbname=voip host=127.0.0.1;', 'postgres', 'pgadmin');
    }

    function getPdo()
    {
        return $this->pdo;
    }

    public function insertAluno($mat, $spass)
    {
        $new = ((bool) $this->getByMat($mat)) ? false : true;
        $query = ($new) ? 'INSERT into alunos (matricula, spass) values (:mat, :spass);' : 'UPDATE alunos set spass= :spass where matricula = :mat';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":mat", $mat);
        $stmt->bindParam(":spass", $spass);
        $stmt->execute();
    }

    public function getAll()
    {
        $query = 'SELECT * FROM alunos';
        $stmt = $this->pdo->prepare($query);
        $alunos = $stmt->execute();
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $alunos;
    }

    public function getByMat($mat)
    {
        $query = 'SELECT * FROM alunos where matricula = :mat;';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":mat", $mat);
        $stmt->execute();
        $alunos = $stmt->fetch(PDO::FETCH_ASSOC);
        return $alunos;
    }

    function getDbc()
    {
        if (!$this->pdo)
        {
            $this->startConn();
        }
        return $this->pdo;
    }

}

?>
