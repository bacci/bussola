<?php
session_name('aaLogin');
// Iniciando a sess�o

session_set_cookie_params(2*7*24*60*60);
// Definindo o validade do cookie por 2 semanas

session_start();

include_once('classes/usuarios.class.php');

if($_SESSION['id'] && !isset($_COOKIE['aaLembrar']) && !$_SESSION['lembrarMe'])
{
	// Se voc� est� logado, mas n�o tem o cookie aaLembrar (restart do navegador)
	// e voc� n�o marcou o checkbox lembrarMe (continuar conectado):

	$_SESSION = array();
	session_destroy();

	// Destr�i a sess�o
}

if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();

	header("Location: index.php");
	exit;
}

if($_POST['submit']=='Login')
{
	// Checando se o formulário Login form foi enviado

	$err = array();
	// Outros erros


	if(!$_POST['usuario'] || !$_POST['senha'])
		$err[] = 'Todos os campos devem ser preenchidos!';

	if(!count($err))
	{
		// Limpando poss�veis c�digos maliciosos
		$user=new Usuarios();
		$user->setLogin($_POST['usuario']);
		$user->setSenha($_POST['senha']);
                //echo $user->getLogin().$user->getSenha();
		if($user->checkUser())
		{
			// Se tudo esta OK, login

                        $_SESSION['nome']=$user->getNome();
                        $_SESSION['login']=$user->getLogin();
                        $_SESSION['area']=$user->getArea();
						$_SESSION['empresa']=$user->getEmpresa();
                        $_SESSION['usertype']=$user->getIsAdmin();
			$_SESSION['id'] = $user->getId();
			$_SESSION['lembrarMe'] = $_POST['lembrarMe'];

			// Armazena algum dado na sess�o

			setcookie('aaLembrar',$_POST['lembrarMe']);
		}
		else {
                    $err[]=$_SESSION['message'];
                    unset($_SESSION['message']);
                }
	}

	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Salva a mensagem de erro na sess�o

	header("Location: index.php");
	exit;
}

?>
<form action="logmein.php" method="post">
        <h1>Login de Membros</h1>

            <?php
            echo $_SESSION['message'];
            if($_SESSION['msg']['login-err'])
            {
                    echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
                    unset($_SESSION['msg']['login-err']);
            }
            ?>

        <label class="grey" for="usuario">Usuário:</label>
        <input class="field" type="text" name="usuario" id="username" value="" size="23" />
        <label class="grey" for="password">Senha:</label>
        <input class="field" type="password" name="senha" id="password" size="23" />
<label><input name="lembrarMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Continuar conectado</label>
<div class="clear"></div>
        <input type="submit" name="submit" value="Login" class="bt_login" />
</form>
