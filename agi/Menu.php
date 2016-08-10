<?php

class Menu()
{

    $suap = new Suap();
    $agi = new Agi();
    $dbc = new Dbc();

    private __construct()
    {

    }

    function closeup()
    {
        $this->handle->endConversation();
    }

	function mainMenu()
	{
	  for ($i=0; $i==3; $i++)
	  {
	    $log = login();
	    if ($log) break;
	  }
	  if(! $log) menuErrorExit();
	  prepare();

	  do
	  {

	  } while ($a <= 10);

	  closeup();
	}

	function login()
    {
        $cred = $his->agi->collectCredentials();
        $this->SuapCred = $this->dbc->reatriveSuapCredentials();
        $this->suapConn = $this->suap->connect();
    }

    function prepare()
    {
        $this->classes = $this->suap->collectClasses();
    }

	function menuMineClass()
    {
        foreach ($this->classes as $class)
        {
            $stringMenu = '';
            $this->agi()->say($stringMenu);
        }

        $this->agi()->collectClass();

    }

	function menuMineClassGrade()
    {

    }

	function menuMineClassMiss()
    {

    }

	function menuMineClassStatus()
    {

    }
}

?>
