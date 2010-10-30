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
<html>
<head>
<title>Bussola</title>
<link rel=StyleSheet href="lib/css/style.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?
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
</body>
</html>