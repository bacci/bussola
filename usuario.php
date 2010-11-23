<?php
session_name('aaLogin');
// Iniciando a sess�o

session_set_cookie_params(2*7*24*60*60);
// Definindo o validade do cookie por 2 semanas

session_start();

if($_SESSION['id']){
    include 'classes/usuarios.class.php';

    ?>
<?
} else {
    header('Location: index.php');
}
?>
