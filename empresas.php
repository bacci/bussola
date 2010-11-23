<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include('classes/empresa.class.php');
$arr=new Empresa();
if($_GET['do']=='excluir'){
    $ide=isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : null;
    $arr2=new Empresa();
    $arr2->setId($ide);
    $arr2->apagaEmpresa();
    if($arr2->getErro()!=null){
        $_SESSION['message']=$arr2->getErro();
    } else {
        $_SESSION['message']="Empresa id:$ide apagada com sucesso";
    }
}
$temp=$arr->getEmpresa();


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
			$("#tabela_empresas").tablesorter( {
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
    if(confirm("Deseja realmente apagar esta empresa?\nAtenção, todos os arquivos das áreas referente as empresas serão perdidos!\nOs usuários continuarão, porém deverão ser realocados em outra área.")){
        window.location.href="empresas.php?do=excluir&id="+ide;
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
    <a href="empresas_cad.php">Cadastrar nova Empresa</a><br />
    <table id="tabela_empresas" class="tablesorter">
    <thead>
        <th height="20">Id</th>
        <th height="20">Nome da Empresa</th>
		<th height="20">Mensagem</th>
        <th height="20">Opção</th>
    <td></thead>
    <tbody>
    <?
    foreach($temp as $obj){
    ?>
    <tr>
        <td><? echo $obj->getId(); ?></td>
        <td><? echo $obj->getEmpresaNome(); ?></td>
		<td><? echo $obj->getMsgEmpresa(); ?></td>
        <td><a href="#" onclick="confirma(<? echo $obj->getId(); ?>)" title="Excluir"><img src="lib/img/excluir.gif" border="0" /></a>
            <a href="empresas_cad.php?do=editar&id=<? echo $obj->getId(); ?>" title="Alterar"><img src="lib/img/edit.jpg" border="0" /></a></td>
    </tr>
    <?
    }
    ?>
    </tbody>
</table>
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
