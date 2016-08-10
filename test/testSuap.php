#!/usr/bin/php
<?php

require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'Suap.php');

class TestSuap
{
    private $suap;

    function __construct()
    {
        $this->suap = new Suap('20141014050520','metron.550');
    }

    public function testLogged()
    {
        return $this->suap->consume('https://suap.ifrn.edu.br/edu/aluno/20141014050520/?tab=boletim');
    }
}

$t = new TestSuap();
var_dump($t->testLogged());

?>
