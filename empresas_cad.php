<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include('classes/empresa.class.php');
$action=isset($_GET["do"]) ? $_GET["do"] : null;
$id_empresa=isset($_POST["id_empresa"]) ? mysql_real_escape_string($_POST["id_empresa"]) : null;
$nome_empresa=isset($_POST["empresa"]) ? mysql_real_escape_string($_POST["empresa"]) : null;
$mensagem=isset($_POST["mensagem"]) ? mysql_real_escape_string($_POST["mensagem"]) : null;

if($action=='editar'){
    $id=isset($_GET["id"]) ? mysql_real_escape_string($_GET['id']) : null;
    $emp=new Empresa();
    $emp->setId($id);
    $rs=$emp->getEmpresa();
    $id_empresa=$id;
    $nome_empresa=$rs->getEmpresaNome();
	$mensagem=$rs->getMsgEmpresa();
}
if($action=='cadastrar'){
        $emp=new Empresa();
    if($id_empresa>0){
        $emp->setId($id_empresa);
        $emp->setEmpresaNome($nome_empresa);
		$emp->setMsgEmpresa($mensagem);
        $emp->alteraEmpresa();
        $_SESSION['message']="Empresa $nome_empresa modificada!";
        header('Location: empresas.php');
    } else {
        $emp->setEmpresaNome($nome_empresa);
        $emp->insereEmpresa();
        $_SESSION['message']="Empresa $nome_empresa criada com sucesso!";
        header('Location: empresas.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bussola Seguros ::: O seguro na medida da sua necessidade</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link rel=StyleSheet href="lib/css/style.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<div class="main">
  <div class="header">
    <div class="block_header">
      <div class="RSS"></div>
      <div class="clr"></div>
      <div class="logo"><a href="index.php"><img src="images/logo.gif" width="422" height="142" border="0" alt="logo" /></a></div>
      <div class="menu">
        <ul>
          <li><a href="index.php"><span class="bgi">Home</span></a></li>
          <li><a href="empresa.html"><span class="bgi">Empresa</span></a></li>
          <li><a href="seguros.html"><span class="bgi">Seguros</span></a></li>
          <li><a href="#"><span class="bgi">Sinistro</span></a></li>
          <li><a href="contato.html"><span class="bgi">Contato</span></a></li>
        </ul>
      </div>
      <div class="clr"></div>
    </div>
  </div>
  <div class="clr"></div>
  <div class="tip">
    <div class="Menu_resize">
    </div>
  </div>
  <div class="body">
    <div class="body_resize">
      <div class="left_size">
        <p align="left"><br />
    <form method="post" action="empresas_cad.php?do=cadastrar">
<table class="table_cad">
    <tr>
        <td colspan="2" align="center" class="titulo">Nova Empresa</td>
    </tr>
    <tr>
        <td class="campo">Id:</td>
        <td><input type="text" name="id_empresa" size="4" readonly="readonly" value="<? echo $id_empresa; ?>" /></td>
    </tr>
    <tr>
        <td class="campo">Nome da Empresa:</td>
        <td><input type="text" name="empresa" value="<? echo $nome_empresa; ?>" /></td>
    </tr>
	<tr>
        <td class="campo">Mensagem para a Empresa:</td>
        <td><textarea name="mensagem"><? echo $mensagem; ?></textarea></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Confimar" class="botao" /></td>
    </tr>
</table>
</form>
        <p>&nbsp;</p>
      </div>
      <div class="Sub">
      <h2>Nota</h2>
      <p>Crie o novo nome da área ou altere o existente e clique em "Confirmar". O campo ID é altomático, não editável.</p>
      </div>
      <div class="Serv">
      </div>
      <div class="clr"></div>
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