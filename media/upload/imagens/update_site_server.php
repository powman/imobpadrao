<?php
/**
 * Arquivo que faz update no site
 * 
 * este arquivo é hospedado junto as fotos dos imoveis este arquivo realiza os seguintes trabalhos:
 * - Conectar no banco de dados 
 * - Lê o arquivo update.sql que foi subido via ftp
 * - Expode o arquivo usando o separador '--'
 * - executa cada linha de resultado no banco
 * - deleta todos os setores, cidades e tipo_imoveis que não tiverem imoveis utilizando 
 */
error_reporting(0);
$aResult = array();
try {
	/* - Conectar no banco de dados*/
	require_once 'config.php';
	$conexao = mysql_connect($server, $username, $password);
	if (!$conexao)
		throw new Exception('Não foi possível conectar ao banco');
	
	$db = mysql_select_db($dbname);
	
	/* - Lê o arquivo update.sql que foi subido via ftp*/
	$sql = trim(file_get_contents('update.sql'));
	if (!$sql)
		throw new Exception('O arquivo update.sql esta vazio');
		
	/* - Expode o arquivo usando o separador '--' */
	$sql = explode('[*-QUEBRADELINHA-*]', $sql);
	
	/* - executa cada linha de resultado no banco*/
	foreach ($sql as $linha) {
		/*verifica se a linha tem texto*/
		if (trim($linha)) {
			/*executa a linha no banco*/
			mysql_query($linha);
			
			/*verificando se deu erro*/
			if (mysql_error())
				throw new Exception(mysql_error());
		}
	}
	
	/* - Deletando setores*/
	mysql_query('delete from setor where idsetor not in (select idsetor from imovel)');
	if (mysql_error())
		throw new Exception(mysql_error());
		
	/* - Deletando cidades*/
	mysql_query('delete from cidade where idcidade not in (select idcidade from imovel)');
	if (mysql_error())
		throw new Exception(mysql_error());
		
	/* - Deletando tipo_imoveis*/
	mysql_query('delete from tipo_imovel where idtipo_imovel not in (select idtipo_imovel from imovel)');
	if (mysql_error())
		throw new Exception(mysql_error());
		
	
	if(unlink('update.sql')){
		$arquivo = fopen('update.sql','w+');
		if($arquivo){
			/*se chegou ate aqui é por que deu tudo certo*/
			$aResult = array('resultado' => true, 'mensagem' => 'Site atualizado com sucesso');
		}
	}
} catch (Exception $e) {
	/*tratamento do erro*/
	$sMensagem = "Não foi possivel atualizar as informações no site. \n\nMsg: " . $e->getMessage();
	$erro = error_get_last();
	if ($erro)
		$sMensagem .= "\n\n" . $erro['message'];
	$aResult = array('resultado' => false, 'mensagem' => strip_tags($sMensagem));
}
echo json_encode($aResult);
?>