<?php

// require_once(Handler);

class Suap
{
    private $user;
    private $pass;
    private $cookiefile;

    private $csrftoken;
    private $sessionid;
    private $referer;
    private $location;
    private $debug;
    private $logged;

	public function __construct($user, $pass, $debug=false)
	{
        $this->user = $user;
        $this->pass = $pass;

        $this->cleanUp();
        $this->createSession();
	}

    function cleanUp()
    {
        $this->cookiefile="/tmp/suap-$this->user.txt";
        if (file_exists($this->cookiefile))
        {
            unlink($this->cookiefile);
        }

        $this->logged = false;
        $this->csrftoken="";
		$this->sessionid="";
		$this->referer="";
		$this->location="";
		$this->debug=false;
    }

    function createSession()
    {
        $url = 'https://suap.ifrn.edu.br/accounts/login/?next=/';

        $retorno = $this->csuap($url);
        $postdata = http_build_query(
            array(
                'csrfmiddlewaretoken' => $this->csrftoken,
                'username' => $this->user,
                'password'=> $this->pass,
                'this_is_the_login_form' => 1,
                'next' => '/'
            )
        );
        $retorno = $this->csuap($url,"POST",$postdata);
        $fail = 'corretos';
        // $fail = 'Por favor, entre com um usuário e senha corretos. Note que ambos os campos diferenciam maiúsculas e minúsculas.';

        if (strpos($retorno, $fail) === false )
        {
            $url=$this->location;
            $this->logged = true;
            $this->csuap($url,"GET", $postdata);
        }
        else {
            $this->logged = false;
        }
    }

    function isLogged()
    {
        return $this->logged;
    }

    function createCurl($url, $postdata=false)
    {
        $ch = curl_init();

        curl_setopt ( $ch , CURLOPT_AUTOREFERER , true );
    	curl_setopt ( $ch , CURLOPT_CRLF , true );
        curl_setopt ( $ch , CURLOPT_FOLLOWLOCATION , false );
        curl_setopt ( $ch , CURLOPT_HEADER , true );
        curl_setopt ( $ch , CURLINFO_HEADER_OUT , true );
        curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , true );
        curl_setopt ( $ch , CURLOPT_SSL_VERIFYPEER , false );
        curl_setopt ( $ch , CURLOPT_VERBOSE , true );
        curl_setopt ( $ch , CURLOPT_CONNECTTIMEOUT , 5 );
    	curl_setopt ( $ch , CURLOPT_POSTREDIR , 7 );
    	curl_setopt ( $ch , CURLOPT_COOKIEJAR , $this->cookiefile );
    	curl_setopt ( $ch , CURLOPT_COOKIEFILE , $this->cookiefile );
    	curl_setopt ( $ch , CURLOPT_URL , $url );
    	curl_setopt ( $ch , CURLOPT_REFERER , $this->referer );

        if ($postdata)
    	{
            curl_setopt ( $ch , CURLOPT_POST , true );
            curl_setopt ( $ch , CURLOPT_POSTFIELDS , $postdata );
    	}
    	else
    	{
            curl_setopt ( $ch , CURLOPT_POST , false );
            curl_setopt ( $ch , CURLOPT_HTTPGET , true );
    	}

        return $ch;
    }

    function csuap($url, $method='GET', $postdata=false)
    {

    	$response="";

        $ch = $this->createCurl($url, $postdata);

    	$response = curl_exec($ch);

    	if ($response != FALSE)
    	{

    		$separator = "\r\n";
    		$location = "";
    		$line = strtok($response, $separator);

            $vars = [];

    		while ($line !== false)
    		{
    			$t = explode( ':', $line, 2 );
    			if( isset( $t[1] ) )
    			{
    				switch ($t[0])
    				{
    					case "Set-Cookie":
    						$c1 = explode( ';', $t[1], 2 );
    						$c2 = explode( '=',$c1[0], 2 );
    						if( isset( $c2[1] ) )
    						{
    							$c2[0]=trim($c2[0]);
    							$c2[1]=trim($c2[1]);
    							if ($this->debug) echo "$c2[0]=$c2[1]\r\n";
    							$vars[$c2[0]] = $c2[1];
    						}
    						break;
    					case "Location":
    						$c1 = explode( '/', $url);
    						$location=$c1[0] . "//" . $c1[1] . $c1[2] . trim($t[1]);
    						break;
    					default:
    				}
    			}
    			$line = strtok( $separator );
    		}

            $this->sessionid = (array_key_exists('sessionid', $vars)? $vars['sessionid'] : "" );
            $this->csrftoken = (array_key_exists('csrftoken', $vars)? $vars['csrftoken'] : "" );
            $this->referer=$url;
            $this->location = $location;
    	}

    	return $response;
    }

    function consume($url, $method="GET", $postdata=false)
    {
        	$retorno = $this->csuap($url,$method, $postdata);
        	if ($this->location == "https://suap.ifrn.edu.br/accounts/login/?next=/")
        	{
                $this->cleanUp();
                $retorno = $this->createSession();
                $retorno = $this->csuap($url,$method, $postdata);
        	}

        return $retorno;
    }

}



?>
