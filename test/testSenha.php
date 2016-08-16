#!/usr/bin/php
<?php
    require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'Aes.php');
    require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'AesCtr.php');

    $timer = microtime(true);

    $pw='chavecriptografia';
    $pt='o segredo';
    $cipher = AesCtr::encrypt($pt, $pw, 256);
    echo "$cipher \r\n";
    $decr = AesCtr::decrypt($cipher, $pw, 256);
    echo "$decr \r\n";
?>
