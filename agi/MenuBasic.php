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
          $arr = ['diario' => $value[0], 'cod'=>$vcn[1]];
          array_push($general, $arr);
        }

        $max = range(1, count($general));
        $mini = array_combine($max, $general);

        $okay = $this->makeMenu($mini);
        return $okay;
    }

  function makeMenu($info)
    {
        $files = "";
        foreach ($info as $key => $value) {
            $code = $value['cod'];
            $files = $files. "grupo2/$key&grupo2/disc&grupo2/mat/$code&silence/2&";
          }

        $files = substr_replace($files, "", -1);

        $this->handler->execute_agi("exec Background $files");
        $result = $this->handler->execute_agi("GET DATA beep 1");

        $result = $result['result'];
        $num = $result - 48;

        if ($info[$num]) {
          $teste = $info[$num];
          $diario = $teste['diario'];
          return $diario;
        }
        $this->handler->execute_agi("EXEC Background grupo2/0&grupo2/final");
        $zerar = $this->handler->execute_agi("GET DATA beep 1");
        $zerar = $zerar['result'];
        $zerou = $zerar - 48;
        if ($zerou=="0") {
          $this->reduce();
        }
  }
}
?>
