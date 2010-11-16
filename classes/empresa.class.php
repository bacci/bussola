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
class Empresa {
    private $Id         = 0;
    private $EmpresaNome    = null;
	private $MsgEmpresa = null;
    private $Erro       = null;

    public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getEmpresaNome() {
        return $this->EmpresaNome;
    }

    public function setEmpresaNome($EmpresaNome) {
        $this->EmpresaNome = $EmpresaNome;
    }

	public function getMsgEmpresa() {
        return $this->MsgEmpresa;
    }

    public function setMsgEmpresa($MsgEmpresa) {
        $this->MsgEmpresa = $MsgEmpresa;
    }

    public function getErro() {
        return $this->Erro;
    }

    public function setErro($Erro) {
        $this->Erro = $Erro;
    }

    public function insereEmpresa(){
        $sql='INSERT INTO empresa (
            id,
            empresa,
			msg_empresa
            ) VALUES (
            NULL,
            "'.$this->EmpresaNome.'",
			"'.$this->MsgEmpresa.'"
            )';
        if($GLOBALS['cdb']->Execute($sql)){
           $_SESSION['message']='Empresa {$this->Empresa} inserida';
        } else {
            $this->setErro('Erro no script SQL');
        }

    }

    public function alteraEmpresa(){
        $sql='UPDATE empresa SET empresa="'.$this->EmpresaNome.'", msg_empresa="'.$this->MsgEmpresa.'" WHERE id="'.$this->Id.'"';
        if($GLOBALS['cdb']->Execute($sql)){
            return true;
        } else {
            $this->setErro('Impossível alterar o registro de empresa!');
        }
    }

    public function apagaEmpresa(){
        $sql='DELETE FROM empresa WHERE id="'.$this->Id.'" LIMIT 1';
        if($GLOBALS['cdb']->Execute($sql)){
            $_SESSION['message']='Empresa id:{$this->Id} apagada';
        } else {
            $this->setErro('Impossível apagar o registro!');
        }
    }

    public function getEmpresa(){
        $sql='SELECT * FROM empresa';
        if($this->getId()>0){
            $sql.=' WHERE id = "'.$this->getId().'"';
        }
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
            if($this->getId()>0){
                $this->setEmpresaNome($rs->fields['empresa']);
				$this->setMsgEmpresa($rs->fields['msg_empresa']);
                return $this;
            } else {
                while(!$rs->EOF){
                    $a=new Empresa();
                    $a->setId($rs->fields['id']);
                    $a->setEmpresaNome($rs->fields['empresa']);
					$a->setMsgEmpresa($rs->fields['msg_empresa']);
                    $b[]=$a;
                    $rs->MoveNext();
                }
                return $b;
            }
        } else {
            return false;
        }
    }

    public function comboEmpresa($selected=null){
        $a=new Empresa();
        $b=$a->getEmpresaNome();
        $tmp="<select name='empresa'>";
        foreach ($b as $obj){
            $tmp.="<option value='".$obj->getId()."'";
            if($selected==$obj->getId()){
                $tmp.=" selected='selected'";
            }
            $tmp.=">".$obj->getEmpresa()."</option>";
        }
        $tmp.="</select>";
        return $tmp;
    }

	private function createTable(){
		$sql="CREATE  TABLE `bussola`.`empresa` (
			`id` INT NOT NULL AUTO_INCREMENT ,
			`empresa` VARCHAR(150) NULL ,
			`msg_empresa` TEXT NULL ,
			PRIMARY KEY (`id`) )
			ENGINE = MyISAM;";
	}

}

?>
