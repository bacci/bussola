<?
include('usuario.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>services</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="main">
  <div class="header">
    <div class="block_header">
      <div class="RSS"></div>
      <div class="clr"></div>
      <div class="logo"><a href="index.html"><img src="images/logo.gif" width="422" height="142" border="0" alt="logo" /></a></div>
      <div class="menu">
        <ul>
          <li><a href="index.html"><span class="bgi">Home</span></a></li>
          <li><a href="#" class="active"><span class="bgi">Administrador</span></a></li>
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
        <h2>Escolha a sua opção:</h2>
		<table width="600" border="0">
  <tr>
    <td width="200">
        <div align="center"><a href="arquivos.php"><img src="images/icon-upload.png" alt="img" width="128" height="128" align="absmiddle" /></a></div>
    </td>
    <td width="200">
        <? if($_SESSION['usertype']){ ?>
        <div align="center"><a href="usuarios.php"><img src="images/icon-users.png" alt="img" width="128" height="128" align="absmiddle" /></a></div>
        <? } ?>
    </td>
    <td width="200">
        <? if($_SESSION['usertype']){ ?>
        <div align="center"><a href="areas.php"><img src="images/icon-setores.png" alt="img" width="128" height="128" align="absmiddle" /></a></div>
        <? } ?>
    </td>
  </tr>
  <tr>
    <td><p><span>Upload de Relatórios</span></p></td>
    <td><p><span>Administração de Usuários</span></p></td>
    <td><p><span>Administração de Setores</span></p></td>
  </tr>
</table>
		<div class="bg1"></div>
        <p align="center"><a href="index.php?logoff=true"><img src="images/icon-exit.png" width="64" height="64" alt="img" /></a></p>
        <p>&nbsp;</p>
      </div>
      <div class="Serv">
        <h2>Importante</h2>
        <ul>
        	<li><font face="Arial, Helvetica, sans-serif">Não forneça a senha administrativa.</font></li>
            <li><font face="Arial, Helvetica, sans-serif">Certifique-se de que o arquivo foi enviado.</font></li>
        	<li><font face="Arial, Helvetica, sans-serif">Ao término da utilização, clique em sair.</font></li>
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