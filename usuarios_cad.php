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
$empresa=isset($_POST["empresa"]) ? $_POST["empresa"] : null;
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
	$empresa=$usuario->getEmpresa();
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
		$usuario->setEmpresa($empresa);
        if($usuario->alteraUsuario()){
            $_SESSION['message']="Usuário $nome_usuario modificado!";
            header('Location: usuarios.php');
        }
    } else {
        $usuario->setNome($nome_usuario);
        $usuario->setLogin($login_usuario);
        $usuario->setSenha($senha_usuario);
        $usuario->setArea($area);
		$usuario->setEmpresa($empresa);
        if($usuario->insereUsuario()){
            $_SESSION['message']="Usuário $nome_usuario criado com sucesso!";
        }
        header('Location: usuarios.php');
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
<script type="text/javascript" src="js/principal.js"></script>
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
        <p align="left"><form method="post" action="usuarios_cad.php?do=cadastrar">
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
        <td class="campo">Área:</td>
        <td>
            <select name="listAreas" onChange="alert(this.value);">
            <option id="opcoes" value="0">--Primeiro selecione a empresa--</option>
	     </select>
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
        <p>&nbsp;</p>
      </div>
      <div class="Serv">
      <h2>Nota</h2>
      <p>Ao cadastrar novo usuário, lembre-se:</p>
	<ul>
    <li>Definir sua área de Acesso</li>
    <li>Definir e guardar sua senha</li>
	<li>Nome deve diferir do Login</li>
    </ul>
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
