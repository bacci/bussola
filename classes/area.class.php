<?php
/**
 * Descrição de area
 * A area é relacionada aos arquivos que o usuário terá acesso.
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
class Area {
    private $Id         = 0;
    private $NomeArea   = null;
    private $Erro       = null;

    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getNomeArea() {
        return $this->NomeArea;
    }

    public function setNomeArea($NomeArea) {
        $this->NomeArea = $NomeArea;
    }

    public function getErro() {
        return $this->Erro;
    }

    public function setErro($Erro) {
        $this->Erro = $Erro;
    }

    public function insereArea(){
        $sql='INSERT INTO area (
            id,
            nome
            ) VALUES (
            NULL,
            "'.$this->NomeArea.'"
            )';
        if($GLOBALS['cdb']->Execute($sql)){
           $pasta = "area_".$GLOBALS['cdb']->Insert_ID();
           if(mkdir ("arquivos/$pasta", 0777, true )){   // aqui e o diretorio aonde será criado tipo home/public-html/
                chmod("arquivos/$pasta", 0777);
           //echo "Pasta <b>$pasta </b> criada com sucesso!!";
            return true;
           } else {
               $_SESSION['message']="Pasta não criada";
           }
        } else {
            $this->setErro('Erro no script SQL');
        }

    }

    public function alteraArea(){
        $sql='UPDATE area SET nome="'.$this->NomeArea.'" WHERE id="'.$this->Id.'"';
        if($GLOBALS['cdb']->Execute($sql)){
            return true;
        } else {
            $this->setErro('Impossível alterar o registro de área!');
        }
    }

    public function apagaArea(){
        $sql='DELETE FROM area WHERE id="'.$this->Id.'" LIMIT 1';
        if($GLOBALS['cdb']->Execute($sql)){
            $pasta="area_".$this->Id;
            if(rmdir ("arquivos/$pasta")){   // aqui e o diretorio aonde será criado tipo home/public-html/
           //echo "Pasta <b>$pasta </b> criada com sucesso!!";
            return true;
           }
        } else {
            $this->setErro('Impossível apagar o registro!');
        }
    }

    public function getArea(){
        $sql='SELECT * FROM area';
        if($this->getId()>0){
            $sql.=' WHERE id = "'.$this->getId().'"';
        }
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
            if($this->getId()>0){
                $this->setNomeArea($rs->fields['nome']);
                return $this;
            } else {
                while(!$rs->EOF){
                    $a=new Area();
                    $a->setId($rs->fields['id']);
                    $a->setNomeArea($rs->fields['nome']);
                    $b[]=$a;
                    $rs->MoveNext();
                }
                return $b;
            }
        } else {
            return false;
        }
    }

    public function comboArea($selected=null){
        $a=new Area();
        $b=$a->getArea();
        $tmp="<select name='area'>";
        foreach ($b as $obj){
            $tmp.="<option value='".$obj->getId()."'";
            if($selected==$obj->getId()){
                $tmp.=" selected='selected'";
            }
            $tmp.=">".$obj->getNomeArea()."</option>";
        }
        $tmp.="</select>";
        return $tmp;
    }

}

?>
