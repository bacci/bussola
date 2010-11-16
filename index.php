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
} elseif($_SESSION['id']) {
    header('Location: acesso.php');
}

if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
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

	header("Location: acesso.php");
	exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bussola ::: Corretora de seguros ltda</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  	<link rel="stylesheet" href="css/slide.css" type="text/css" media="screen" />
	
  	<!-- PNG FIX for IE6 -->
  	<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
	<!--[if lte IE 6]>
		<script type="text/javascript" src="js/pngfix/supersleight-min.js"></script>
	<![endif]-->
	 
    <!-- jQuery - the core -->
	<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
	<!-- Sliding effect -->
	<script src="js/slide.js" type="text/javascript"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/easySlider1.5.js"></script>
<script type="text/javascript" charset="utf-8">
// <![CDATA[
$(document).ready(function(){	
	$("#slider").easySlider({
		controlsBefore:	'<p id="controls">',
		controlsAfter:	'</p>',
		auto: true, 
		continuous: true
	});	
});
// ]]>
</script>
<style type="text/css">
#slider {
	margin:0 42px;
	padding:0;
	list-style:none;
}
#slider ul, #slider li {
	margin:0;
	padding:0;
	list-style:none;
}
/* 
    define width and height of list item (slide)
    entire slider area will adjust according to the parameters provided here
*/
#slider li {
	width:880px;
	height:272px;
	overflow:hidden;
}
p#controls {
	margin:0;
	position:relative;
}
#prevBtn, #nextBtn {
	display:block;
	margin:0;
	overflow:hidden;
	width:41px;
	height:41px;
	position:absolute;
	left:-20px;
	top:-162px;
}
#nextBtn {
	left:940px;
}
#prevBtn a {
	display:block;
	width:41px;
	height:41px;
	background:url(images/l_arrow.gif) no-repeat 0 0;
}
#nextBtn a {
	display:block;
	width:41px;
	height:41px;
	background:url(images/r_arrow.gif) no-repeat 0 0;
}
</style>
</head>
<body>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1><font face="Arial, Helvetica, sans-serif">Bússola Seguros</font></h1>
				<h2><font face="Arial, Helvetica, sans-serif"><em>O Seguro na medida da sua Necessidade</em></font></h2>		
				<p class="grey">Esta é uma área de acesso restrito</p>
			</div>
			<div class="left">
				<!-- Login Form -->
				<form action="index.php" class="clearfix" method="post">
					<h2><font face="Arial, Helvetica, sans-serif">Acesso para Clientes</font></h2>
            <?php
            echo $_SESSION['message'];
            if($_SESSION['msg']['login-err'])
            {
                    echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
                    unset($_SESSION['msg']['login-err']);
            }
            ?>
					<label class="grey" for="log"><font face="Arial, Helvetica, sans-serif">Login:</font></label>
					<input class="field" type="text" name="usuario" id="username" value="" style="color: #000" size="23" />
					<label class="grey" for="pwd"><font face="Arial, Helvetica, sans-serif">Senha:</font></label>
                                        <input class="field" type="password" name="senha" id="password" size="23" style="color: #000" />
	            	<label><input name="lembrarMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;<font face="Arial, Helvetica, sans-serif">Continuar Conectado</font></label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
			  </form>
			</div>
			<div class="left right">			
			</div>
		</div>
</div> <!-- /login -->	

	<!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
			<li class="left">&nbsp;</li>
			<li><font face="Arial, Helvetica, sans-serif">Olá Visitante!</font></li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><font face="Arial, Helvetica, sans-serif">Acesso Restrito</font></a>
				<a id="close" style="display: none;" class="close" href="#"><font face="Arial, Helvetica, sans-serif">Fechar Painel</font></a>			
			</li>
			<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->
<div class="main">
  <div class="header">
    <div class="block_header">
      <div class="RSS"></div>
      <div class="clr"></div>
      <div class="logo"><a href="index.html"><img src="images/logo.gif" width="421" height="143" border="0" alt="logo" /></a></div>
      <div class="menu">
        <ul>
          <li><a href="index.html" class="active"><span class="bgi">Home<span></span></span></a></li>
          <li><a href="empresa.html"><span class="bgi">Empresa<span></span></span></a></li>
          <li><a href="seguros.html"><span class="bgi">Seguros<span></span></span></a></li>
          <li><a href="#"><span class="bgi">Sinistro<span></span></span></a></li>
          <li><a href="contato.html"><span class="bgi">Contato<span></span></span></a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="slider">
    <div class="slice1">
      <div class="slice2" id="slider">
        <ul>
          <li>
            <div>
              <p class="img"><img src="images/img_simple_1.jpg" alt="screen 1" width="309" height="236" /></p>
              <img class="h2top" src="images/tt-02.png" width="448" height="64" alt="img" />
              <p>Saiba por que é importante a prevenção dos bens de sua empresa, conheça nosso sistema integrado de processamento de seguros, específico para a sua necessidade.</p>
              <p>&nbsp;</p>
              <p><a href="#"><img src="images/bt-ler.gif" width="91" height="26" border="0" alt="view" /></a></p>
            </div>
          </li>
          <li>
            <div>
              <p class="img"><img src="images/img_simple_2.jpg" alt="screen 1" width="309" height="236" /></p>
              <img class="h2top" src="images/tt-01.png" width="448" height="64" alt="img" />
              <p>Dicas importantes sobre seguro em geral... O que fazer, para quem ligar, tenha em mãos os números de telefone que você pode usar numa emegência.</p>
              <p>&nbsp;</p>
              <p><a href="#"><img src="images/bt-ler.gif" width="91" height="26" border="0" alt="view" /></a></p>
            </div>
          </li>
          <li>
            <div>
              <p class="img"><img src="images/img_simple_3.jpg" alt="screen 1" width="309" height="236" /></p>
              <img class="h2top" src="images/tt-03.png" width="448" height="64" alt="img" />
              <p>Backup Empresarial de Seguros. Todos os meses a Bússola Seguros gera um arquivo .PDF com a informação individual de cada cliente. Um processo que permite histórico gerencial e customização de valores. Fale com nosso gerente.</p>
              <p>&nbsp;</p>
              <p><a href="#"><img src="images/bt-ler.gif" width="91" height="26" border="0" alt="view" /></a></p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="clr"></div>
  <div class="tip">
    <div class="Menu_resize">
      <p>Fale conosco: +11 3154.7722 | bussola@bussolaseguros.com.br</p>
      <img src="images/Twitter_img_1.jpg" width="26" height="33" alt="img" />
      <p>Siga-nos no Twitter </p>
    </div>
  </div>
  <div class="body">
    <div class="body_resize">
     <div class="What">
        <h2>O que oferecemos</h2>
        <p><span>Por que nos contratar?</span></p>
        <p>Estabilizados desde 1987 no mercado, somos uma empresa séria, que leva ao nosso cliente a facilidade e customização de informação de seguros. A logística utilizada permite fácil acesso ao gerente de conta, criando ambiente transparente aos nossos processos. </p>
        <p><span>Equipe especializada</span> </p>
        <p>Cada empresa tem o seu gerente, que é acompanhado por nosso setor de qualidade no atendimento e metodologia de processos. A certeza de estar em boas mãos é obtida desde o inicio de nosso trabalho. Conte com a Bússola.</p>
     </div>
     <div class="Serv">
     <h2>Serviços</h2>
     <p>A Bússola Seguros dispoem dos seguintes serviços:  </p>
     <ul>
       <li><a href="#">Todos os ramos de Seguros</a></li>
       <li><a href="#">Sinistros</a></li>
       <li><a href="#">Acompanhamento</a></li>
       <li><a href="#">Atualizações</a></li>
     </ul>
     </div>
     <div class="Serv">
       <h2>Fique por dentro!</h2>
       <p>Cada informação gera conhecimento, <a href="#">siga-nos</a> e fique por dentro do que acontece no meio dos Seguros.</p>
       <p><img src="images/Twitter_img_2.jpg" width="147" height="52" alt="img" /></p>
       <p>Bussola ::: Corretora de Seguros Ltda<br />
        Rua Conselheiro Crispiniano, 53, 4 andar<br />
        01037-001, Centro, São Paulo - SP</p>
       <p>+(11)3154-7722<br />
         +(11)3104-0063<br />
        <a href="#">bussola@bussolaseguros.com.br </a></p>
     </div>
      <div class="clr"></div>
      <div class="bg"></div>
       <div class="What">
        <h2>Informativo</h2>
        <p>As Seguradoras não estão aceitando seguro de veículos com chassis remarcado ou veículos que já foram objeto de indenização por perda total. Portanto ao adquirir um veículo, se o antigo proprietário for uma Seguradora, não compre sem uma declaração de que o veículo não é fruto de indenização por perda total, a menos que você não tenha intenção de fazer seguro.</p>
        <p><span>-Veículos Usados</span></p>
      </div>
     <div class="Serv">
     <h2>Info Bússola</h2>
     <p>Comunicativo Bússola Seguros ::: Mantendo você informado de novas ações e procedimentos.</p>
     <div class="search">
        <form id="form1" name="form1" method="post" action="">
          <label>
            <input name="q" type="text" class="keywords" id="textfield" maxlength="50" />
            <input name="b" type="image" src="images/bt-subs.gif" class="button" />
          </label>
        </form>
      </div>
     </div>
     <div class="Serv">
       <h2>Case Empresarial</h2>
       <p>“O acompanhamento de minha empresa pela Bússola foi vital para o entendimento do quanto se podia economizar em seguros...”</p>
       <p><span>-John Smith</span></p>
     </div>
    </div>
    <div class="clr"></div>
  </div>
</div>
<div class="footer">
  <div class="resize">
    <p class="footer_logo">&nbsp;</p>
    <div>© Copyright bussolaseguros.com.br | made by <a href="http://iguanabr.com.br/" target="_blank">iguanaBR</a></div>
  </div>
  <p class="clr"></p>
</div>
</body>
</html>