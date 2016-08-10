#!/usr/bin/php
<?php

require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'ProcHelp.php');

class TestProcHelp
{
    private $p;

    function __construct()
    {
        $this->p = new ProcHelp();
    }

    function testApacheReload()
    {
        $this->p->runCmd(ProcHelp::APACHE_RELOAD);
    }

    function testApacheRestart()
    {
        $this->p->runCmd(ProcHelp::APACHE_RESTART);
    }

    function testAsteriskRestart()
    {
        $this->p->runCmd(ProcHelp::ASTERISK_RELOAD);
    }

}

$t = new TestProcHelp();
$t->testAsteriskRestart();

?>
