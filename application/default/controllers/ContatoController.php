<?php
ini_set('display_errors', 'Off');
error_reporting(0); 
class ContatoController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {
        
    }

    public function emailAction() {
        
    }

    /**
     * Respons�vel por enviar um email e gravar no 
     * banco de dados para a corretora com os dados 
     * do cliente para que seja marcada uma visita.
     */
    public function agendaAction() {
        /* Desabilita o layout */
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $resposta = array();

        $request = ($this->getRequest());
        $aRequest = $request->getPost();
        $mail = new Zend_Mail('utf-8');
        
        // monta Msg
        $msg  = "";
         
        if($aRequest['visita_nome']){
        	$msg .= "<strong>Nome: </strong><br/>" . $aRequest['visita_nome'] . "<br/><br/>";
        }
        if($aRequest['visita_telefone']){
        	$msg .= "<strong>Telefone: </strong><br/>" . $aRequest['visita_telefone'] . "<br/><br/>";
        }
        if($aRequest['imovel_interessado']){
        	$msg .= "<strong>Imóvel interessado: </strong><br/>" . $aRequest['imovel_interessado'] . "<br/><br/>";
        }
        if($aRequest['visita_data']){
        	$msg .= "<strong>Data da visita: </strong><br/>" . $aRequest['visita_data'] . "<br/><br/>";
        }
        if($aRequest['visita_horario']){
        	$msg .= "<strong>Hora da visita: </strong><br/>" . $aRequest['visita_horario'] . "<br/><br/>";
        }
        if($aRequest['visita_email']){
        	$msg .= "<strong>Email: </strong><br/>" . $aRequest['visita_email'] . "<br/><br/>";
        }
        
        $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].Zend_Controller_Front::getInstance()->getBaseUrl().'/media/email/padrao.html');
        $content = str_replace('{TEXTO}', $msg, $content);
        $content = str_replace('{MODULO}', "Agende uma visita", $content);
        $content = str_replace('{EMPRESA}', Zend_Registry::get('nomeEmpresa'), $content);

        $mail->setBodyHtml($content);
        $mail->setFrom($aRequest['visita_email'], $aRequest['visita_nome']);
        $mail->addTo(Zend_Registry::get('emailsAgende'), Zend_Registry::get('nomeEmpresa').' - Agende uma visita');
        /* Assunto do email */
        $mail->setSubject('Agendamento de visita');
        
        if (!$mail->send()) {
        	$resposta['situacao'] = "error";
        	$resposta['msg'] = "Erro ao enviar.";
        
        } else {
        
        	$resposta['situacao'] = "sucess";
        	$resposta['msg'] = "Enviado com sucesso.";
        }
        
        
       echo Zend_Json::encode($resposta);
        
    }

    /**
     * Envia um email para a pessoa selecionada pelo usu�rio
     * com o link para acesso do im�vel no site.
     */
    function indicarAction() {
        /* Desabilita o layout */
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $aRequest = $this->getRequest()->getPost();

        $imovelMapper = Application_Model_ImovelMapper::instanciar();
        $imovelIndicado = $imovelMapper->fetchAll('idimovel = ' . $aRequest['imovel_indicado']);
        $nmfoto = Application_Model_ImovelMapper::findImage($aRequest['imovel_indicado'], true);

        foreach ($imovelIndicado as $aImovel) {

            switch ($aImovel->getVenda_aluguel()) {
                case 1: $tipoImovel = 'Aluguel';
                    $valor = KM_formatNunber($aImovel->getValor_aluguel());
                    break;
                case 2: $tipoImovel = 'Venda';
                    $valor = KM_formatNunber($aImovel->getValor_venda());
                    break;
            }

            $descricao = $aImovel->getDescricao();
        }

        $mail = new Zend_Mail('utf-8');

        $sHtml = file_get_contents('http://'.$_SERVER['HTTP_HOST'].Zend_Controller_Front::getInstance()->getBaseUrl().'/media/email/indicar.html');
        $sHtml = str_replace(
                array(
            '{EMPRESA}',
            '{MODULO}',
            '{TEXTO}',
            '{TIPO}',
            '{PRECO}',
            '{URL}',
            '{IMAGEM}'
                ), array(
            Zend_Registry::get('nomeEmpresa'),
            'Olá '.$aRequest['nome_amigo'].'! <br/> seu amigo '.$aRequest['seu_nome'].' te indicou um imóvel código '.$aRequest['imovel_indicado'],
            $descricao,
            $tipoImovel,
            $valor,
            'href="http://'.$_SERVER['SERVER_NAME'].'/imovel/destaque/id/' . $aRequest['imovel_indicado'] . '"',
            'src="http://'.$_SERVER['SERVER_NAME'].'/media/upload/imagens/' . $nmfoto[0] . '"'
                ), $sHtml);

        $mail->setBodyHtml($sHtml);
        $mail->setFrom("no-reply@netsuprema.com.br", Zend_Registry::get('nomeEmpresa'));
        $mail->setReplyTo($aRequest['email_amigo'], $aRequest['seu_nome']);
        $mail->addTo(array($aRequest['email_amigo']), $aRequest['nome_amigo']);
        
        /* Assunto do email */
        $mail->setSubject($aRequest['seu_nome'] . ' te indicou um imóvel');

        if (!$mail->send()) {
        	$resposta['situacao'] = "error";
        	$resposta['msg'] = "Erro ao enviar.";
        
        } else {
        
        	$resposta['situacao'] = "sucess";
        	$resposta['msg'] = "Enviado com sucesso.";
        }
        
        
        echo Zend_Json::encode($resposta);
    }

    /**
     * Envia um email para a corretora solicitando que
     * ligue para o usu�rio.
     */
    function ligarAction() {

        
        /* Desabilita o layout */
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $resposta = array();
        
        $request = ($this->getRequest());
        $aRequest = $request->getPost();
        $mail = new Zend_Mail('utf-8');
        
        // monta Msg
        $msg  = "";
        
       
         
        if($aRequest['ligar_nome']){
        	$msg .= "<strong>Ligar para: </strong><br/>" . $aRequest['ligar_nome'] . "<br/><br/>";
        }
        if($aRequest['ligar_email']){
        	$msg .= "<strong>Email do usuário: </strong><br/>" . $aRequest['ligar_email'] . "<br/><br/>";
        }
        if($aRequest['ligar_assunto']){
        	$msg .= "<strong>Assunto: </strong><br/>" . $aRequest['ligar_assunto'] . "<br/><br/>";
        }
        if($aRequest['ligar_telefone']){
        	$msg .= "<strong>Telefone do usuário: </strong><br/>" . $aRequest['ligar_telefone'] . "<br/><br/>";
        }
        
        $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].Zend_Controller_Front::getInstance()->getBaseUrl().'/media/email/padrao.html');
        $content = str_replace('{TEXTO}', $msg, $content);
        $content = str_replace('{MODULO}', "Ligamos para você", $content);
        $content = str_replace('{EMPRESA}', Zend_Registry::get('nomeEmpresa'), $content);
        
        $mail->setBodyHtml($content);
        $mail->setFrom("no-reply@netsuprema.com.br", Zend_Registry::get('nomeEmpresa'));
        $mail->setReplyTo($aRequest['ligar_email'], $aRequest['ligar_nome']);
        $mail->addTo(Zend_Registry::get('emailsLigue'), Zend_Registry::get('nomeEmpresa').' - Ligamos para você');
        /* Assunto do email */
        $mail->setSubject('Ligamos para você');
        
        if (!$mail->send()) {
        	$resposta['situacao'] = "error";
        	$resposta['msg'] = "Erro ao enviar.";
        
        } else {
        
        	$resposta['situacao'] = "sucess";
        	$resposta['msg'] = "Enviado com sucesso.";
        }
        
        
        echo Zend_Json::encode($resposta);
        
        
    }
    public function contatoAction()
    {
        /* Desabilita o layout */
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout->disableLayout();
        $resposta = array();
        
        $request = ($this->getRequest());
        if ($request->getPost()) {
                	
                    $aRequest = $request->getPost();
                    $mail = new Zend_Mail('utf-8');
                    
                    // monta Msg
                    $msg  = "";
                    
                    if($aRequest['contato_nome']){
                    	$msg .= "<strong>Nome: </strong><br/>" . $aRequest['contato_nome'] . "<br/><br/>";
                    }
                    if($aRequest['contato_email']){
                    	$msg .= "<strong>Email: </strong><br/>" . $aRequest['contato_email'] . "<br/><br/>";
                    }
                    if($aRequest['contato_telefone']){
                    	$msg .= "<strong>Telefone: </strong><br/>" . $aRequest['contato_telefone'] . "<br/><br/>";
                    }
                    if($aRequest['contato_mensagem']){
                    	$msg .= "<strong>Mensagem: </strong><br/>" . $aRequest['contato_mensagem'] . "<br/><br/>";
                    }
                    
                    $content = file_get_contents('http://'.$_SERVER['HTTP_HOST'].Zend_Controller_Front::getInstance()->getBaseUrl().'/media/email/padrao.html');
                    $content = str_replace('{TEXTO}', $msg, $content);
                    $content = str_replace('{MODULO}', "Contato através do site", $content);
                    $content = str_replace('{EMPRESA}', Zend_Registry::get('nomeEmpresa'), $content);

                    $mail->setBodyHtml($content);
                    $mail->setFrom("no-reply@netsuprema.com.br", Zend_Registry::get('nomeEmpresa'));
                    $mail->setReplyTo($aRequest['contato_email'], $aRequest['contato_nome']);
                    $mail->addTo(Zend_Registry::get('emailsContato'), '(Formulário contato)');
                    /* Assunto do email */
                    $mail->setSubject('Contato através do site');
                    
                    if (!$mail->send()) {
                    	$resposta['situacao'] = "error";
                    	$resposta['msg'] = "Erro ao enviar.";
                    
                    } else {
                    
                    	$resposta['situacao'] = "sucess";
                    	$resposta['msg'] = "Enviado com sucesso.";
                    }
                    
                    
                    echo Zend_Json::encode($resposta);
        }
    }

    function avaliacaoAction() {

        /* Desabilita o layout */
        $this->_helper->layout()->disableLayout();
        $request = ($this->getRequest());
        $aRequest = $request->getPost();

        $mail = new Zend_Mail();
        $sMsg = '-- Solicita��o de an�lise de im�vel para an�ncio --' . "\n";
        $sMsg .= "\n";
        $sMsg .= 'Nome : ' . strip_tags($aRequest['avaliacao_nome']) . "\n";
        $sMsg .= 'Email : ' . strip_tags($aRequest['avaliacao_email']) . "\n";
        $sMsg .= 'Telefone : ' . strip_tags($aRequest['avaliacao_telefone']) . "\n";
        $sMsg .= 'Mensagem : ' . strip_tags($aRequest['avaliacao_mensagem']) . "\n";

        $mail->setBodyText($sMsg);
        $mail->setFrom($aRequest['avaliacao_email'], $aRequest['avaliacao_nome']);
        $mail->addTo(array('atendimento@tradicaoimoveisgo.com.br'), 'Tradi��o (Solicita��o de avalia��o)');
        /* Assunto do email */
        $mail->setSubject('Solicita��o de an�lise de im�vel para an�ncio');

        $mail->send();
    }

    function gravaMensagem($aDados) {
        /* Grava mensagem de contato no banco de dados */
        $mensagemModel = new Application_Model_Mensagem();
        $mensagemMapper = Application_Model_MensagemMapper::instanciar();
        $mensagemModel->setOptions($aDados);
        $mensagemMapper->save($mensagemModel);
        return true;
    }

    /**
     * 
     * Envia um email para a tradi��o com os parametros de busca
     * para que a seja encontrado um im�vel com as caracter�sticas buscadas
     */
    function interesseAction() {

        /* Desabilita o layout */
        $this->_helper->layout()->disableLayout();
        $request = ($this->getRequest());
        $aRequest = $request->getPost();

        //print_rpre($aRequest); exit;
        $caracteristicas = utf8_decode($aRequest['encontrar_hidden']);
        $mail = new Zend_Mail();
        $sMsg = '-- Solicita��o de interesse de im�vel --' . "\n";
        $sMsg .= "\n";
        $sMsg .= 'Nome : ' . strip_tags($aRequest['encontrar_nome']) . "\n";
        $sMsg .= 'Email : ' . strip_tags($aRequest['encontrar_email']) . "\n";
        $sMsg .= 'Telefone : ' . strip_tags($aRequest['encontrar_telefone']) . "\n";
        $sMsg .= 'Caracter�sticas buscadas: ' . strip_tags($caracteristicas) . "\n";
        $sMsg .= "\n";
        $sMsg .= 'Caracter�sticas solicitadas: ' . "\n";

        if ($aRequest['localizarfinalidade'] == '1') {
            $sMsg .= 'Finalidade: ' . $aRequest['localizarfinalidade'] . "\n";
        } else {
            $sMsg .= 'Finalidade: ' . utf8_decode($aRequest['hidden_localizarvenda']) . "\n";
        }

        if ($aRequest['campo_localizartipo']) {
            $sMsg .= 'Tipo: ' . $aRequest['campo_localizartipo'] . "\n";
        }

        if ($aRequest['encontrar_preco']) {
            $sMsg .= 'Pre�o: ' . $aRequest['encontrar_preco'] . "\n";
        }

        if ($aRequest['encontrar_cidade']) {
            $sMsg .= 'Bairro: ' . $aRequest['encontrar_cidade'] . "\n";
        }

        $mail->setBodyText($sMsg);
        $mail->setFrom($aRequest['encontrar_email'], $aRequest['encontrar_nome']);
        $mail->addTo(array('atendimento@tradicaoimoveisgo.com.br'), 'Tradi��o (Solicita��o de interesse de im�vel)');
        /* Assunto do email */
        $mail->setSubject('Solicita��o de interesse de im�vel');

        $mail->send();
    }

}

