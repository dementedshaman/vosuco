<?php

class Menu()
{
    $handler

    private __construct($tools)
    {
        $this->handler = $tools['handler'];
    }

	function mainMenu()
	{
        $this->handler->execute_agi("exec Background $files");
        $result = $this->handler->execute_agi("GET DATA beep 1");

        $result = $result['result'];
        $num = $result - 48;

         while (true == true) {
            if ($num > 0 && $num < 4)
            {
                return $num;
            }
            else
            {
                $this->handler->execute_agi("exec Background pbx-invalid");
            }
        };
	}

}

?>
