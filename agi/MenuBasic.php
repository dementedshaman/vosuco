<?php

class MenuBasic
{

    private $notas;
    private $handler;
    //private $menu;

    public function __construct($tools)
    {
        $this->handler = $tools['handler'];
        $this->notas = $tools['notas'];
        //$this->menu = $tools['menu'];
    }

    function reduce()
    {
        $general = [];

        foreach ($this->notas['disciplina'] as $key => $value) {
          $parsed = explode(' - ', $value[1], 2);
          $vcn = split('[/.-]', $parsed[0]);

          $general[$key] = $vcn[1];
        }

        return $this->makeMenu($general);
    }

    function makeMenu($info)
    {
        $audioArr = [];
        $count = 1;
        $menu = [];
        foreach ($info as $key => $value) {
            $code = $value;
            $audioArr[] = "grupo2/$count&grupo2/disc&grupo2/mat/$code&silence/2";
            $menu[$count] = $key;
            $count += 1;
        }

        $files = $audioArr.join('&');

        while (true == true)
        {
            $this->handler->execute_agi("exec Background $files");
            $result = $this->handler->execute_agi("GET DATA beep 1");

            $result = $result['result'];
            $num = $result - 48;

            if ($menu[$num]) {
              return $menu[$num];
            }

            $this->handler->execute_agi("exec Background pbx-invalid");
        } ;

  }
}
?>
