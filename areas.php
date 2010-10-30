<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include('classes/area.class.php');
$arr=new Area();
if($_GET['do']=='excluir'){
    $ide=isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : null;
    $arr2=new Area();
    $arr2->setId($ide);
    $arr2->apagaArea();
    if($arr2->getErro()!=null){
        $_SESSION['message']=$arr2->getErro();
    } else {
        $_SESSION['message']="Área id:$ide apagada com sucesso";
    }
}
$temp=$arr->getArea();


?>
<html>
<head>
<title>Bussola</title>
<link rel=StyleSheet href="lib/css/view.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="lib/jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="lib/jquery/jquery.tablesorter.js"></script>
<script type="text/javascript">
       $(document).ready(function()
		{
			$("#tabela_areas").tablesorter( {
                            sortList: [[1,0]],
                            headers: {
                                2: {
                                    sorter: false
                                }
                            }
                        } );
		}
	);
function confirma(ide){
    if(confirm("Deseja realmente apagar esta área?\nAtenção, todos os arquivos desta área serão perdidos!\nOs usuários continuarão, porém deverão ser realocados em outra área.")){
        window.location.href="areas.php?do=excluir&id="+ide;
        return true;
    } else {
        return false;
    }
}
</script>
</head>
<?
if(strlen($_SESSION['message'])>0){
?>
<div><? echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
<? } ?>
<body>
    <a href="areas_cad.php">Cadastrar nova Área</a><br />

    <table id="tabela_areas" class="tablesorter">
    <thead>
        <th>Id</th>
        <th>Nome</th>
        <th>Opção</th>
    </thead>
    <tbody>
    <?
    foreach($temp as $obj){
    ?>
    <tr>
        <td><? echo $obj->getId(); ?></td>
        <td><? echo $obj->getNomeArea(); ?></td>
        <td><a href="#" onclick="confirma(<? echo $obj->getId(); ?>)" title="Excluir"><img src="lib/img/excluir.gif" border="0" /></a>
            <a href="areas_cad.php?do=editar&id=<? echo $obj->getId(); ?>" title="Alterar"><img src="lib/img/edit.jpg" border="0" /></a></td>
    </tr>
    <?
    }
    ?>
    </tbody>
</table>

</body>
</html>
