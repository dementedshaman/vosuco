<?php

class Falta{
    private $handler;
    private $notas;

    public function __construct($tools){
        $this->handler = $tools['handler'];
            $this->notas = $tools['notas'];
    }

    function get_falta($diario){

        $TFALTAS = $this->notas['disciplina'][$diario][4];
        $TAULAS = $this->notas['disciplina'][$diario][3];
        $FREQUENCIA = $this->notas['disciplina'][$diario][5];

        $FALTA = (100-$FREQUENCIA);

        //echo "O total de aulas ministradas é de $TAULAS\n";
        $this->handler->execute_agi('STREAM FILE grupo3/au1 ""');
        $this->handler->execute_agi('SAY NUMBER '.$TAULAS.' ""');
        $this->handler->execute_agi('STREAM FILE grupo3/au2 ""');

        //echo "Seu total de faltas na disciplina é de $TFALTAS\n";
        $this->handler->execute_agi('STREAM FILE grupo3/fal ""');
        $this->handler->execute_agi('SAY NUMBER '.$TFALTAS.' ""');

        //echo "Sua percentual de falta é de $FALTA%\n";
        $this->handler->execute_agi('STREAM FILE grupo3/porc1 ""');
        $this->handler->execute_agi('SAY NUMBER '.$FALTA.' ""');
        $this->handler->execute_agi('STREAM FILE grupo3/porc2 ""');

        $TPFALTAS = ($this->notas['total'][2]*0.25); //Total referente aos 25%
        $TFFALTAS = ($this->notas['total'][3]); //Total de faltas

        if($TFFALTAS>=$TPFALTAS){
            //echo "Você está reprovado por falta\n";
            $this->handler->execute_agi('STREAM FILE grupo3/rep ""');
        }else{
            $PODEFALTAR = $TPFALTAS-$TFFALTAS;
            //echo "Você pode faltar ".intval($PODEFALTAR)."\n";
            $this->handler->execute_agi('STREAM FILE grupo3/pofal1 ""');
            $this->handler->execute_agi('SAY NUMBER '.$PODEFALTAR.' ""');
            $this->handler->execute_agi('STREAM FILE grupo3/pofal2 ""');
        }

    }

}
?>
