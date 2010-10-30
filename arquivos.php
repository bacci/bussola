<?
include('usuario.php');
if($_SESSION['usertype']){
    $area="all";
} else {
    $area=$_SESSION['area'];
}
include('classes/arquivo.class.php');

$arr=new Arquivo();
if($_GET['do']=='excluir'){
    $ide=isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : null;
    $arr2=new Arquivo();
    $arr2->id=$ide;
    $arr2->area=$area;
    $arr2->apagaArquivo();
    if($arr2->erro!=null){
        $_SESSION['message']=$arr2->erro;
    }
}
if($_GET['do']=='download'){
//    $arquivo=$_GET['nome'];
//    $pasta=$_GET['pasta'];
//    $arr->download($pasta, $arquivo, true);
    //echo $_SESSION["message"]=$_GET['id'].'--'. $area;
    //$teste=$arr->getArquivoById($_GET['id']);
    //echo $teste->area.'--'.$area;

    $arr->download($_GET['id'], $area);

}
$temp=$arr->getArquivoByArea($area);
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
			$("#tabela_arquivos").tablesorter( {
                            sortList: [[0,1]],
                            headers: {
                                6: {
                                    sorter: false
                                }
                            }
                        } );
		}
	);
function confirma(ide){
    if(confirm("Deseja realmente apagar este arquivo?\nAtenção, os arquivos excluídos não poderão ser recuperados!")){
        window.location.href="arquivos.php?do=excluir&id="+ide;
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
    <?
    if($_SESSION['usertype']){
    ?>
    <a href="arquivos_cad.php">Cadastrar novo Arquivo</a><br />
    <?
    }
    ?>
    

    <table id="tabela_arquivos" class="tablesorter">
    <thead>
            <th>Id</th>
            <th>Nome</th>
            <th>Tamanho</th>
            <th>Area</th>
            <th>Descrição</th>
            <th>Enviado em</th>
            <th>Opção</th>
        </thead>
        <tbody>
    <?
    if($temp){
        foreach($temp as $obj){
            echo $thead;
        ?>
        <tr>
            <td><? echo $obj->id; ?></td>
            <td><? echo $obj->nome; ?></td>
            <td><? echo $obj->tamanho; ?></td>
            <td><? echo getNomeArea($obj->area); ?></td>
            <td><? echo $obj->descricao; ?></td>
            <td><?
            if($obj->datacad==null){
                echo "N/A";
            } else {
                echo $obj->datacad;
            }?></td>
            <td>
                <?
                if($_SESSION['usertype']){
                ?>
                <a href="#" onclick="confirma(<? echo $obj->id; ?>)" title="Excluir"><img src="lib/img/excluir.gif" border="0" /></a>
                <?
                }
                ?>
                <a href="arquivos.php?do=download&id=<? echo $obj->id; ?>" title="Download"><img src="lib/img/down.gif" border="0" /></a></td>
        </tr>
        <?
        }
    } else {
    ?>
        <tr>
            <td colspan="6" align="center">Nenhum arquivo encontrado</td>
        </tr>
    <? } ?>
        </tbody>
</table>

</body>
</html>

