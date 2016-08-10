<?php

class Nota{
    private $handler;
    private $notas;

    public function __construct($tools){
        $this->handler = $tools['handler'];
            $this->notas = $tools['notas'];
    }

    function get_nota($diario){
        $N1N = $this->notas['disciplina'][$diario][7];
        $N2N = $this->notas['disciplina'][$diario][9];
        $MD = $this->notas['disciplina'][$diario][11];
        //echo "$N1N,$N2N,$MD" ;

        if($N1N=='-'&$N2N=='-'&$MD=='-'){
            //echo "Você não possui nota lançadas na disciplina\n";
            $this->handler->execute_agi('STREAM FILE grupo4/nnota ""');
        return;
        }
        if($N1N!='-'){
            //echo "Sua nota no primeiro bimestre foi $N1N\n";
            $this->handler->execute_agi('STREAM FILE grupo4/pribi ""');
            $this->handler->execute_agi("SAY NUMBER $N1N \"\"");
        return;
        }
        if($N2N!='-'){
            //echo "Sua nota no segundo bimestre foi $N2N\n";
            $this->handler->execute_agi('STREAM FILE grupo4/segbi ""');
            $this->handler->execute_agi("SAY NUMBER $N2N \"\"");
        return;
        }
        if($MD!='-'){
            //echo "Sua nota final foi $MD\n";
            $this->handler->execute_agi('STREAM FILE grupo4/final ""');
            $this->handler->execute_agi("SAY NUMBER $MD \"\"");
        return;
        }
    }

}
?>
