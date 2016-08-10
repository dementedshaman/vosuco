#!/usr/bin/php
<?php

// ob_implicit_flush(false);
// error_reporting(0);

$s_in = fopen('php://stdin', 'r');
$s_out = fopen('php://stdout', 'w');

require_once(dirname(__FILE__) . '/' . 'Suap.php');
require_once(dirname(__FILE__) . '/' . 'Dbc.php');
require_once(dirname(__FILE__) . '/' . 'Handler.php');
require_once(dirname(__FILE__) . '/' . 'Situacao.php');
require_once(dirname(__FILE__) . '/' . 'SuapParser.php');
require_once(dirname(__FILE__) . '/' . 'MenuBasic.php');

$db = new Dbc();
$hand = new Handler ($s_in, $s_out);
$hand->startConversation();
$callerId = $ast->getCallerId();
$aluno = $db->getByMat($callerId);

$suap = new Suap($aluno['matricula'], $aluno['spass']);

$tools = ['handler'=>$hand, 'suap'=>$suap];
$suapParser = new suapParser($tools, $matricula);
$notas = $suapParser->getnotas();
$tools['notas'] = $notas;

//Menu
$menu = new MenuBasic($tools);
$diario = $sit->reduce();

//Situacao
$sit = new Situacao($tools);
$sit->get_situacao($diario);

$hand->endConversation();

?>
