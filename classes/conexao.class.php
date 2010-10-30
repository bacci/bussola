<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descrição de conexao
 *
 * @author Giancarlo Bacci
 */
$host="localhost";
$user="bussola";
$pass="bussola";
$banco="bussola";
if(is_file('../adodb5/adodb.inc.php')){
    include '../adodb5/adodb.inc.php';
} else {
    include 'adodb5/adodb.inc.php';
}

$cdb = &ADONewConnection('mysql');
if($cdb->PConnect($host, $user, $pass, $banco)){
    global $cdb;
} else {
    echo $cdb->ErrorMsg();
}
?>
