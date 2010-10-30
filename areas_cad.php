<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include('classes/area.class.php');
$action=isset($_GET["do"]) ? $_GET["do"] : null;
$id_area=isset($_POST["id_area"]) ? mysql_real_escape_string($_POST["id_area"]) : null;
$nome_area=isset($_POST["area"]) ? mysql_real_escape_string($_POST["area"]) : null;

if($action=='editar'){
    $id=isset($_GET["id"]) ? mysql_real_escape_string($_GET['id']) : null;
    $area=new Area();
    $area->setId($id);
    $rs=$area->getArea();
    $id_area=$id;
    $nome_area=$rs->getNomeArea();
}
if($action=='cadastrar'){
        $area=new Area();
    if($id_area>0){
        $area->setId($id_area);
        $area->setNomeArea($nome_area);
        $area->alteraArea();
        $_SESSION['message']="Área $nome_area modificada!";
        header('Location: areas.php');
    } else {
        $area->setNomeArea($nome_area);
        $area->insereArea();
        $_SESSION['message']="Área $nome_area criada com sucesso!";
        header('Location: areas.php');
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
    <form method="post" action="areas_cad.php?do=cadastrar">
<table class="table_cad">
    <tr>
        <td colspan="2" align="center" class="titulo">Nova Área</td>
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

</body>
</html>
