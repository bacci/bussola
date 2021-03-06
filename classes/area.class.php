<?php
/**
 * Descrição de area
 * A area é relacionada aos arquivos que o usuário terá acesso.
 *
 * @author Giancarlo Bacci
 */
$host="localhost";
$user="busso4";
$pass="rmrz+yhb";
$banco="busso4";
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
	private $Empresa    = null;
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

	public function getEmpresa() {
        return $this->Empresa;
    }

    public function setEmpresa($Empresa) {
        $this->Empresa = $Empresa;
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
            nome,
			empresa
            ) VALUES (
            NULL,
            "'.$this->NomeArea.'",
			"'.$this->Empresa.'"
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
        $sql='UPDATE area SET nome="'.$this->NomeArea.'", empresa="'.$this->Empresa.'" WHERE id="'.$this->Id.'"';
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

    public function getArea($empresa){
        $sql='SELECT * FROM area';
		if($empresa>0){
			$sql.=' WHERE empresa = "'.$empresa.'"';
		}
        if($this->getId()>0){
            $sql.=' WHERE  id = "'.$this->getId().'"';
        }
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
            if($this->getId()>0){
                $this->setNomeArea($rs->fields['nome']);
				$this->setEmpresa($rs->fields['empresa']);
                return $this;
            } else {
                while(!$rs->EOF){
					$a=new Area();
                    $a->setId($rs->fields['id']);
                    $a->setNomeArea($rs->fields['nome']);
					$a->setEmpresa($rs->fields['empresa']);
                    $b[]=$a;
                    $rs->MoveNext();
                }
                return $b;
            }
        } else {
            return false;
        }
    }

    public function comboArea($selected=null, $showempresa=false){
        $a=new Area();
        $b=$a->getArea();
        $tmp="<select name='area'>";
        foreach ($b as $obj){
            $tmp.="<option value='".$obj->getId()."'";
            if($selected==$obj->getId()){
                $tmp.=" selected='selected'";
            }
            $tmp.=">".$obj->getNomeArea();
		if($showempresa){
			$tmp.= ' ('.getNomeEmpresa($obj->getEmpresa()).')';
		}
		"</option>";
        }
        $tmp.="</select>";
        return $tmp;
    }

}
?>
