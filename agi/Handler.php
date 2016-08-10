<?php

class Handler
{
    private $s_in;
    private $s_out;

    public function __construct($in, $out)
    {
        $this->s_in = $in;
        $this->s_out = $out;

        $agivars = array();
        while (!feof($this->s_in)) {
            $agivar = trim(fgets($this->s_in));
            if ($agivar === '') {
                break;
            }
            else {
                $agivar = explode(':', $agivar);
                $agivars[$agivar[0]] = trim($agivar[1]);
            }
        }

        foreach($agivars as $k=>$v) {
            $this->log_agi("Got $k=$v");
        }

        $this->agivars = $agivars;
    }

    public function getCallerId()
    {
        return $this->agivars["agi_callerid"];
    }

    function execute_agi($command) {

        fwrite($this->s_out, "$command\n");
        fflush($this->s_out);
        $result = trim(fgets($this->s_in));
        $ret = array('code'=> -1, 'result'=> -1, 'timeout'=> false, 'data'=> '');
        if (preg_match("/^([0-9]{1,3}) (.*)/", $result, $matches)) {
            $ret['code'] = $matches[1];
            $ret['result'] = 0;
            if (preg_match('/^result=([0-9a-zA-Z]*)\s?(?:\(?(.*?)\)?)?$/', $matches[2], $match))  {
                $ret['result'] = $match[1];
                $ret['timeout'] = ($match[2] === 'timeout') ? true : false;
                $ret['data'] = $match[2];
            }
        }
        return $ret;
    }

    function log_agi($entry, $level = 1) {
        if (!is_numeric($level)) {
            $level = 1;
        }
        $result = $this->execute_agi("VERBOSE \"$entry\" $level");
    }

    function startConversation()
    {
        $this->execute_agi('ANSWER');
    }

    function endConversation()
    {
        $this->execute_agi('STREAM FILE vm-goodbye ""');
        $this->execute_agi('HANGUP');
        exit;
    }

}

?>
