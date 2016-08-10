#!/usr/bin/php
<?php

require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'Dbc.php');

class TestDbc
{
    private $dbc;

    function __construct()
    {
        $this->dbc = new Dbc();
    }

    public function testAll()
    {
        // $this->dbc->insertAluno('123', '456');
        // $this->dbc->insertAluno('654', '321');
        $result = $this->dbc->getByMat('20151014050006');
        return $result;
    }

    public function cleanUp()
    {
        $query = 'DELETE FROM alunos';
        $pdo = $this->dbc->getPdo();
        $pdo->query($query);
    }
}

$t = new TestDbc();
var_dump($t->testAll());
// $t->cleanUp();


?>
