<?php

class CentralatendimentoController extends Zend_Controller_Action {

    public function init() {
    	$this->view->metapalavrachave = Zend_Registry::get('metaPgContatoChave');
    	$this->view->metadescricao = Zend_Registry::get('metaPgContatoDescricao');
    	$this->view->metatitle = Zend_Registry::get('metaPgContatoTitle');
    }

    public function indexAction() {
        $this->view->captchaId = $this->generateCaptcha();
    }

    //returns ID of captcha session
    function generateCaptcha() {
        $captcha = new Zend_Captcha_Image();

        $captcha->setTimeout('500')
                ->setWordLen('6')
                ->setHeight('80')
                ->setFont(APPLICATION_PATH . '/../media/font/Engr.TTF')
                ->setImgDir(APPLICATION_PATH . '/../media/imagens/captcha');

        $captcha->generate();

        return $captcha->getId();
    }

   

}

?>	