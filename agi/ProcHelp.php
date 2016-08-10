<?php

class ProcHelp
{
    const APACHE_RELOAD = 1;
    const APACHE_RESTART = 2;
    const DIALPLAN_RELOAD = 3;
    const SIP_RELOAD = 4;
    const ASTERISK_RELOAD = 5;

    private $loc;

    function __construct($loc = false)
    {
        if (!$loc)
        {
            $loc = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Utils' . DIRECTORY_SEPARATOR . 'execroot';
        }

        $this->loc = $loc;
    }

    function runCmd($mod)
    {
        exec($this->loc . ' ' . $mod);
    }
}
