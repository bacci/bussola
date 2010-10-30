<?
include('usuario.php');
include_once('classes/usuarios.class.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
$arr=new Usuarios();
if($_GET['do']=='excluir'){
    $ide=isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : null;
    $arr2=new Usuarios();
    $arr2->setId($ide);
    $arr2->apagaUsuario();
    if($arr2->getErro()!=null){
        $_SESSION['message']=$arr2->getErro();
    } else {
        $_SESSION['message']="Usuário id:$ide apagado com sucesso";
    }
}
$temp=$arr->getUsuario();


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
			$("#tabela_usuarios").tablesorter( {
                            sortList: [[1,0]],
                            headers: { 
                                5: { 
                                    sorter: false 
                                } 
                            }
                        } );
		}
	);

function confirma(ide){
    if(confirm("Deseja realmente apagar este usuário?")){
        window.location.href="usuarios.php?do=excluir&id="+ide;
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
    <a href="usuarios_cad.php">Cadastrar novo Usuário</a><br />

<table id="tabela_usuarios" class="tablesorter">
    <thead>
        <th>Id</th>
        <th>Nome</th>
        <th>Login</th>
        <th>Area</th>
        <th>Logado em</th>
        <th>Opção</th>
    </thead>
    <tbody>
    <?
    foreach($temp as $obj){
    ?>
    <tr>
        <td><? echo $obj->getId(); ?></td>
        <td><? echo $obj->getNome(); ?></td>
        <td><? echo $obj->getLogin(); ?></td>
        <td><? echo $obj->getArea() ?></td>
        <td><?
        if($obj->getLastLogin()==null){
            echo "Nunca";
        } else {        
            echo $obj->getLastLogin();
        }?></td>
        <td><a href="#" onclick="confirma(<? echo $obj->getId(); ?>)" title="Excluir"><img src="lib/img/excluir.gif" border="0" /></a>
            <a href="usuarios_cad.php?do=editar&id=<? echo $obj->getId(); ?>" title="Alterar"><img src="lib/img/edit.jpg" border="0" /></a></td>
    </tr>
    <?
    }
    ?>
    </tbody>
</table>

</body>
</html>
