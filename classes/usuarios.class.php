<?php
/**
 * Descrição de usuarios:
 * Classe para modelagem de usuários
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


function getNomeArea($ide){
    if($ide=="all"){
        return "admin";
    } else {
        $sql='SELECT nome FROM area WHERE id = "'.$ide.'"';
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
                return $rs->fields['nome'];
            } else {
                return '';
            }
    }
}

function getNomeEmpresa($ide){
    if($ide=="all"){
        return "admin";
    } else {
        $sql='SELECT empresa FROM empresa WHERE id = "'.$ide.'"';
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
                return $rs->fields['empresa'];
            } else {
                return '';
            }
    }
}

class Usuarios {

    private $Id         = null;
    private $Nome       = null;
    private $Login      = null;
    private $Senha      = null;
    private $Area       = null;
	private $Empresa    = null;
    private $IsAdmin    = 0;
    private $Status     = 0;
    private $LastLogin  = null;
    private $Erro       = null;
    
    public function getIsAdmin() {
        return $this->IsAdmin;
    }

    public function setIsAdmin($IsAdmin) {
        $this->IsAdmin = $IsAdmin;
    }

    public function getStatus() {
        return $this->Status;
    }

    public function setStatus($Status) {
        $this->Status = $Status;
    }

        public function getId() {
        return $this->Id;
    }

    public function setId($Id) {
        $this->Id = $Id;
    }

    public function getNome() {
        return $this->Nome;
    }

    public function setNome($Nome) {
        $this->Nome = $Nome;
    }

    public function getLogin() {
        return $this->Login;
    }

    public function setLogin($Login) {
        $this->Login = $Login;
    }

    public function getSenha() {
        return $this->Senha;
    }

    public function setSenha($Senha) {
        $this->Senha = $Senha;
    }

    public function getArea() {
        return $this->Area;
    }

    public function setArea($Area) {
        $this->Area = $Area;
    }

	public function getEmpresa() {
        return $this->Empresa;
    }

    public function setEmpresa($Empresa) {
        $this->Empresa = $Empresa;
    }

    public function getLastLogin() {
	$last=$this->LastLogin;
	$datetime=explode(' ',$last);
	$data=explode('-',$datetime[0]);
	if(count($data)==3){
	        return $data[2].'/'.$data[1].'/'.$data[0].' às '.$datetime[1];
	} else {
		return $last;
	}
    }

    public function setLastLogin($LastLogin) {
        $this->LastLogin = $LastLogin;
    }

    public function getErro() {
        return $this->Erro;
    }

    public function setErro($Erro) {
        $this->Erro = $Erro;
    }

    public function checkUser(){
        $sql="SELECT * FROM usuarios WHERE login LIKE '".mysql_real_escape_string($this->Login)."' AND senha='".md5($this->Senha)."'";
            $rs=$GLOBALS["cdb"]->Execute($sql);
            if($rs->_numOfRows==1){
                    $this->Id=$rs->fields["id"];
                    $this->Nome=$rs->fields["nome"];
                    $this->Login=$rs->fields["login"];
                    $this->Area=$rs->fields["area"];
					$this->Empresa=$rs->fields["empresa"];
                    $this->LastLogin=$rs->fields["lastlogin"];
                    $this->IsAdmin=$rs->fields["isadmin"];
                    $this->Status=$rs->fields["status"];
			$sql="UPDATE usuarios SET lastlogin = '".date('Y-m-d h:i:s')."' WHERE login LIKE '".mysql_real_escape_string($this->Login)."' AND senha='".md5($this->Senha)."'";
			$rs=$GLOBALS["cdb"]->Execute($sql);
                    return $this;
                    
            } else {
                $_SESSION['message']='Usuário e ou senha inválidos';
                    return false;
            }

	}

    public function insereUsuario(){
        $name=$this->verificaUsuario();
        if($name){
            $_SESSION['message']="Usuário já existe com este login:'".$this->Login."' em nome de '".$this->Nome."'.";
        } else {
            $sql='INSERT INTO usuarios (
                id,
                nome,
                login,
                senha,
                area,
				empresa
            ) VALUES (
                NULL,
                "'.mysql_real_escape_string($this->Nome).'",
                "'.mysql_real_escape_string($this->Login).'",
                "'.md5($this->Senha).'",
                "'.$this->Area.'",
				"'.$this->Empresa.'"
            )';
            if($GLOBALS['cdb']->Execute($sql)){
                $_SESSION['message']="Usuário '".$this->Nome."' criado com o login '".$this->Login."'.";
            } else {
                $_SESSION['message']='Impossível criar o registro de usuario!';
            }
        }
    }

    private function verificaUsuario(){
        $sql='SELECT nome FROM usuarios WHERE login LIKE "'.$this->Login.'"';
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs->_numOfRows>0){
            $_SESSION['message']='Usuário já existe com o nome de "'.$rs->fields['nome'].'"';
            return true;
        } else {
            return false;
        }
    }

    public function apagaUsuario(){
        $sql='DELETE FROM usuarios WHERE id="'.$this->Id.'" LIMIT 1';
        if($GLOBALS['cdb']->Execute($sql)){
            return true;
        } else {
            $this->setErro('Impossível apagar o registro!');
        }
    }

    public function alteraUsuario(){
        $sql='UPDATE usuarios SET ';
        $valor=$this->serializar();
        foreach($valor as $campo => $vlr){
            if($campo=='senha'){
                $sql.=" ".$campo."='".md5($vlr)."', ";
            } else {
                $sql.=" ".$campo."='".$vlr."', ";
            }
        }
        $sql=substr($sql,0,-2)." WHERE id='{$this->Id}'";
        if($GLOBALS["cdb"]->Execute($sql)){
                return $this->Id;
        } else {
                print $GLOBALS["cdb"]->ErrorMsg();
                return false;
        }
    }

    private function criaBancoUsuarios(){
        $sql='CREATE TABLE usuarios (
          id int(11) NOT NULL AUTO_INCREMENT,
          nome varchar(150) COLLATE utf8_unicode_ci NOT NULL,
          login varchar(20) COLLATE utf8_unicode_ci NOT NULL,
          senha varchar(255) NOT NULL,
          area int(11) DEFAULT NULL,
          lastlogin datetime(0) DEFAULT NULL,
          isadmin tinyint(1) DEFAULT 0,
          status tinyint(1) DEFAULT 1,
		  empresa int(11),
          PRIMARY KEY (id),
          KEY `nome` (`nome`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;';
    }

    public function getUsuario(){
        $sql='SELECT * FROM usuarios';
        if($this->getId()>0){
            $sql.=' WHERE id = "'.$this->Id.'"';
        }
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs){
            if($this->getId()>0){
                $this->setLogin($rs->fields['login']);
                $this->setNome($rs->fields['nome']);
                $this->setArea($rs->fields['area']);
                $this->setIsAdmin($rs->fields['isadmin']);
                $this->setStatus($rs->fields['status']);
                $this->setLastLogin($rs->fields['lastlogin']);
				$this->setEmpresa($rs->fields['empresa']);
                return $this;
            } else {
                while(!$rs->EOF){
                    $a=new Usuarios();
                    $a->setId($rs->fields['id']);
                    $a->setLogin($rs->fields['login']);
                    $a->setNome($rs->fields['nome']);
                    $a->setArea($rs->fields['area']);
                    $a->setIsAdmin($rs->fields['isadmin']);
                    $a->setStatus($rs->fields['status']);
                    $a->setLastLogin($rs->fields['lastlogin']);
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

    private function serializar(){
		if($this->Id!=NULL){
			$valor["id"]=$this->Id;
		}

		if($this->Login!=NULL){
			$valor["login"]=mysql_real_escape_string($this->Login);
		}

		if($this->Nome!=NULL){
			$valor["nome"]=mysql_real_escape_string($this->Nome);
		}

		if($this->Senha!=NULL){
			$valor["senha"]=$this->Senha;
		}

		if($this->Area!=NULL){
			$valor["area"]=$this->Area;
		}

		if($this->Empresa!=NULL){
			$valor["empresa"]=$this->Empresa;
		}

		if($this->LastLogin!=NULL){
			$valor["lastlogin"]=$this->LastLogin;
		}

		if($this->Status!=NULL){
			$valor["status"]=$this->Status;
		}
		return $valor;
	}
}
?>
