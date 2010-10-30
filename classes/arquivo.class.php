<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Descrição de upload
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

//Verificação de Segurança
$url = $_SERVER['PHP_SELF'];
if(eregi("arquivo.class.php", "$url")) {
    header("Location: index.php");
}

class Arquivo
{
    var $id         = null;
    var $tipo       = null;
    var $nome       = null;
    var $pasta       = null;
    var $area       = null;
    var $descricao  = null;
    var $tamanho    = null;
    var $erro       = null;
    var $datacad    = null;

    public function UploadArquivo($arquivo, $pasta, $tipos, $area, $descricao)
    {
        $_SESSION['message']="";
      if(isset($arquivo))
      {
        $nomeOriginal = explode('.',$arquivo['name']);
        $nomeFinal = $nomeOriginal[0]; // @todo tratar o nome do arquivo depois
        $tipo = strrchr($arquivo['name'],"."); //pega o tipo do arquivo
        $tamanho = $arquivo['size'];
        if(is_file($pasta.$nomeOriginal[0].$tipo)){
            $this->erro='O arquivo já existe';
            $_SESSION['message'].=$this->erro;
        } else {
            for($i=0;$i<=count($tipos);$i++) {
              if($tipos[$i] == $tipo) {
                $arquivoPermitido=true;
                //echo $arquivo['tmp_name'].'p/'.$pasta . $nomeFinal.$tipo;
                  $this->nome=$nomeFinal . $tipo;
                  $this->pasta=$pasta;
                  $this->tipo=$tipo;
                  $this->area=$area;
                  $this->descricao=$descricao;
                  $this->tamanho=$arquivo['size'];
                  $this->erro=null;
                if (move_uploaded_file($arquivo['tmp_name'], $pasta . $nomeFinal . $tipo)) {
                  if($this->salvarArquivo()) {
                      return true;
                  } else {
                      $_SESSION['message'].='Não pode salvar o arquivo no Banco';
                      return false;
                  }
                } else {
                  $this->erro="Arquivo <b>".$nomeFinal.$tipo."</b> não enviado";
                  $_SESSION['message'].=$this->erro;
                  return false;
                }
                break;
              }
            }
            if($arquivoPermitido==false)
            {
              $this->erro="Extensão de arquivo não permitido!!";
              $_SESSION['message'].=$this->erro;
              return false;
            }
        }
      } else {
          $this->erro="Selecione algum arquivo para upload";
          $_SESSION['message'].=$this->erro;
          return false;
      }
    }

    private function salvarArquivo(){
        $sql="INSERT INTO arquivos (
            id,
            nome,
            pasta,
            tamanho,
            descricao,
            area,
            datacad
            ) VALUES (
            NULL,
            '".$this->nome."',
            '".$this->pasta."',
            '".$this->tamanho."',
            '".$this->descricao."',
            '".$this->area."',
            NOW()
            )";
            if($GLOBALS["cdb"]->Execute($sql)){
                    return $GLOBALS["cdb"]->Insert_ID();
            } else {
                    print $GLOBALS["cdb"]->ErrorMsg();
                    return false;
            }
    }

    public function getArquivoByArea($area){
        $sql='SELECT * FROM arquivos';
        if($area!="all"){
            $sql.=' WHERE area = "'.$area.'"';
        }
        $sql.=" ORDER BY area, nome";
        $rs=$GLOBALS['cdb']->Execute($sql);
        if($rs->_numOfRows>0){
            $b=array();
            while(!$rs->EOF){
                $a=new Arquivo();
                $a->id=$rs->fields['id'];
                $a->nome=$rs->fields['nome'];
                $a->pasta=$rs->fields['pasta'];
                $a->tamanho=$rs->fields['tamanho'];
                $a->descricao=$rs->fields['descricao'];
                $a->area=$rs->fields['area'];
                $a->datacad=$rs->fields['datacad'];
                $b[]=$a;
                $rs->MoveNext();
            }
            return $b;
        } else {
            return false;
        }
    }
    
    function downloadArquivo($basedir, $filename, $force_download = false, $checklen = null) {
		$pinfo = pathinfo($basedir . '/' . $filename);
		$pinfo['dirname'] = realpath($pinfo['dirname']);
		$basedir		  = realpath($basedir);
		// Bloqueia para download somente no $basedir ou substr($basedir,$checklen)
		if ((is_null($checklen) && $pinfo['dirname'] != $basedir)  ||
				(!is_null($checklen) && substr($pinfo['dirname'],0,$checklen) != substr($basedir,0,$checklen)) ||
			$pinfo['basename'] != $filename) {
			header('HTTP/1.1 403 Forbidden');
			die();
			// TO-DO: logger "Download invalido! [$basedir] [$filename] esperado [{$pinfo['dirname']}] [{$pinfo['filename']}] \n";
		}
		header('Content-Description: File Transfer');
		header('Expires: 0'); // maybe Mon, 26 Jul 1997 05:00:00 GMT ?
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: public');
		header('Pragma: public');
		header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

		$content_types = $this->arquivosPermitidos();

		$file_ext = strtolower($pinfo['extension']);
		if (isset($content_types[$file_ext])) {
				list ($content_type, $isbinary) = $content_types[$file_ext];
			 header('Content-type: '.$content_type);
			 if ($isbinary)  header('Content-Transfer-Encoding: binary');
		}

		$file = $pinfo['dirname'] . '/' . $pinfo['basename'];
		header('Content-Length: '.filesize($file));
		if ($force_download) {
			header('Content-Disposition: attachment; filename='.$pinfo['basename']);
		}
                $fp = fopen($file, 'rb');
                fpassthru($file);
		ob_clean();
		flush();
		readfile($file);
	}

    public function getArquivoById($id){
        $sql='SELECT * FROM arquivos WHERE id = "'.$id.'" LIMIT 1';
        $rs=$GLOBALS['cdb']->Execute($sql);
            $a=new Arquivo();
            $a->id=$rs->fields['id'];
            $a->nome=$rs->fields['nome'];
            $a->pasta=$rs->fields['pasta'];
            $a->tamanho=$rs->fields['tamanho'];
            $a->descricao=$rs->fields['descricao'];
            $a->area=$rs->fields['area'];
            $a->datacad=$rs->fields['datacad'];
            return $a;
    }

    //public function download($basedir, $filename, $force_download = false, $checklen = null) {
    public function download($ide, $area) {
            $file=new Arquivo();
            $arquivo=$file->getArquivoById($ide);
            $down=true;
            if($arquivo->area<>$area){
                $down=false;
            }
            if($area=="all"){
                $down=true;
            }
            
            if($down) {
                return $arquivo->downloadArquivo($arquivo->pasta, $arquivo->nome, true);
//		header("Content-Type: application/save");
//                header('Content-Description: File Transfer');
//		header('Expires: 0'); // maybe Mon, 26 Jul 1997 05:00:00 GMT ?
//		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//		header('Cache-Control: public');
//		header('Pragma: public');
//		header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
//        	header('Content-Disposition: attachment; filename='.$arquivo->nome);
//		ob_clean();
//		flush();
//		readfile($arquivo->pasta.$arquivo->nome);
            } else {
                header('Location: logmein.php?logoff=true');
            }
    }

    public function apagaArquivo(){
        if($this->id>0){
            $file=$this->getArquivoById($this->id);
            if($_SESSION['usertype']==1){
                if(unlink($file->pasta.$file->nome)){
                    $sql='DELETE FROM arquivos WHERE id="'.$this->id.'" LIMIT 1';
                    if($GLOBALS['cdb']->Execute($sql)){
                        $_SESSION['message']='Arquivo excluído com sucesso!';
                    } else {
                        $this->erro('Impossível apagar o registro!');
                        return false;
                    }
                } else {
                    $this->erro('Impossível apagar o arquivo!');
                    return false;
                }
            } else {
                $_SESSION['message']="Não há arquivo para apagar"; // mentira, ele tentou apagar um arquivo e não é admin
            }
        } else {
            $_SESSION['message']="Não há arquivo para apagar";
        }
    }

    //@ not in use atm
    public function arquivosPermitidos(){
        return array(	'pdf'  => array('application/pdf', true),
                        'zip'  => array('application/zip', true),
                        'txt'  => array('text/plain' , false),
                        'rem'  => array('text/plain', false),
                        'nfo'  => array('text/plain', false),
                        'xml'  => array('text/xml', false),
                        'jpg'  => array('image/jpeg', true),
                        'jpeg' => array('image/jpeg', true),
                        'mpeg' => array('audio/mpeg', true),
                        'gif'  => array('image/gif', true),
                        'png'  => array('image/png', true),
                        'gif'  => array('image/gif', true),
                        'bmp'  => array('image/bmp', true)
                                );
    }
}
?>
