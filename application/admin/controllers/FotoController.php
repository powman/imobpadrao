<?php

class Admin_FotoController extends Zend_Controller_Action {

	private $_model;

	public $ext;

	private $_Album;
	
	private $_linkRef;
	
	private $_uploaddir;
	
	public function init() {
		$this->_model = new Application_Model_FotoMapper();
		$this->view->sucessMessage = '';
		$this->view->warningMessage = '';
		$this->headerText = '';
		Zend_Session::start();
		$ref = Zend_Session::namespaceGet('PluginFotoRef');
		if (!$ref)
			throw new Exception('Nenhuma configuração para galeria de fotos foi denifida.');
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/upload.ini');
		$this->_uploaddir = $config->uploaddir->foto;
		if(!is_writable($this->_uploaddir)){
  			throw new Exception('O diretorio de upload não tem permissão de escrita.');
		}
		$albumMapper = new Application_Model_AlbumMapper();
		$this->_Album = new Application_Model_Album();
		$this->_Album = end($albumMapper->fetchAll('idPluginRef = \'' . $ref['idPluginRef'] . '\''));
		if (!$this->_Album)
			throw new Exception('Album não selecionado.');
		$this->_linkRef = $ref['linkRef'];
	}

	public function indexAction() {
		$request = $this->getRequest();
		$this->view->headerText = 'Lista de Fotos';
		$this->view->linkRef = $this->_linkRef;
		$this->view->imagens = $this->_model->buscaFotos($this->_Album->getIdPluginRef());
	}

	public function cadastrarAction() {
		$this->view->headerText = 'Cadastro de fotos';
		$item = new Application_Model_Foto();
		$form = new Application_Form_Foto();
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($_POST)) {
				$Conf = $this->_model->findConf($this->_Album->getIdFotoConf());
				$aThumbs = json_decode($Conf->getTamanhos());
				if (!$aThumbs) {
					throw new Exception('Configurações não definidas para o modulo.');
				}
				$uploadDir = $this->_uploaddir;
				$adapter = new Zend_File_Transfer_Adapter_Http();
				$adapter->setDestination($uploadDir);
				$info = $adapter->getFileInfo();
				$ext = $this->_findexts($info['foto']['name']);
				$fileName = substr($this->_Album->getIdPluginRef(), 0, 4);
				$fileName .= str_padLeft($this->_Album->getIdFotoAlbum(), 4);
				$iIdNumeracao = $this->_model->buscaNumeracao($this->_Album->getIdFotoAlbum());
				$fileName .= str_padLeft($iIdNumeracao, 3);
				$fileNameOri = $fileName;
				$fileName .= '.' . $ext;
				$aParam = array('target' => $uploadDir . DIRECTORY_SEPARATOR . $fileName, 'overwrite' => true);
				$adapter->addFilter('Rename', $aParam);
				if (!$adapter->receive()) {
					$this->view->warningMessage = 'Não foi possível enviar fotos. Verifique o arquivo enviado.';
					$form->populate($form->getValues());
				} else {
					try {
						foreach ($aThumbs as $key => $tb) {
							$img = new Application_Plugin_Canvas();
							$fName = explode('.', $fileName);
							$sName = $fName[0] . '_' . $key . '.' . $fName[1];
							$img->carrega($uploadDir . DIRECTORY_SEPARATOR . $fileName);
							$res = explode('x', $tb);
							$img->redimensiona($res[0], $res[1], 'crop');
							$img->grava($uploadDir . DIRECTORY_SEPARATOR . $sName, 100);
						}
						unlink($uploadDir . DIRECTORY_SEPARATOR . $fileName);
						$item->setOptions($form->getValues());
						$item->setNome_imagem($fileNameOri);
						$item->setIdFotoAlbum($this->_Album->getIdFotoAlbum());
						$item->setIdFotoNumeracao($iIdNumeracao);
						$item->setExtensaoArquivo($ext);
						$this->_model->save($item);
						$this->_helper->redirector(array('controller' => 'foto', 'module' => 'admin'));
					} catch (Zend_Exception $e) {
						throw new Exception($e->getMessage());
					}
				}
			}
		}
		$this->view->form = $form;
	
	}

	public function excluirAction() {
		if (!$this->getRequest()->getParam('id'))
			throw new Exception("Código da foto não informado.");
		$item = new Application_Model_Foto();
		$this->_model->find($this->getRequest()->getParam('id'), $item);
		$this->_model->deletarFotos($item);
		$this->_model->getDbTable()->delete('idFoto = '.$this->getRequest()->getParam('id')); 
		$this->_helper->redirector(array('controller' => 'foto', 'module' => 'admin'));
	}

	public function alterarAction() {
		$this->view->headerText = 'Alteração de fotos';
		if (!$this->getRequest()->getParam('id'))
			throw new Exception("Código da foto não informado.");
		$item = new Application_Model_Foto();
		$form = new Application_Form_Foto();
		$this->_model->find($this->getRequest()->getParam('id'), $item);
		$data = array(
					'idFoto' => $item->getIdFoto(), 
					'idFotoNumeracao' => $item->getIdFotoNumeracao(), 
					'idFotoAlbum' => $item->getIdFotoAlbum(), 
					'nome' => $item->getNome(), 
					'comentario' => $item->getComentario(), 
					'extensaoArquivo' => $item->getExtensaoArquivo(), 
					'destaque' => $item->getDestaque());
		$fileName = substr($this->_Album->getIdPluginRef(), 0, 4);
		$fileName .= str_padLeft($this->_Album->getIdFotoAlbum(), 4);
		$fileName .= str_padLeft($item->getIdFotoNumeracao(), 3) . '_alterado.' . $item->getExtensaoArquivo();
		$this->view->imagem = $fileName;
		if ($this->getRequest()->isPost()) {
			$item->setOptions($_POST);
			$this->_model->save($item);
			$this->_helper->redirector(array('controller' => 'foto', 'module' => 'admin'));
		}
		$form->populate($data);
		$form->removeElement('foto');
		$this->view->form = $form;
	}

	private function _findexts($filename) {
		$filename = strtolower($filename);
		$exts = split('[/\\.]', $filename);
		$n = count($exts) - 1;
		$exts = $exts[$n];
		return $exts;
	}
}