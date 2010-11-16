<?
include('usuario.php');

if(!$_SESSION['usertype']==1){
    $area="all";
} else {
    $area=$_SESSION['area'];
}
include("classes/arquivo.class.php");
error_reporting(E_ALL);
//define os tipos permitidos
$tipos[0]=".pdf";
$tipos[1]=".xls";
$tipos[2]=".doc";
$tipos[3]=".docx";
$tipos[4]=".xlsx";

//define o tamanho máximo permitido
$max_size=1000000; // em bytes

if(isset($_FILES['userfile']))
{
  $area=isset($_POST['area']) ? $_POST['area'] : null;
  $descricao=isset($_POST['descricao']) ? mysql_escape_string($_POST['descricao']) : null;
  $upArquivo = new Arquivo();
  if($upArquivo->UploadArquivo($_FILES['userfile'], "arquivos/area_".$area."/", $tipos, $area, $descricao))
  {
    $area = $upArquivo->area;
    $descricao = $upArquivo->descricao;
    $nome = $upArquivo->nome;
    $pasta = $upArquivo->pasta;
    $tipo = $upArquivo->tipo;
    $tamanho = $upArquivo->tamanho;
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
        <p align="left"><?
if(strlen($_SESSION['message'])>0){
?>
<div><? echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<? } ?>
<table>
    <tr>
        <td class="campo">Nome da Área ao qual o Arquivo foi Enviado:</td><td><?php echo $area ?></td>
    </tr>
    <tr>
        <td class="campo">Nome do Arquivo Enviado:</td><td><?php echo $nome ?></td>
    </tr>
    <tr>
        <td class="campo">Tipo do Arquivo Enviado:</td><td><?php echo $tipo ?></td>
    </tr>
    <tr>
        <td class="campo">Tamanho do Arquivo Enviado:</td><td><?php echo $tamanho ?></td>
    </tr>
</table>
<br/>
<form action="arquivos_cad.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="<? echo $max_size; ?>">
<table  class="table_cad">
    <tr>
        <td colspan="2" align="center" class="titulo">Enviar arquivo</td>
    </tr>
    <tr>
        <td class="campo">Arquivo:</td>
        <td><input type="file" name="userfile" /></td>
    </tr>
    <tr>
        <td class="campo">Descrição:</td>
        <td><textarea name="descricao"></textarea></td>
    </tr>
    <tr>
        <td class="campo">Área:</td>
        <td><?
        include('classes/area.class.php');
        $arr=new Area();
        echo $arr->comboArea($area);
        ?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" value="Enviar Arquivo" class="botao" /></td>
    </tr>
</table>
</form>
        <p>&nbsp;</p>
      </div>
      <div class="Serv">
      <h2>Nota</h2>
      <p>Ao enviar novo arquivo, é <strong>importante</strong>:</p>
	<ul>
    <li>Definir sua área de Permissão</li>
    <li>Confirmar a área de Permissão</li>
    <li>Descrição de forma resumida</li>
	<li>Usar formato .PDF ou .XLS</li>
    </ul>
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