<?php

class Situacao{
	private $handler;
	private $notas;

	public function __construct($tools){
		$this->handler = $tools['handler'];
        $this->notas = $tools['notas'];
	}

	function avaliar ($n1, $n2, $md, $prova_final){
		if(($n1 !== "-") && ($n2 !== "-") && ($prova_final !== "-")){
			$n1 = intval($n1);
			$n2 = intval($n2);
			$md = intval($md);
			$prova_final = intval($prova_final);

			$mdf[0] = ($md+$prova_final)/2;
			$mdf[1] = ((2*$prova_final)+(3*$n2))/5;
			$mdf[2] = ((2*$n1)+(3*$prova_final))/5;

			arsort($mdf);
			$mdf[0] = round($mdf[0]);
			if ($mdf[0]<60){

				$this->handler->execute_agi('STREAM FILE grupo5/4+2 ""');
				$this->handler->execute_agi("SAY NUMBER $mdf[0] \"\"");
			}else{

				$this->handler->execute_agi('STREAM FILE grupo5/4+1 ""');
				$this->handler->execute_agi("SAY NUMBER $mdf[0] \"\"");
			}
		}elseif($n1 !== "-" && $n2 !== "-"){
			$n1 = intval($n1);
			$n2 = intval($n2);
			$md = intval($md);

			if($md>=60){

				$this->handler->execute_agi('STREAM FILE grupo5/3+1 ""');
				$this->handler->execute_agi("SAY NUMBER $md \"\"");
			}elseif (($md > 20) && ($md < 60)){
				$naf[0] = 120 - $md;
				$naf[1] = (300-(3*$n2))/2;
				$naf[2] = (300-(2*$n1))/3;
				asort($naf);
				$naf[0] = round($naf[0]);

				$this->handler->execute_agi('STREAM FILE grupo5/3+2-1 ""');
				$this->handler->execute_agi("SAY NUMBER $md \"\"");
				$this->handler->execute_agi('STREAM FILE grupo5/3+2-2 ""');
				$this->handler->execute_agi("SAY NUMBER $naf[0] \"\"");
			}else{

				$this->handler->execute_agi('STREAM FILE grupo5/3+3 ""');
			}
		}elseif($n1 !== "-" xor $n2 !== "-"){
			if($n1 !== "-"){
				$n1 = intval($n1);
				$n2 = (300-(2*$n1))/3;
				$n2 = round($n2);

				$this->handler->execute_agi('STREAM FILE grupo5/2-1 ""');
				$this->handler->execute_agi("SAY NUMBER $n2 \"\"");
				$this->handler->execute_agi('STREAM FILE grupo5/2-2 ""');
			}else{
				$n2 = intval($n2);
				$n1 = (300-(3*$n2))/2;
				$n1 = round($n1);

				$this->handler->execute_agi('STREAM FILE grupo5/2-1 ""');
				$this->handler->execute_agi("SAY NUMBER $n1 \"\"");
				$this->handler->execute_agi('STREAM FILE grupo5/2-2 ""');
			}
		}else{

			$this->handler->execute_agi('STREAM FILE grupo5/1 ""');
		}
	}

	function get_situacao($diario){

			$n1 = $this->notas['disciplina'][$diario][7];
			$n2 = $this->notas['disciplina'][$diario][9];
			$md = $this->notas['disciplina'][$diario][11];
			$prova_final = $this->notas['disciplina'][$diario][12];

			$this->avaliar($n1, $n2, $md, $prova_final);
	}

}
?>
