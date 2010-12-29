<?
include('usuario.php');

include('classes/arquivo.class.php');

$area_user=$_SESSION['usertype'] ? array('all') : explode(',',$_SESSION['area']);
$opt=$_SESSION['usertype'] ? 4 : 2;


$arr=new Arquivo();
if($_GET['do']=='excluir'){
    $ide=isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : null;
    $arr2=new Arquivo();
    $arr2->id=$ide;
    $arr2->apagaArquivo();
    if($arr2->erro!=null){
        $_SESSION['message']=$arr2->erro;
    }
}
if($_GET['do']=='download'){
	$arr->download($_GET['id'], $area_user);
}
$temp=$arr->getArquivoByArea($area_user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bussola Seguros ::: O seguro na medida da sua necessidade</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
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
                                <?echo $opt; ?>: {
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
      <div class="full_size">
        <p align="left">
            <?
    if($_SESSION['usertype']){
    ?>
    <a href="arquivos_cad.php">Cadastrar novo Arquivo</a><br />
    <?
    }
    ?>
    

    <table id="tabela_arquivos" class="tablesorter">
    <thead>
		<?
		if($_SESSION['usertype']){
		?>
            <th width="15%" height="15">Nome</th>
            <th width="10%" height="15">Tamanho</th>
		<? } ?>
            <th width="40%" height="15">Descrição</th>
            <th width="14%" height="15">Enviado em</th>
            <th width="20%" height="15">Opção</th>
        </thead>
        <tbody>
    <?
    if($temp){
        foreach($temp as $obj){
            echo $thead;
        ?>
        <tr>
			<?
			if($_SESSION['usertype']){
			?>
            <td><? echo $obj->nome; ?></td>
            <td><? 
				$tam=$obj->tamanho/1024;
				echo $tam > 1024 ? round(($tam/1024),1).' Mb' : round($tam).' Kb';
				?>
			</td>
			<? } ?>
            <td><? echo $obj->descricao; ?></td>
            <td><?
            if($obj->datacad==null){
                echo "N/A";
            } else {
                echo $obj->getDatacad();
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
        <p>&nbsp;</p>
		<div class="bg1"></div>
        <p align="right"><a href="index.php?logoff=true"><img src="images/icon-exit.png" alt="img" width="64" height="64" border="0" /></a></p>
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
