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
require_once(dirname(__FILE__) . '/' . 'Nota.php');
require_once(dirname(__FILE__) . '/' . 'Falta.php');
require_once(dirname(__FILE__) . '/' . 'Menu.php');

$db = new Dbc();
$hand = new Handler ($s_in, $s_out);
$hand->startConversation();
$callerId = $ast->getCallerId();
$aluno = $db->getByMat($callerId);

$matricula = $aluno['matricula'];
$pt = 'TheSecret';
$senha = AesCtr::decrypt($aluno['spass'], $pt, 256);

$suap = new Suap($matricula, $senha);

$tools = ['handler'=>$hand, 'suap'=>$suap];
$suapParser = new suapParser($tools, $matricula);
$notas = $suapParser->getnotas();
$tools['notas'] = $notas;
$sit = new Situacao($tools);
$not = new Nota($tools);
$fal = new Falta($tools);

$menu = new MenuBasic($tools);
$diario = $menu->reduce();

$mm = Menu();
$foo = $mm->mainMenu();
switch ($foo) {
    case 1:
        $fal->get_falta($diario);
        break;
    case 2:
        $not->get_nota($diario);
        break;
    case 3:
        $sit->get_situacao($diario);
        break;
    default:
        $hand->endConversation();
        die;
        break;
}


$hand->endConversation();

?>
