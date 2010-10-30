<?
include('usuario.php');
if(!$_SESSION['usertype']){
    header('Location: index.php');
}
include_once('classes/usuarios.class.php');
$action=isset($_GET["do"]) ? $_GET["do"] : null;
$id_usuario=isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : null;
$login_usuario=isset($_POST["login_usuario"]) ? $_POST["login_usuario"] : null;
$senha_usuario=isset($_POST["senha_usuario"]) ? $_POST["senha_usuario"] : null;
$nome_usuario=isset($_POST["nome_usuario"]) ? $_POST["nome_usuario"] : null;
$status_usuario=isset($_POST["status_usuario"]) ? $_POST["status_usuario"] : null;
$area=isset($_POST["area"]) ? $_POST["area"] : null;

if($action=='editar'){
    $id=isset($_GET["id"]) ? $_GET['id'] : null;
    $usuario=new Usuarios();
    $usuario->setId($id);
    $rs=$usuario->getUsuario();
    $id_usuario=$id;
    $nome_usuario=$usuario->getNome();
    $login_usuario=$usuario->getLogin();
    $status_usuario=$usuario->getStatus();
    $area=$usuario->getArea();
}
if($action=='cadastrar'){
        $usuario=new Usuarios();
    if($id_usuario>0){
        $usuario->setId($id_usuario);
        $usuario->setNome($nome_usuario);
        $usuario->setLogin($login_usuario);
        $usuario->setSenha($senha_usuario);
        $usuario->setStatus($status_usuario);
        $usuario->setArea($area);
        if($usuario->alteraUsuario()){
            $_SESSION['message']="Usuário $nome_usuario modificado!";
            header('Location: usuarios.php');
        }
    } else {
        $usuario->setNome($nome_usuario);
        $usuario->setLogin($login_usuario);
        $usuario->setSenha($senha_usuario);
        $usuario->setArea($area);
        if($usuario->insereUsuario()){
            $_SESSION['message']="Usuário $nome_usuario criado com sucesso!";
        }
        header('Location: usuarios.php');
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
    <form method="post" action="usuarios_cad.php?do=cadastrar">
<table  class="table_cad">
    <tr>
        <td colspan="2" align="center" class="titulo">Novo Usuário</td>
    </tr>
    <tr>
        <td class="campo">Id:</td>
        <td><input type="text" name="id_usuario" readonly="readonly" value="<? echo $id_usuario; ?>" /></td>
    </tr>
    <tr>
        <td class="campo">Nome:</td>
        <td><input type="text" name="nome_usuario" value="<? echo $nome_usuario; ?>" /></td>
    </tr>
    <tr>
        <td class="campo">Login:</td>
        <td><input type="text" name="login_usuario" value="<? echo $login_usuario; ?>" /></td>
    </tr>
    <tr>
        <td class="campo">Senha:</td>
        <td><input type="password" name="senha_usuario" value="<? echo $senha_usuario; ?>" /></td>
    </tr>
    
    <tr>
        <td class="campo">Área:</td>
        <td>
            <?
            include 'classes/area.class.php';
            $combo=new Area();
            echo $combo->comboArea($area);
            ?>
            <a href="areas_cad.php">Nova Área</a>
        </td>
    </tr>
    <tr>
        <td class="campo">Status:</td>
        <td>
            <select name="status" style="font-family: arial;">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
            atual: <? echo $status_usuario; ?></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input type="submit" name="submit" class="botao" value="Confimar" /></td>
    </tr>
</table>
</form>

</body>
</html>
