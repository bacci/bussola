<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include('classes/area.class.php');
$action=isset($_GET["do"]) ? $_GET["do"] : null;
$id_area=isset($_POST["id_area"]) ? mysql_real_escape_string($_POST["id_area"]) : null;
$nome_area=isset($_POST["area"]) ? mysql_real_escape_string($_POST["area"]) : null;
$empresa=isset($_POST["empresa"]) ? mysql_real_escape_string($_POST["empresa"]) : null;

if($action=='editar'){
    $id=isset($_GET["id"]) ? mysql_real_escape_string($_GET['id']) : null;
    $area=new Area();
    $area->setId($id);
    $rs=$area->getArea();
    $id_area=$id;
    $nome_area=$rs->getNomeArea();
	$empresa=$rs->getEmpresa();
}
if($action=='cadastrar'){
        $area=new Area();
    if($id_area>0){
        $area->setId($id_area);
        $area->setNomeArea($nome_area);
		$area->setEmpresa($empresa);
        $area->alteraArea();
        $_SESSION['message']="Área $nome_area modificada!";
        header('Location: areas.php');
    } else {
        $area->setNomeArea($nome_area);
		$area->setEmpresa($empresa);
        $area->insereArea();
        $_SESSION['message']="Área $nome_area criada com sucesso!";
        header('Location: areas.php');
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
    <form method="post" action="areas_cad.php?do=cadastrar">
<table class="table_cad">
    <tr>
        <td colspan="2" align="center" class="titulo">Nova Área</td>
    </tr>
	<tr>
        <td class="campo">Empresa:</td>
        <td>
            <?
            include 'classes/empresa.class.php';
            $combo=new Empresa();
            echo $combo->comboEmpresa($empresa);
            ?>
            <a href="empresas_cad.php">Nova Empresa</a>
        </td>
    </tr>
    <tr>
        <td class="campo">Id:</td>
        <td><input type="text" name="id_area" size="4" readonly="readonly" value="<? echo $id_area; ?>" /></td>
    </tr>
    <tr>
        <td class="campo">Nome da área:</td>
        <td><input type="text" name="area" value="<? echo $nome_area; ?>" /></td>
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