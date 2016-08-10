<?php

require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'Suap.php');
require_once(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'agi' . DIRECTORY_SEPARATOR . 'Dbc.php');

$title = "VoIP";

if (isset($_POST["submit"])) {
    $errMatricula = (!$_POST['matricula']) ? 'Matricula Obrigatória' : false;
    $errSenhaSuap = (!$_POST['senhas']) ? 'Senha do Suap obrigatória': false;
    $errSenha = (!$_POST['senha']) ? 'Senha Obrigatória': false;
    $errSenhaLen = (sizeof($_POST['senha']) > 5) ? 'O campo senha soh pode ter no max 5 digitos': false;
    $errSenhaNum = (!is_numeric($_POST['senha'])) ? 'O campo senha apenas pode conter numeros': false;
    $errSenhaConf = (!$_POST['senhac']) ? 'Confirmação de Senha Obrigatória': false;
    $errSenhaComb = (!$_POST['senha'] && !$_POST['senhaConf']) ? 'A senha e confirmação de senha devem ser iguais': false;

    $matricula = ($_POST['matricula']) ? $_POST['matricula'] : false;
    $senhaSuap =  ($_POST['senhas']) ? $_POST['senhas'] : false;
    $senha = ($_POST['senha']) ? $_POST['senha'] : false;
    $senhaConf = (!$_POST['senhac']) ? $_POST['senhac'] : false;


    if (!$errMatricula && !$errSenhaSuap && !$errSenha && !$errSenhaConf && !$errSenhaComb && !$errSenhaNum && !$errSenhaLen) {
        $suap = new Suap($_POST['matricula'], $_POST['senhas']);
        if ($suap->isLogged())
        {
            $dbc = new Dbc();
            $dbc->insertAluno($matricula, $senhaSuap);
            $alert='success';
            $result='Sua conta foi criada com sucesso.';
            cadastrarVoip($matricula, $senhaSuap, $senha);
            $errSenhaSuap2 = false;
        }else{
            $errSenhaSuap2 = 'Senha do Suap incorreta';
        }
    }else{
        $alert='danger';
        $result='Algum erro aconteceu, por favor cheque os campos do formulario.';
    }

}else{

    $errMatricula = false;
    $errSenhaSuap = false;
    $errSenha = false;
    $errSenhaLen = false;
    $errSenhaNum = false;
    $errSenhaConf = false;
    $errSenhaComb = false;

    $matricula = false;
    $senhaSuap = false;
    $senha = false;
    $senhaConf = false;
}


function echoBom($error)
{
    if ($error != false)
    {
        echo htmlspecialchars($error);
    }
}

function cadastrarVoip($mat, $spass, $vpass)
{
    $sip = "/etc/asterisk/sip.d/$mat.conf";
    if (file_exists($sip))
    {
        unlink($sip);
    }
    $myfile = fopen($sip, "w");
$sipC = <<<EOT
[$mat]
type=friend
context=customagis
secret=$vpass
host=dynamic
callgroup=1
pickupgroup=1
language=pt_BR
callerid="$mat" <$mat>
EOT;
    fwrite($myfile, $sipC);
    fclose($myfile);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap contact form with PHP example by BootstrapBay.com.">
    <meta name="author" content="BootstrapBay.com">
    <title><?php echoBom($title); ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  </head>
  <body>
  	<div class="container">
  		<div class="row">
  			<div class="col-md-6 col-md-offset-3">
  				<h1 class="page-header text-center"><?php echoBom($title); ?> - Cadastro</h1>
                <div class="alert alert-info" role="alert">Para alterar o cadastro basta apenas submeter o formulário novamente.</div>
				<form class="form-horizontal" role="form" method="post" action="index.php">
					<div class="form-group">
						<label for="matricula" class="col-sm-2 control-label">Matricula</label>
						<div class="col-sm-10">
							<input type="number" class="form-control" id="matricula" name="matricula" value="<?php echoBom($_POST['matricula']); ?>">
							<?php echoBom($errMatricula);?>
						</div>
					</div>
					<div class="form-group">
						<label for="senhas" class="col-sm-2 control-label">Senha Suap</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="senhas" name="senhas" value="<?php echoBom($_POST['senhas']); ?>">
							<?php echoBom($errSenhaSuap);?>
							<?php echoBom($errSenhaSuap2);?>
						</div>
					</div>
					<div class="form-group">
						<label for="senha" class="col-sm-2 control-label">Senha VoIP</label>
						<div class="col-sm-10">
							<input type="password" placehold="O campo senha pode ter no maximo 5 numeros" class="form-control" id="senha" name="senha" value="<?php echoBom($_POST['senha']);?>">
							<?php echoBom($errSenha);?>
							<?php echoBom($errSenhaComb);?>
							<?php echoBom($errSenhaLen);?>
							<?php echoBom($errSenhaNum);?>
						</div>
					</div>
					<div class="form-group">
						<label for="senhac" class="col-sm-2 control-label">Confirmação Senha VoIP</label>
						<div class="col-sm-10">
							<input type="password" class="form-control" id="senhac" name="senhac" value="<?php echoBom($_POST['senhac']);?>">
							<?php echoBom($errSenhaConf);?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-10 col-sm-offset-2">
                            <div class="alert alert-<?php echo $alert; ?>" role="alert"><?php echo $result; ?></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
