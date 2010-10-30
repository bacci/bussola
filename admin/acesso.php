<?
include('usuario.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Bussola Seguros ::: O seguro na medida da sua necessidade</title>
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
          <li><a href="empresa.html"><span class="bgi">Empresa</span></a></li>
          <li><a href="seguros.html"><span class="bgi">Seguros</span></a></li>
          <li><a href="#"><span class="bgi">Sinistro</span></a></li>
          <li><a href="#"><span class="bgi">Contato</span></a></li>
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
        <p align="left">
        <?
    if($_SESSION['usertype']){ ?>
        <p>&nbsp;</p>
        <div class="bg1"></div>
        <p><a href="areas.php"><img src="images/icon-setores.png" alt="img" width="128" height="128" border="0" /></a></p>
        <p><span>Áreas</span></p>
        <p>Cadastro das áreas para a distribuição de Arquivos.</p>
        <p>&nbsp;</p>
        <div class="bg1"></div>
        <p><a href="usuarios.php"><img src="images/icon-users.png" alt="img" width="128" height="128" border="0" /></a></p>
        <p><span>Usuários</span></p>
        <p>Cadastro do acesso de Usuários.</p>
        <p>&nbsp;</p>
    <? } ?>
        <div class="bg1"></div>
        <p><a href="arquivos.php"><img src="images/icon-upload.png"  alt="img" width="128" height="128" border="0" align="left" /></a></p>
        <p><span>Arquivos</span></p>
        <p>Acesso aos arquivos Administrativos.</p>
        <p>&nbsp;</p>
      </div>
      <div class="Sub">
      <h2>Nota</h2>
      <p>As informações disponibilizadas neste site são confidenciais e para uso exclusivo e interno da Eaton Ltda. É vedada a divulgação fora da empresa sem previa autorização da Tesouraria.</p>
      </div>
      <div class="Serv">
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