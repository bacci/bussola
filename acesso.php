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
      <div class="logo"><a href="index.php"><img src="images/logo.gif" width="422" height="142" border="0" alt="logo" /></a></div>
      <div class="menu">
        <ul>
          <li><a href="index.php"><span class="bgi">Home</span></a></li>
          <li><a href="#" class="active"><span class="bgi">Área Exclusiva</span></a></li>
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
    <td width="200" align="left"><div align="left"><a href="arquivos.php"><img src="images/icon-upload.png" alt="img" width="128" height="128" border="0" align="absmiddle" /></a></div></td>
    <td width="200" align="center">
        <? if($_SESSION['usertype']){ ?>
        <div align="center"><a href="usuarios.php"><img src="images/icon-users.png" alt="img" width="128" height="128" border="0" align="absmiddle" /></a></div>
        <? } ?>
    </td>
    <td width="200">
        <? if($_SESSION['usertype']){ ?>
        <div align="right"><a href="areas.php"><img src="images/icon-setores.png" alt="img" width="128" height="128" border="0" align="absmiddle" /></a></div>
        <? } ?>
    </td>
  </tr>
</table>
		<div class="bg1"></div>
        <p align="center"><a href="index.php?logoff=true"><img src="images/icon-exit.png" alt="img" width="64" height="64" border="0" /></a></p>
        <p>&nbsp;</p>
      </div>
      <div class="Serv">
        <h2>Pede-se</h2>
        <ul>
        	<li><font face="Arial, Helvetica, sans-serif" size="-1">Não forneça a sua senha. Ela é pessoal e intransferível.</font></li>
            <li><font face="Arial, Helvetica, sans-serif" size="-1">Certifique-se de que o arquivo está completo, após o download.</font></li>
        	<li><font face="Arial, Helvetica, sans-serif" size="-1">Ao término da utilização, clique em logoff (botão vermelho).</font></li>
        </ul>
      </div>
      <div class="Serv">
      <h2>Importante</h2>
	<ul>
    	<li><font face="Arial, Helvetica, sans-serif" size="-1">As informações deste site são confidenciais, de uso exclusivo da Eaton Ltda. É vedada a divulgação dos dados sem a autorização da Tesouraria.</font>
        </li>
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