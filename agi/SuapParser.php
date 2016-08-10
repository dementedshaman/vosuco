#!/usr/bin/php
<?php
class SuapParser
{

    const DIARIO = 0;
    const DISCIPLINA = 1;
    const CH = 2;
    const TAULAS = 3;
    const TFALTAS = 4;
    const FREQUENCIA = 5;
    const SITUACAO = 6;
    const N1N = 7;
    const N1F = 8;
    const N2N = 9;
    const N2F = 10;
    const MD = 11;
    const NAFN = 12;
    const NAFF = 13;
    const MDF = 14;
    const DISC = 'disciplina';
    const TOT = 'total';

    private $mat;
    private $suap;
    private $dom;
    private $notas;

    function __construct($tools, $mat)
    {
        $this->suap = $tools['suap'];
        $this->mat = $mat;
        $this->dom = new DOMDocument();
        $this->notas = [];
        $this->minerNotas();
    }

    private function minerNotas()
    {
        $html = $this->suap->consume('https://suap.ifrn.edu.br/edu/aluno/'. $this->mat .'/?tab=boletim');
        $classname = 'borda';
        @$this->dom->loadHTML($html);
        $xpath = new DOMXPath($this->dom);

        $tabelaNotas = [];
        $footer = [];
        foreach ($xpath->query ("//table[@class='borda']") as $section)
        {
            $tbody = $section->childNodes[1];
            $tfooter = $section->childNodes[2];

            foreach ($xpath->query (".//tr", $tbody) as $tr)
            {
                $linhaNotas = [];

                foreach ($xpath->query (".//td", $tr) as $td)
                {
                    $linhaNotas[] = trim($td->nodeValue);
                }
                array_pop($linhaNotas);
                $tabelaNotas[$linhaNotas[0]] = $linhaNotas;
            }

            foreach ($xpath->query (".//td", $tfooter) as $ftr)
            {
                $footer[] = trim($ftr->nodeValue);
            }
        }

        $this->notas['disciplina'] = $tabelaNotas;
        $this->notas['total'] = $footer;
    }

    function getNotas()
    {
        return $this->notas;
    }
}


?>
