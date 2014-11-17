<?php

/**
 * @package SYS
 */

/**
 * Converte data no formato unix timestamp para o formato intelegivel d/m/Y
 *
 * @param timestamp $date
 * @return string
 */
function datetostr($date = 'mktime') {
	if ($date == 'mktime') {	
		$date = time();
	}
	if (!$date)
		return '';
	if (!is_numeric($date)) {
		$msg = 'Erro na fun��o: ' . __FUNCTION__ . "\n";
		$msg .= 'O par�metro $date enviado(' . $date . ') n�o corresponde a um timestamp v�lido.';
		throw new Exception($msg);
	}
	return date('d/m/Y', $date);
}

/**
 * Converte data no formato unix timestamp para o formato intelegivel d/m/Y H:i
 *
 * @param timestamp $date
 * @return string
 */
function datetimetostr($date = 'mktime') {
	if ($date == 'mktime') {
		$date = time();
	}
	if ($date < 1) {
		return '';
	}
	return date('d/m/Y H:i', $date);
}

/**
 * O mesmo que {@link strtodatetime} com a diferen�a que interpreta
 * os minutos e segundos separadamente
 *
 * Ex:
 * <code>
 * echo strtodate('01/01/2009', '14:30');//1230827400
 * echo strtodate('1/1/2009', '14:30');//1230827400
 * echo strtodate('01012009', '14:30');//1230827400
 * </code>
 *
 * @param ISO8859 $date
 * @param ISO8859 $time
 * @return timestamp
 */
function strtodate($date, $time = "") {
	if (!trim($date)) {
		/*se n�o tiver data n�o devolve nada*/
		return null;
	} else if (is_numeric($date) && strlen($date) > 8) {
		/*se a data for numerica provavelmente j� � um timestamp*/
		return $date;
	}
	$hour = $min = $sec = 0;
	$time = str_replace(array('-', '/', '.', ':', ' '), '', $time);
	switch (strlen($time)) {
		case 0:
			break;
		case 1: #h
		case 2: #hh
			$hour = $time;
			break;
		case 3: #hmm
			$hour = substr($time, 0, 1);
			$min = substr($time, 1, 2);
			break;
		case 4: #hhmm
			$hour = substr($time, 0, 2);
			$min = substr($time, 2, 2);
			break;
		case 6: #hhmmss
			$hour = substr($time, 0, 2);
			$min = substr($time, 2, 2);
			$sec = substr($time, 4, 2);
			break;
		default:
			return null;
	}
	
	/*a data n�o tem separadores (formato ddmmaaaa)*/
	if (is_numeric($date) && strlen($date) == 8) {
		$aux = $date;
		$date = array();
		$date[] = substr($aux, 0, 2); //dd
		$date[] = substr($aux, 2, 2); //mm
		$date[] = substr($aux, 4); //aaaa
	} else {
		/*a data esta no formato dd/mm/aaaa ou dd-mm-aaaa ou dd mm aaaa*/
		$date = str_replace(array('-', '/', '.', ':', ' '), ' ', $date);
		$date = explode(' ', $date);
	}
	
	/*se a quantidade de partes da data n�o for 3*/
	if (count($date) != 3)
		throw new Exception('Erro na passagem de parametros');
	
	return mktime($hour, $min, $sec, (int)$date[1], (int)$date[0], (int)$date[2]);
}

/**
 * Converte data no formato ISO8859 (o formato 'd/m/Y H:i' veja {@link date})
 * para o formato unix timestamp (veja {@link time})
 *
 * Ex:
 * <code>
 * echo strtodatetime('01/01/2009 14:30');//1230827400
 * </code>
 *
 * @param ISO8859 $datetime
 * @return timestamp
 */
function strtodatetime($datetime) {
	$i = strrpos($datetime, ' ');
	if ($i === false) {
		if (strlen($datetime) == 12) {
			$d = substr($datetime, 0, 8);
			$t = substr($datetime, 8);
			return strtodate($d, $t);
		} else {
			return strtodate($datetime);
		}
	} else {
		$d = substr($datetime, 0, $i);
		$t = substr($datetime, ($i + 1));
		return strtodate($d, $t);
	}
}

/**
 * Retorna o m�s por exten�o
 *
 * @param integer 1 = janeiro
 * @return string
 */
function KM_extensoMes($mes) {
	/*definindo os nomes dos meses*/
	$nmMes = array(
				1 => 'janeiro', 
				2 => 'fevereiro', 
				3 => 'mar�o', 
				4 => 'abril', 
				5 => 'maio', 
				6 => 'junho', 
				7 => 'julho', 
				8 => 'agosto', 
				9 => 'setembro', 
				10 => 'outubro', 
				11 => 'novembro', 
				12 => 'dezembro');
	
	/*multiplica por um para tirar eventuais zeros a esquerda. Ex: date('y'); */
	$mes *= 1;
	
	/*verifica se o mes informado existe no array*/
	if (!isset($nmMes[$mes]))
		throw new Exception('Valor de $mes "' . $mes . '" inv�lido. Valores v�lidos est�o entre 1 e 12.');
	
	return $nmMes[$mes];
}

function dateFormatBr($date){
	$aux = explode('-', $date);
	$data = $aux[2].'/'.$aux[1].'/'.$aux[0];
	return $data ;
}

function dateFormatEn($date){
	$aux = explode('/', $date);
	$data = $aux[2].'-'.$aux[1].'-'.$aux[0];
	return $data ;
}

/**
 * Retorna por exteso a quantidade de tempo contida no numero de dias
 * informados em $numDias
 *
 * Ex:
 * <code>
 * echo km_extensoPeriodo(36); // 1 m�s e 6 dias
 * echo km_extensoPeriodo(900); // 2 anos, 5 m�ses e 20 dias
 * echo km_extensoPeriodo(40); // 1 m�s e 10 dias
 * </code>
 *
 * @param float $numDias
 * @return string
 */
function KM_extensoPeriodo($numDias) {
	/*parte inteira - dias/meses/anos*/
	$pInteiro = floor($numDias);
	$a = floor($pInteiro / 365);
	$m = floor(($pInteiro % 365) / 30);
	$d = $pInteiro % 365 % 30;
	
	/*parte fracionaria - horas/minutos*/
	$pFracao = ($numDias - $pInteiro) * 24;
	$hora = floor($pFracao);
	$minuto = floor(($pFracao - $hora) * 60);
	
	$return = '';
	if ($a) {
		$return = $a . ' ano' . ($a > 1 ? 's' : '');
	}
	
	if ($m) {
		if ($a) {
			$return .= ($d ? ', ' : ' e ');
		}
		$return .= $m . ' m�s' . ($m > 1 ? 'es' : '');
	}
	
	if ($d) {
		$return .= ($a || $m ? ' e ' : '');
		$return .= $d . ' dia' . ($d > 1 ? 's' : '');
	}
	
	if ($hora) {
		$return .= ($return ? ' e ' : '');
		$return .= $hora . ' hora' . ($hora > 1 ? 's' : '');
	}
	
	if ($minuto) {
		$return .= ($return ? ' e ' : '');
		$return .= $minuto . ' min';
	}
	return $return;
}

/**
 * Retorna o dia da semana por exten�o
 *
 * @param integer 0 = dimingo; 6 = sabado
 * @return string
 */
function KM_extensoDiaSemana($dia) {
	$nmDia = array();
	$nmDia[0] = 'Domingo';
	$nmDia[1] = 'Segunda Feira';
	$nmDia[2] = 'Ter�a Feira';
	$nmDia[3] = 'Quarta Feira';
	$nmDia[4] = 'Quinta Feira';
	$nmDia[5] = 'Sexta Feira';
	$nmDia[6] = 'S�bado';
	return $nmDia[$dia];
}

/**
 * Fun��o que faz abrevia��o de nomes de pessoas
 * Ex:
 * <code>
 * echo KM_abreviarNome('jo�o pedro da silva dos santos');
 * //Resultado: "Jo�o P. S. Santos"
 * </code>
 *
 * @param string $sNome
 * @return string
 */
function KM_abreviarNome($sNome) {
	$aNome = explode(' ', $sNome);
	$j = count($aNome);
	for ($i = 1; $i < $j - 1; $i++) {
		if (strlen($aNome[$i]) <= 3) {
			unset($aNome[$i]);
		} else {
			$aNome[$i] = substr($aNome[$i], 0, 1) . '.';
		}
	}
	return ucwords(strtolower(join(' ', $aNome)));
}

/**
 * Devolve a string passada configurando maiusculas e minusculas
 * em conformidade com padr�es de legibilidade estabelecidos
 *
 * Ex:
 * <code>
 * echo str_upper_lower('diego tolentino de ribeiro');//Diego Tolentino de Ribeiro
 * </code>
 *
 * @param string $str
 * @return string
 */
function str_upper_lower($str) {
	/**
	 * array contendo todos os separadores
	 */
	$aSep = array(' ', '-', '/', '_', '.', '*', '(');
	
	/**
	 * todas as que contenham os separadores abaixo devem ter a primeira maiuscula
	 */
	$aSepUpper = '/[-.\/]/';
	
	/**
	 * coloca todas as palavras com letras minusculas
	 */
	$str = ucfirst(strtolower($str));
	
	/**
	 * testa todos os separadores
	 */
	foreach ($aSep as $sep) {
		if (strpos($str, $sep) !== false) {
			/**
			 * separa a frase usando os separador atual
			 */
			$aWord = explode($sep, $str);
			$str = '';
			foreach ($aWord as $key => $word) {
				/**
				 * se a quantidade de caracteres for maior que dois, ou se conter ponto,
				 * devolve upper da primeira letra
				 */
				if (strlen($word) > 2 || preg_match($aSepUpper, $word . $sep)) {
					$word = ucfirst($word);
				}
				$str .= $word;
				/**
				 * n�o adiciona o separador no fim de strings
				 */
				if ($key < count($aWord) - 1) {
					$str .= $sep;
				}
			}
		}
	}
	return $str;
}

/**
 * Transforma uma certa string formatada para guardar valores de parametros,
 * caso $toHumanCase = true a string para mostrar ser� tratada pela
 * fun��o str_upper_lower(), caso false ser� mantida como o original
 *
 * Ex:
 * <code>
 * print_r(KM_getIniConf('1=Venda;3=Loteamento')); // Array(1=>'Venda', 3=>'Loteamento')
 *
 * print_r(KM_getIniConf('VENDA;LOTEAMENTO')); // Array('VENDA'=>'Venda', 'LOTEAMENTO'=>'Loteamento')
 * </code>
 *
 * @param String $strIni
 * @param bool $toHumanCase
 * @param bool $order
 * @return array
 */
function KM_getIniConf($strIni, $toHumanCase = true, $order = false) {
	$aux = explode(';', $strIni);
	$return = array();
	foreach ($aux as $val) {
		if (strpos($val, '=')) {
			list($key, $val) = explode('=', $val);
		} else {
			$key = $val;
		}
		$return[$key] = ($toHumanCase ? str_upper_lower($val) : $val);
	}
	if ($order) {
		asort($return);
	}
	return $return;
}

/**
 * Utilizando como base a fun��o KM_getIniConf
 * esta fun��o devolve a parte visual da configura��o
 * recebendo o valor
 *
 * Ex:
 * <code>
 * echo KM_getIniLabel('1=Venda;3=Loteamento', 1); // 'Venda'
 * </code>
 *
 * @param string $strIni
 * @param mixed $value
 * @param bool $toHumanCase
 * @return mixed
 */
function KM_getIniLabel($strIni, $value, $toHumanCase = true) {
	$aux = KM_getIniConf($strIni, $toHumanCase);
	if (isset($aux[$value])) {
		return $aux[$value];
	} else {
		trigger_error('O indice:' . $value . ' n�o encontrado em:' . $strIni);
		return '';
	}
}

/**
 * Retorna uma data inteira por extenso
 *
 * Variaveis
 * [d]	: dia numerico
 * [deo]	: dia por extenso (ordinal)
 * [den]	: dia por extenso (numerico)
 * [m]	: mes numerico
 * [me]	: mes por extenso
 * [a]	: ano numerico
 * [ae]	: ano por extenso
 * [Hi]	: Hora:Minuto numerico
 *
 * Ex:
 * <code>
 *
 * echo KM_extensoData(time, '[d] de [em] de [a] �s [Hi] horas');
 * #Exite "28 de abril de 2008 �s 14:40 horas"
 *
 * echo KM_extensoData(time, '[d]([de]) dias do m�s de [me]([m]) de [a] ([a])�s [Hi] horas');
 * #Exite "28(vinte e oito) dias do m�s de abril(04) de 2008 (dois mil e oito)�s 14:40 horas"
 *
 * @param timestamp|ISO8859 $data enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @param boolean $incluiHora se false ser� ignorado o formato presente na variavel $formatoHora
 * @param string $formatoHora formato da hora do retorno, se null ou false suprime a hora
 * no retorno
 * @param string $formatoData formato da data a ser devolvido
 * @return string
 */
function KM_extensoData($data, $incluiHora = true, $formatoData = '[d] de [me] de [a]', $formatoHora = '�s [Hi] horas') {
	if (!$data) {
		return false;
	}
	if (!is_numeric($data)) {
		$data = strtodatetime($data);
	}
	
	if ($incluiHora && $formatoHora) {
		$formatoData .= ' ' . $formatoHora;
	}
	
	$aParams = array(
					'[d]' => 'date("d", $data)', 
					'[de]' => 'KM_extensoDia(date("d", $data))', 
					'[den]' => 'KM_extensoNumero(date("d", $data))', 
					'[m]' => 'date("m", $data)', 
					'[me]' => 'KM_extensoMes(date("m", $data))', 
					'[a]' => 'date("Y", $data)', 
					'[ae]' => 'KM_extensoNumero(date("Y", $data))', 
					'[Hi]' => 'date("H:i", $data)');
	foreach ($aParams as $key => $val) {
		$formatoData = str_replace($key, eval("return $val;"), $formatoData);
	}
	return $formatoData;
}

/**
 * Retorna o dia do mes por exten�o
 *
 * @param integer $dia
 * @return string
 */
function KM_extensoDia($dia) {
	$aUni = array();
	$aUni[0] = '';
	$aUni[1] = 'primeiro';
	$aUni[2] = 'segundo';
	$aUni[3] = 'terceiro';
	$aUni[4] = 'quarto';
	$aUni[5] = 'quinto';
	$aUni[6] = 'sexto';
	$aUni[7] = 's�timo';
	$aUni[8] = 'oitavo';
	$aUni[9] = 'nono';
	
	$aDec = array();
	$aDec[0] = '';
	$aDec[1] = 'd�cimo';
	$aDec[2] = 'vig�simo';
	$aDec[3] = 'trig�simo';
	
	$dia = str_pad($dia, 2, '0', STR_PAD_LEFT);
	$dia0 = substr($dia, 0, 1);
	$dia1 = substr($dia, 1, 1);
	$result = $aDec[$dia0];
	$result .= ($result ? ' ' : '');
	$result .= $aUni[$dia1];
	
	return $result;
}

/**
 * Escreve um numero por extenso
 *
 * @param integer $iNumero
 * @return strinc
 */
function KM_extensoNumero($iNumero) {
	$aUnidade = array(
					'', 
					'um', 
					'dois', 
					'tr�s', 
					'quatro', 
					'cinco', 
					'seis', 
					'sete', 
					'oito', 
					'nove', 
					'dez', 
					'onze', 
					'doze', 
					'treze', 
					'quatorze', 
					'quinze', 
					'dezesseis', 
					'dezessete', 
					'dezoito', 
					'dezenove');
	$aDezena = array('', '', 'vinte', 'trinta', 'quarenta', 'cinq�enta', 'sessenta', 'setenta', 'oitenta', 'noventa');
	
	$aCentena = array(
					'cem', 
					'cento', 
					'duzentos', 
					'trezentos', 
					'quatrocentos', 
					'quinhentos', 
					'seiscentos', 
					'setecentos', 
					'oitocentos', 
					'novecentos');
	$singular = array('', 'mil', 'milh�o', 'bilh�o', 'trilh�o', 'quatrilh�o');
	$plural = array('', 'mil', 'milh�es', 'bilh�es', 'trilh�es', 'quatrilh�es');
	
	$iMilhar = intval($iNumero / 1000);
	$iCentena = intval($iNumero % 1000 / 100);
	$iDezena = intval($iNumero % 1000 % 100 / 10);
	$iUnidade = $iNumero % 1000 % 100 % 10;
	$result = '';
	
	if ($iMilhar) {
		$aCentenaMilhar = array();
		
		/*pega o nome da fun��o atual para chamar recursivamente*/
		$func = __FUNCTION__;
		
		/*inverte a string. Ex: 1234 => 4321*/
		$iMilhar = strrev($iMilhar);
		
		/*separa a str em peda�os. Ex: array('432', '1')*/
		$aCentenaMilhar = str_split($iMilhar, 3);
		
		for ($i = count($aCentenaMilhar) - 1; $i >= 0; $i--) {
			$j = $i + 1;
			$valor = strrev($aCentenaMilhar[$i]) * 1;
			/*ignora valores como 000*/
			if ($valor) {
				$result .= ($result ? ' ' : '');
				$result .= $func($valor);
				$result .= ' ' . ($valor > 1 ? $plural[$j] : $singular[$j]);
			}
		}
	}
	
	if ($iCentena) {
		if ($iCentena == 1 && $iDezena == 0 && $iUnidade == 0) {
			if ($iMilhar)
				$result .= ' e ';
			$result .= 'cem';
		} else {
			if ($iMilhar)
				$result .= ' ';
			$result .= $aCentena[$iCentena];
		}
	}
	
	if ($iDezena) {
		if ($iCentena || $iMilhar)
			$result .= ' e ';
		if ($iDezena < 2) {
			$result .= $aUnidade[$iDezena * 10 + $iUnidade];
			return $result;
		} else
			$result .= $aDezena[$iDezena];
	}
	
	if ($iUnidade) {
		if ($iCentena || $iMilhar || $iDezena)
			$result .= ' e ';
		$result .= $aUnidade[$iUnidade];
	}
	return $result;
}

/**
 * Reescrito a fun��o de mostrar o valor em real por extenso
 * agora ela depende da fun��o {@link KM_extensoNumero}
 *
 * @param float $valor
 * @return string
 */
function KM_extensoValor($valor = 0) {
	if (strpos($valor, '.')) {
		list($int, $dec) = explode('.', number_format($valor, 2, '.', ''));
	} else {
		$int = $valor;
		$dec = false;
	}
	$resultado = '';
	
	/*$oLocale = KM::getLocale();
	
	if ($int > 0) {
		$resultado .= KM_extensoNumero($int);
		$resultado .= ' ' . ($int > 1 ? $oLocale::monetarioExtensoInteiroPlural : $oLocale::monetarioExtensoInteiroSingular);
	}
	
	if ($dec > 0) {
		$resultado .= ($resultado ? ' e ' : '');
		$resultado .= KM_extensoNumero($dec);
		$resultado .= ' ' . ($dec > 1 ? $oLocale::monetarioExtensoDecimalPlural : $oLocale::monetarioExtensoDecimalSingular);
	}*/
	
	return $resultado;
}

/**
 * Procura no diret�rio $sDir e em seus sub-diret�rios
 * por arquivos/diret�rios modificados a mais que $iTime
 * segundos e os apaga
 *
 * @author L�zaro Diego Tolentino
 *
 * @param string $sDir nome do diret�rio a verificado
 * @param integer $iTime valor em segundos
 * @return bool
 */
function KM_remove_tmp_files($sDir, $iTime = 300) {
	/*consistencia dos parametros*/
	if (!is_dir($sDir) || !is_integer($iTime))
		return false;
		
	/*mostra o debug*/
	if (defined('KM_DEBUG') && KM_DEBUG === true)
		echo __FUNCTION__ . '("' . $sDir . '", "' . datetimetostr(KM_dataCalc(time(), 0, -$iTime / 60)) . '")<br>';
		
	/*retorna um array com o conteudo do diretorio*/
	$aDir = scandir(str_replace('\\', '/', $sDir));
	
	/*varre o conteudo de $sDir, apagando recursivamente seu conteudo*/
	foreach ($aDir as $sContent) {
		$sContent = $sDir . '/' . $sContent;
		
		/*se � um arquivo e mais antigo que $iTime */
		if (is_file($sContent) && (time() - filemtime($sContent) > $iTime)) {
			unlink($sContent);
		}
	}
	return true;
}

/**
 * Salva dados em um arquivo temporario no diretorio indicado em KM::getDirTmp()
 *
 * @param string $dados dados a serem salvos
 * @param string $path_LW se ir� devolver o caminho para o arquivo em disco(local) ou web
 * @param string $ext exten��o do arquivo
 * @param string $nome nome do arquivo, se escolhido ignora o parametro $ext
 * @return string
 */
function KM_tempFile($dados, $path_LW = 'L', $ext = '.tmp', $nome = '') {
	if ($nome) {
		$nome = KM::getDirTmp() . '/' . $nome;
	} else {
		$nome = KM::getDirTmp() . '/TempFile_';
		
		if (session_id())
			$nome .= session_id() . '_' . md5($dados);
		else
			$nome .= substr(microtime(), 2, 8) . '_' . md5($dados);
		
		$nome .= $ext;
	}
	$fh = fopen($nome, 'w');
	fwrite($fh, $dados);
	fclose($fh);
	if (strtoupper($path_LW) == 'L') {
		return $nome;
	} else {
		return KM::getWebTmp() . end(explode('/', $nome));
	}
}

/**
 * Linux: C�digo-fonte do script: Valida��o de CPF e CNPJ
 * http://www.vivaolinux.com.br/scripts/verFonte.php?codigo=866&arquivo=valida_docs.php
 *
 * @author Marcelo Bom Jardim <suporte@onzehost.net> http://www.onzehost.net
 *
 * e a corre��o http://br.answers.yahoo.com/question/index?qid=20060829190814AAHOqY6
 *
 * @param string $cpf
 * @return bool
 */
function KM_checkCpf($cpf) {
	$cpf = preg_replace('/[^0-9]/', '', $cpf);
	$soma = 0;
	if (strlen($cpf) != 11) {
		return false;
	}
	/**
	 * Verifica 1� digito
	 */
	for ($i = 0; $i < 9; $i++) {
		$soma += $cpf[$i] * (10 - $i);
	}
	$fator = $soma % 11;
	/* Se Valor igual a 0 ou 1 Dig1 recebe 0 senao */
	$d1 = $fator < 2 ? 0 : 11 - $fator;
	/**
	 * Verifica 2� digito
	 */
	$soma = 0;
	for ($i = 0; $i < 10; $i++) {
		$soma += $cpf[$i] * (11 - $i);
	}
	$fator = $soma % 11;
	/* Se Valor igual a 0 ou 1 Dig1 recebe 0 senao */
	$d2 = $fator < 2 ? 0 : 11 - $fator;
	
	if ($d1 == $cpf[9] && $d2 == $cpf[10]) {
		return true;
	} else {
		return false;
	}
}

/**
 * Linux: C�digo-fonte do script: Valida��o de CPF e CNPJ
 * http://www.vivaolinux.com.br/scripts/verFonte.php?codigo=866&arquivo=valida_docs.php
 *
 * @author Marcelo Bom Jardim <suporte@onzehost.net> http://www.onzehost.net
 *
 * @param string $cnpj
 * @return bool
 */
function KM_checkCnpj($cnpj) {
	$cnpj = preg_replace('/[^0-9]/', '', $cnpj);
	if (strlen($cnpj) != 14) {
		return false;
	}
	
	$soma = 0;
	$soma += ($cnpj[0] * 5);
	$soma += ($cnpj[1] * 4);
	$soma += ($cnpj[2] * 3);
	$soma += ($cnpj[3] * 2);
	$soma += ($cnpj[4] * 9);
	$soma += ($cnpj[5] * 8);
	$soma += ($cnpj[6] * 7);
	$soma += ($cnpj[7] * 6);
	$soma += ($cnpj[8] * 5);
	$soma += ($cnpj[9] * 4);
	$soma += ($cnpj[10] * 3);
	$soma += ($cnpj[11] * 2);
	
	$d1 = $soma % 11;
	$d1 = $d1 < 2 ? 0 : 11 - $d1;
	
	$soma = 0;
	$soma += ($cnpj[0] * 6);
	$soma += ($cnpj[1] * 5);
	$soma += ($cnpj[2] * 4);
	$soma += ($cnpj[3] * 3);
	$soma += ($cnpj[4] * 2);
	$soma += ($cnpj[5] * 9);
	$soma += ($cnpj[6] * 8);
	$soma += ($cnpj[7] * 7);
	$soma += ($cnpj[8] * 6);
	$soma += ($cnpj[9] * 5);
	$soma += ($cnpj[10] * 4);
	$soma += ($cnpj[11] * 3);
	$soma += ($cnpj[12] * 2);
	
	$d2 = $soma % 11;
	$d2 = $d2 < 2 ? 0 : 11 - $d2;
	
	if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
		return true;
	} else {
		return false;
	}
}

/**
 * Valida se uma string � um cpf ou um cnpj
 *
 * @param string $cpf_cnpj
 * @return bool
 */
function KM_checkCpfCnpj($cpf_cnpj) {
	if (KM_checkCpf($cpf_cnpj)) {
		return true;
	} else {
		return KM_checkCnpj($cpf_cnpj);
	}
}

/**
 * Melhoramento da fun��o {@link print_r}, mostra as quebras de linha
 * e identa��es no formato html
 *
 * @param array $array
 * @param boolean $return se o resultado ser� retornado ou escrito diretamente no output
 * @return text/html
 */
function print_rpre($aDados, $return = false) {
	$sResult = '<p><pre>' . print_r($aDados, true) . '</pre></p>';
	
	/*escreve ou retorna o resultado*/
	if ($return) {
		return $sResult;
	} else {
		echo $sResult;
	}
}

/**
 * Diferen�a de Dias/horas entre duas datas passadas, se o valor de retorno
 * for negativo o valor de $dataIni � posterior a $dataFin, se for igual �
 * o mesmo dia
 *
 * @author phpbrasil.com {@link http://phpbrasil.com/scripts/script.php/id/18}
 *
 * @param timestamp|ISO8859 $dataIni enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @param timestamp|ISO8859 $dataFin enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @param bool $ignoraHoraMinuto se true calcula somente a diferen�a entre
 * dias inteiros ignorando horas/minutos
 * Ex:
 * <code>
 *
 * KM_dataDiff('14/01/2008 10:45', '14/01/2008 15:00', true);// retorna 0
 *
 * </code>
 *
 * se false o resultado ser� um bouble sendo a parte inteira a diferen�a de
 * dias e a decimal de horas/minutos
 * Ex:
 * <code>
 *
 * KM_dataDiff('10/01/2008 10:45', '14/01/2008 11:50', false);
 * // retorna 3.04513888888888939 ou 3 dias e .04513888888888939 horas, que multiplicado por 24 da 1.083333333333343
 * // multiplicando-se a parte fracionada da hora .083333333333343 por 60 da algo como 5,000000000000592
 * // resultado: 3 Dias, 1 Hora e 5 minutos
 *
 * </code>
 *
 * @param bool $bResultadoArray se true devolve um array com os valores
 * <code>
 * print_r(KM_dataDiff('10/01/2008 10:45', '14/01/2008 11:50', false, true));
 * //ir� imprimir: array('dia' => 3, 'hora' => 1, 'minuto' => 5);
 * </code>
 * @return integer|double
 */
function KM_dataDiff($dataIni, $dataFin, $ignoraHoraMinuto = false, $bResultadoArray = false) {
	if (!is_numeric($dataIni)) {
		$dataIni = strtodatetime($dataIni);
	}
	if (!is_numeric($dataFin)) {
		$dataFin = strtodatetime($dataFin);
	}
	if ($ignoraHoraMinuto) {
		$dataIni = strtodate(datetostr($dataIni));
		$dataFin = strtodate(datetostr($dataFin));
	}
	$date_diff = ($dataFin - $dataIni) / 86400;
	
	if ($ignoraHoraMinuto)
		$date_diff = floor($date_diff);
	
	if ($bResultadoArray) {
		$aResult = array();
		$aResult['dia'] = $date_diff;
		$aResult['hora'] = floor($date_diff * 24);
		$aResult['minuto'] = $date_diff * 1440 - $aResult['hora'] * 60;
		return $aResult;
	} else {
		return $date_diff;
	}
}

/**
 * Calcula a nova data com base na $dtAtual e nos parametros
 * � permitido calcular as datas para mais ou para memos
 *
 * @param timestamp|ISO8859 $dtAtual enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @param integer $dtAtual
 * @param integer $newDtDia
 * @param integer $newDtMin
 * @param integer $newDtHora
 * @param integer $newDtMes
 * @param integer $newDtAno
 * @return timestamp
 */
function KM_dataCalc($dtAtual, $newDtDia = 0, $newDtMin = 0, $newDtHora = 0, $newDtMes = 0, $newDtAno = 0) {
	if (!is_numeric($dtAtual)) {
		$dtAtual = strtodatetime($dtAtual);
	}
	if (!$newDtDia && !$newDtMin && !$newDtHora && !$newDtMes && !$newDtAno) {
		$newDtHora = 23;
		$newDtMin = 59;
	} else {
		$newDtHora = date('H', $dtAtual) + $newDtHora;
		$newDtMin = date('i', $dtAtual) + $newDtMin;
	}
	
	$newDtDia = date('d', $dtAtual) + $newDtDia;
	$newDtMes = date('m', $dtAtual) + $newDtMes;
	$newDtAno = date('Y', $dtAtual) + $newDtAno;
	return mktime($newDtHora, $newDtMin, 0, $newDtMes, $newDtDia, $newDtAno);
}

/**
 * Substitui os valores fornecidos na data e devolve o timestamp
 *
 * @param timestamp|ISO8859 $dtAtual enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @param integer $dtAtual
 * @param integer $iHora
 * @param integer $iMinuto
 * @param integer $iDia
 * @return timestamp
 */
function KM_dataReplace($dtAtual, $iHora = 0, $iMinuto = 0, $iDia = 0) {
	if (!is_numeric($dtAtual)) {
		$dtAtual = strtodate($dtAtual);
	}
	
	if (!($iHora >= 0 && $iHora <= 23))
		throw new Exception('Hora invalida na fun��o ' . __FUNCTION__ . ', ' . print_r(func_get_args(), true));
	
	if (!($iMinuto >= 0 && $iMinuto <= 59))
		throw new Exception('Minuto invalido na fun��o ' . __FUNCTION__ . ', ' . print_r(func_get_args(), true));
	
	if (!($iMinuto >= 0 && $iMinuto <= 59))
		throw new Exception('Minuto invalido na fun��o ' . __FUNCTION__ . ', ' . print_r(func_get_args(), true));
	
	if (!($iDia >= 0 && $iDia <= 31))
		throw new Exception('Dia invalido na fun��o ' . __FUNCTION__ . ', ' . print_r(func_get_args(), true));
	else if ($iDia == 0)
		$iDia = date('d', $dtAtual);
	
	$Mes = date('m', $dtAtual);
	$Ano = date('Y', $dtAtual);
	return mktime($iHora, $iMinuto, 0, $Mes, $iDia, $Ano);
}

/**
 * Fun��o que retorna se o dia � util ou n�o
 *
 * @param timestamp|ISO8859 $dtAtual enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @return boolean
 */
function KM_dataEhDiaUtil($dtAtual) {
	if (!is_numeric($dtAtual)) {
		$dtAtual = strtodatetime($dtAtual);
	}
	$diaSemana = date('w', $dtAtual);
	return $diaSemana != 0/*Domingo*/ && $diaSemana != 6/*S�bado*/ && !KM_dataEhFeriado($dtAtual);
}

/**
 * Retorna uma matriz de datas marcadas como feriados
 *
 * Ex:
 * //devolte uma matriz que desabilita as datas de ontem pra tras,
 * //dos proximos 15 dias p/ frente e l� a tabela de feriados
 * KM_dataGetFeriados(-1, 15, true)
 *
 * @param integer|timestamp|boolean $pHabilitadoInicio se for passado um inteiro calcula
 * a data de inicio da parte habilitada do calendario com base na data atual,
 * veja o parametro $newDtDia da fun��o {@link KM_dataCalc}
 * @param integer|timestamp|boolean $pHabilitadoFim o mesmo que $pHabilitadoInicio mas no final do periodo
 * habilitado
 * @param boolean $pVerFeriado se ser� lida a tabela de $pVerFeriado
 * @param boolean $pDesDom se � para desabilitar o domingo
 * @param boolean $pDesSab se � para desabilitar o sabado
 * @return array
 */
function KM_dataGetFeriados($pHabilitadoInicio = false, $pHabilitadoFim = false, $pVerFeriado = true, $pDesDom = false, $pDesSab = false) {
	global $km_db;
	
	$query = new db_query($km_db);
	
	$aFeriado = array();
	$where = '';
	
	if ($pHabilitadoInicio !== false) {
		if ($pHabilitadoInicio > 730) {
			/*se maior que 2*365(dois anos em dias) trata o parametro como um timestamp*/
			$dt = $pHabilitadoInicio;
		} else {
			/*se menor calcula os dias*/
			$dt = KM_dataCalc(time(), $pHabilitadoInicio);
		}
		$where = '	DTFINAL>=' . $query->phptype_to_db('date', $dt);
		$aFeriado[] = array('null' => datetostr($dt));
	}
	
	if ($pHabilitadoFim !== false) {
		if ($pHabilitadoFim > 730) {
			/*se maior que 2*365(dois anos em dias) trata o parametro como um timestamp*/
			$dt = $pHabilitadoFim;
		} else {
			/*se menor calcula os dias*/
			$dt = KM_dataCalc(time(), $pHabilitadoFim);
		}
		$where .= ($where ? ' and ' : '');
		$where .= '	DTINICIAL<=' . $query->phptype_to_db('date', $dt);
		$aFeriado[] = array(datetostr($dt) => 'null');
	}
	
	if ($pDesSab) {
		$aFeriado[] = array('sabado' => 'sabado');
	}
	if ($pDesDom) {
		$aFeriado[] = array('domingo' => 'domingo');
	}
	
	/*retorna o array sem ler os feriados*/
	if (!$pVerFeriado) {
		return $aFeriado;
	}
	
	/*le a tabela de feriados*/
	$sql = 'select';
	$sql .= '	DTINICIAL,';
	$sql .= '	DTFINAL ';
	$sql .= 'from';
	$sql .= '	SYS_FERIADO ';
	if ($where) {
		$sql .= 'where';
		$sql .= '	' . $where;
	}
	$sql .= 'order by';
	$sql .= '	DTINICIAL';
	
	$query->open($sql);
	while ($query->fetch()) {
		$aFeriado[] = array($query->get_display_text('DTINICIAL') => $query->get_display_text('DTFINAL'));
	}
	return $aFeriado;
}

/**
 * Testa se o valor de $data � um feriado cadastrado no sistema
 *
 * @param timestamp|datetime $data  passar no formuato timestamp
 * veja {@link time} ou ISO8859 veja {@link strtodatetime}
 * @return boolean|string retorna o nome do feriado ou false caso n�o exista um
 */
function KM_dataEhFeriado($data) {
	global $KM_dataEhFeriado;
	
	if (!is_numeric($data)) {
		$data = strtodatetime($data);
	}
	
	/*se a data n�o foi lida ser� guardada na variavel global*/
	if (!isset($KM_dataEhFeriado[$data])) {
		global $km_db;
		
		$query = new db_query($km_db);
		
		$data = $query->phptype_to_db('date', $data);
		
		$sql = 'select';
		$sql .= '	NMFERIADO ';
		$sql .= 'from';
		$sql .= '	SYS_FERIADO ';
		$sql .= 'where';
		$sql .= '	DTINICIAL<=' . $data . ' and ';
		$sql .= '	DTFINAL>=' . $data;
		$query->open($sql);
		if ($query->fetch()) {
			$KM_dataEhFeriado[$data] = $query->NMFERIADO;
		} else {
			$KM_dataEhFeriado[$data] = false;
		}
	}
	return $KM_dataEhFeriado[$data];
}

/**
 * Retorna a proxima data util apartir da variavel $dtAtual
 *
 * @param timestamp|ISO8859 $dtAtual enviar no formato unix
 * timestamp veja {@link time} ou o formato 'd/m/Y H:i' veja {@link date}
 * @return timestamp
 */
function KM_dataProxDiaUtil($dtAtual) {
	$dtAtual = KM_dataReplace($dtAtual);
	while (!KM_dataEhDiaUtil($dtAtual)) {
		$dtAtual = KM_dataCalc($dtAtual, +1);
	}
	return $dtAtual;
}

/**
 * Fun��o que formata um valor numerico, para exibi��o do valor em moeda corrente
 *
 * @param float $value
 * @return string
 */
function KM_formatMoney($value) {
	$aux = number_format($value, 2, ',', '.');
	if ($value < 0) {
		$aux = '(' . str_replace('-', '', $aux) . ')';
	}/*
	$oLocale = KM::getLocale();
	return $oLocale::monetarioSimbolo . ' ' . $aux;*/
	return "";
}

/**
 * Fun��o que formata um valor numerico, para exibi��o no formato brasileiro
 *
 * @param float $value
 * @return string
 */
function KM_formatNunber($value, $num_decimal_places = 2) {
	if (is_null($value))
		return '';
	$value = round($value, $num_decimal_places);
	return number_format($value, $num_decimal_places, ',', '.');
}

/**
 * Fun��o que formata um cpf/cnpj
 *
 * @param string $cpfcnpj
 * @param bool $addSep se � para adicionar separadores para os campos
 * @return string
 */
function KM_formatCpfCnpj($cpfcnpj = null, $addSep = true) {
	$cpfcnpj = preg_replace('/[^0-9]/', '', $cpfcnpj);
	if (!$cpfcnpj) {
		return '';
	}
	
	if (KM_checkCpf($cpfcnpj)) {
		/*se a string for um cpf*/
		$isCpf = true;
	} else if (KM_checkCnpj($cpfcnpj)) {
		/*se a string for um cpnj*/
		$isCpf = false;
	} else {
		$aux = substr($cpfcnpj, strlen($cpfcnpj) - 11);
		if (strlen($cpfcnpj) == 11 || KM_checkCpf($aux)) {
			/*se os ultimos 11 caracteres forem um cpf*/
			$isCpf = true;
			$cpfcnpj = $aux;
		} else {
			return $cpfcnpj;
		}
	}
	
	if (!$addSep) {
		/*retorna s� os numeros caso n�o seja para adicionar os separadores*/
		return $cpfcnpj;
	}
	
	/*adiciona os separadores de acordo com o tipo*/
	if ($isCpf) {
		return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpfcnpj);
	} else {
		return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $cpfcnpj);
	}
}

/**
 * Coloca uma mascara no CEP
 * ex '74023045' => '74.023-045'
 *
 * @param string $cep
 * @return string
 */
function KM_formatCEP($cep) {
	$cep = preg_replace('/[^0-9]/', '', $cep);
	if ($cep)
		$cep = substr($cep, 0, 2) . '.' . substr($cep, 2, 3) . '-' . substr($cep, 5);
	return $cep;
}

/**
 * Remove acento dos caracteres acentuados e com cedilha na string
 * Recomenda��o: para renomear nome de arquivos dos uploads, etc.
 * Modo de Uso:
 * $sFileName = removerAcentos('negocia��o.xml'); // retorna: 'negociacao.xml'
 *
 * @author Walker Alencar <walkeralencar@gmail.com>
 * @param string $pString texto com caracteres acentuados.
 * @return string
 */
function KM_strToASCII($pString, $pIsUTF8 = false) {
	$aMatches = array(
					'A' => '/[�����]/', 
					'a' => '/[�����]/', 
					'E' => '/[����]/', 
					'e' => '/[����]/', 
					'I' => '/[����]/', 
					'i' => '/[����]/', 
					'O' => '/[�����]/', 
					'o' => '/[�����]/', 
					'U' => '/[����]/', 
					'u' => '/[����]/', 
					'C' => '/[�]/', 
					'c' => '/[�]/', 
					'N' => '/[�]/', 
					'n' => '/[�]/');
	if ($pIsUTF8) {
		$aMatches = array_map('utf8_decode', $aMatches);
	}
	return preg_replace(array_values($aMatches), array_keys($aMatches), (($pIsUTF8) ? utf8_decode($pString) : $pString));
}

/**
 * Calcula o DAC (Digito de Auto-Conferencia) com base no m�dulo 10.
 * Por Mauro Costa Jr.
 *
 * Exemplo de uso: $digito = mod10("123456")
 * A fun��o retorna o DAC (de um d�gito) da sequencia num�rica que foi passada como parametro
 */
function mod10($string) {
	
	# Consiste se a string recebida � valida, caso contr�rio retorna o d�gito zero:
	$string = trim($string);
	if (empty($string) or !is_numeric($string))
		return 0;
	
		# Inicializa variaveis de trabalho
	$posicao1 = strlen($string) - 1; # Obtem a posicao do �ltimo digito da string
	$multi = 2; # Declara o multiplicador com o valor de 2
	$acumula = 0; # Zera a variavel que acumular� a soma dos digitos
	

	# Loop principal de calculo
	while ($posicao1 >= 0) { # Loop para multiplicar cada digito da string por 2 ou 1, da direita pra esquerda
		$resultado = substr($string, $posicao1, 1) * $multi;
		$posicao2 = strlen($resultado) - 1;
		while ($posicao2 >= 0) { # Loop para acumular a soma dos digitos do resultado da multiplica��o
			$acumula = $acumula + substr($resultado, $posicao2, 1);
			$posicao2--;
		}
		;
		if ($multi == 2) # Alterna o multiplicador entre 2 e 1
			$multi = 1;
		else
			$multi = 2;
		$posicao1--; # Controla a posi��o da string a ser processada
	}
	
	# Obtem o resto da divis�o por dez:
	$dac = fmod($acumula, 10);
	
	# Subtrai de 10 o resto obtido:
	$dac = 10 - $dac;
	
	# Se o resultado for dez, retorna zero:
	if ($dac == 10)
		$dac = 0;
	
	return $dac;
}

function WarningPHP5($msg) {
	/**
	 * N�o deve escrever a mensagem de fun��es disponiveis
	 * na pagina inicial pois o menu xul da crash
	 */
	if (in_array(doctype, array('nohtml', 'anexo', 'json', 'xul')))
		return false;
	
	if (!isset($_SESSION['KM_WARNING_PHP5']) || !in_array($msg, $_SESSION['KM_WARNING_PHP5'])) {
		$_SESSION['KM_WARNING_PHP5'][] = $msg;
		if (isset($_SESSION['KM_IDOPERADOR']) && $_SESSION['KM_IDOPERADOR'] == 1) {
			echo $msg . '<br>';
		} else {
			trigger_error($msg);
		}
	}
}

/**
 * Calculo do Modulo 10 para geracao do digito verificador
 * de boletos bancarios conforme documentos obtidos
 * da Febraban - www.febraban.org.br
 *
 * Observa��es:
 * - Script desenvolvido sem nenhum reaproveitamento de c�digo pr� existente.
 * - Assume-se que a verifica��o do formato das vari�veis de entrada � feita previamente.
 *
 * @param integer $num string num�rica para a qual se deseja calcularo digito verificador;
 * @param integer $base valor maximo de multiplicacao [2-$base]
 * @param integer $r quando especificado um devolve somente o resto
 * @return integer Retorna o Digito verificador.
 */
function mod11($num, $base = 9, $r = 0) {
	$soma = 0;
	$fator = 2;
	/* Separacao dos numeros*/
	for ($i = strlen($num); $i > 0; $i--) {
		# pega cada numero isoladamente
		$numeros[$i] = substr($num, $i - 1, 1);
		# Efetua multiplicacao do numero pelo falor
		$parcial[$i] = $numeros[$i] * $fator;
		# Soma dos digitos
		$soma += $parcial[$i];
		if ($fator == $base) {
			# restaura fator de multiplicacao para 2
			$fator = 1;
		}
		$fator++;
	}
	
	if ($r == 0) {
		$soma *= 10;
		$digito = $soma % 11;
		if ($digito == 10) {
			$digito = 0;
		}
		return $digito;
	} else if ($r == 1) {
		$resto = $soma % 11;
		return $resto;
	} else {
		die('erro: file:' . __FILE__ . ' line:' . __LINE__);
	}
}

/**
 * Verifica se a string � uma data no formato ISO8859
 *
 * @param string $sDate
 */
function KM_checkDate($sDate) {
	/*remove os separadores*/
	$sDate = preg_replace('/[^0-9]/', '', $sDate);
	
	/*checa se o tamanho � 8 ( ddmmaaaa )*/
	if (strlen($sDate) != 8) {
		return false;
	}
	
	/*criando as variaveis */
	$bissexto = false;
	$dia = substr($sDate, 0, 2);
	$mes = substr($sDate, 2, 2);
	$ano = substr($sDate, 4);
	
	return checkdate($mes, $dia, $ano);
}

function mascara($mascara, $palavra) {

	$pont_palavra = 0;

	$resultado = "";

	if (strlen(trim($palavra)) > 0)

		for ($i = 0; $i < strlen($mascara); $i++) {

		$mascara_char = substr($mascara, $i, 1);

		if ($mascara_char == '#') {

			$resultado .= substr($palavra, $pont_palavra, 1);

			$pont_palavra++;

		} else {

			$resultado .= $mascara_char;

		}

	}

	return $resultado;

}

/**
 * Redimenciona imagens usando a biblioteca GD
 *
 * Se $w for informado o $h ser� calculado mantendo-se a
 * propor��o da imagem original e vice-versa
 *
 * Ex:
 * <code>
 * if (KM_imgResize('logo_tela.jpg', 'logo_tela_mini.jpg', 100, 0)) {
 * echo 'Imagem redimencionada';
 * }
 * </code>
 *
 * @param string $sOldFile imagem original
 * @param string $sNewFile imagem destino
 * @param integer $w largura da nova imagem
 * @param integer $h altura da nova imagem
 * @param integer $quality qualidade da imagem valores de 1 a 100 {@link imagejpeg()}
 * @param bool $bProporcao manter a propor��o $w x $h da imagem ao aplicar os novos valores
 * @return bool
 */
function KM_imgResize($sOldFile, $sNewFile, $w = null, $h = null, $quality = 75, $bProporcao = true) {
	/**
	 * Consiste a existencia da classe GD
	 */
	if (!function_exists('imagecreatefromjpeg')) {
		$msg = 'A biblioteca GD n�o est� instalada.';
		SYS_enviarLog($msg);
		sk_internalError($msg, __FILE__, __LINE__, __FUNCTION__);
	}
	
	/* Create our image object from the image.*/
	if (!$oldImg = imagecreatefromjpeg($sOldFile))
		return false;
		
	/* Get the image size, used in calculations later.*/
	if (!$oldSize = getimagesize($sOldFile))
		return false;
		
	/*caso n�o seja para calcular a propor��o a imagem pode ficar destorcida*/
	if ($bProporcao) {
		/* Calcula o $w e o $h proporcional � imagem original */
		if ($w)
			$h = ($w * $oldSize[1]) / $oldSize[0];
		else if ($h)
			$w = ($h * $oldSize[0]) / $oldSize[1];
		else
			return false;
	}
	
	/* Cria a nova imagem no tamanho proporcional */
	$newImg = imagecreatetruecolor($w, $h);
	
	/* Copia da imagem antiga para a nova fazendo resize */
	if (!imagecopyresampled($newImg, $oldImg, 0, 0, 0, 0, $w, $h, $oldSize[0], $oldSize[1]))
		return false;
		
	/* Flush da imagem gerada */
	if (!imagejpeg($newImg, $sNewFile, $quality))
		return false;
		
	/* Libera memoria */
	imagedestroy($oldImg);
	imagedestroy($newImg);
	
	return true;
}

/**
 * Retorna o tamanho do arquivo formatado para a leitura humana
 *
 * @param string $sFile arquivo a ser lido
 * @param integer $decimal numero de cadas decimais na resposta
 * @return string
 */
function KM_fileSizeH($sFile, $iDecimal = 0) {
	return KM_sizeH(filesize($sFile), $iDecimal);
}

/**
 * Formata um valor em bytes para leitura humana 
 * 
 * @param $iSize tamanho do arquivo em bytes 
 * @param $iDecimal boolean
 * @return string
 */
function KM_sizeH($iSize, $iDecimal = 0) {
	$s = array('B', 'Kb', 'Mb', 'Gb', 'Tb', 'Pb');
	$e = floor(log($iSize) / log(1024));
	return sprintf("%.{$iDecimal}f " . $s[$e], ($iSize / pow(1024, floor($e))));
}

/**
 * Preenche a string $input com $pad_string ate que chegue ao tamanho de $pad_length
 *
 * @param string $input
 * @param integer $pad_length
 * @param string $pad_string
 * @return string
 */
function str_padLeft($input, $pad_length, $pad_string = '0') {
	if (strlen($input) > $pad_length && KM::getDebug()) {
		trigger_error("O tamanho de \$input ('$input') � maior que \$pad_length($pad_length).");
	}
	return str_pad(substr($input, 0, $pad_length), $pad_length, $pad_string, STR_PAD_LEFT);
}

/**
 * Preenche a string $input com $pad_string ate que chegue ao tamanho de $pad_length, 
 * e trunca a string sem avisar caso ela seja maior
 *
 * @param string $input
 * @param integer $pad_length
 * @param string $pad_string
 * @return string
 */
function str_padRight($input, $pad_length, $pad_string = ' ') {
	if (strlen($input) > $pad_length && KM::getDebug()) {
		trigger_error("O tamanho de \$input ('$input') � maior que \$pad_length($pad_length).");
	}
	return str_pad(substr($input, 0, $pad_length), $pad_length, $pad_string, STR_PAD_RIGHT);
}

/**
 * Descompacta e devolve um array com os arquivos compactados em $sFile,
 * o retorno � identico ao da fun��o {@link scandir}, com a diferen�a que
 * n�o retorna os subdiret�rios, somente o endere�o dos arquivos
 * 
 * Ex:
 * <code>
 * print_r(KM_zipExtract('endereco/arquivo.zip'));
 * //Array
 * //(
 * //    [0] => /tmp/arquivo1.txt
 * //    [1] => /tmp/sub-diretorio/arquivo2.txt
 * //)
 * <code>
 *
 * @param string $sFile endere�o em disco do arquivo Zip
 * @return array
 */
function KM_zipExtract($sFile) {
	/**
	 * Consiste a existencia da classe ZipArchive
	 */
	if (!class_exists('ZipArchive')) {
		$msg = 'A extens�o ZIP n�o est� instalada.';
		if (SYS_idOperador() == 1) {
			$msg .= "\nExecute os comandos abaixo no shell como root\n";
			$msg .= "\n";
			$msg .= "pecl install zip;\n";
			$msg .= "echo extension=zip.so >> /etc/php.ini ;\n";
			$msg .= "apachectl restart ;\n";
		}
		SYS_enviarLog($msg);
		throw new Exception($msg);
	}
	
	/**
	 * define o diretorio para descompactar os arquivos
	 * se o diret�rio definido j� existe, apaga
	 */
	$sDir = '/tmp/' . date('Y-m-d-H-i-s_') . '_' . basename($sFile);
	if (is_dir($sDir)) {
		$msg = "Um diret�rio com o nome '$sDir' j� exite. N�o foi possivel descompactar o arquivo";
		SYS_enviarLog($msg);
		throw new Exception($msg);
	}
	mkdir($sDir);
	$sDir = realpath($sDir);
	
	/**
	 * cria o manipulador de zip,
	 * abre o arquivo
	 * descompacta para o diret�rio definido
	 * fecha o arquivo
	 */
	$zip = new ZipArchive();
	$zip->open($sFile);
	if (!$zip->extractTo($sDir)) {
		return false;
	}
	$zip->close();
	
	/**
	 * L� os arquivos do diret�rio
	 * apaga os diretorios . e ..
	 */
	$aDir = scandir($sDir);
	unset($aDir[0]);
	unset($aDir[1]);
	
	/**
	 * fun��o definida para ler recursivamente o array de resultados
	 * para que sej� devolvido somente o endere�o dos arquivos
	 */
	foreach ($aDir as $key => $conteudo) {
		
		$path = $sDir . '/' . $conteudo;
		if (is_file($conteudo)) {
			/**
			 * se o valor no array j� � o path completo do arquivo, n�o faz nada
			 */
			continue;
		} else if (is_file($path)) {
			/**
			 * define o value do array como o path completo do arquivo
			 */
			$aDir[$key] = $path;
		} else {
			/**
			 * se entrou aqui � por que ir� ler um diret�rio
			 */
			
			/*reseta o ponteiro interno do array, para que leia todas as posi��es do array novamente*/
			reset($aDir);
			
			/*se $conteudo for o path j� � um nivel superior ao segundo*/
			if (is_dir($conteudo)) {
				$path = $conteudo;
			}
			
			/*apaga o diret�rio atual do array de resultados*/
			unset($aDir[$key]);
			
			/*l� o conteudo do diret�rio*/
			$aux = scandir($path);
			
			/*adiciona todo o conteudo do diret�rio ao resultado(se for diret�rio ser� lido na proxima vez)*/
			foreach ($aux as $subConteudo) {
				/*ignora os diret�rios . e ..*/
				if ($subConteudo != '.' && $subConteudo != '..')
					$aDir[] = $path . '/' . $subConteudo;
			}
		}
	}
	sort($aDir);
	return $aDir;
}

/**
 * Compacta os arquivos indicados em $aFiles, criando o novo arquivo
 * no local indicado em $sFile
 *
 * @param string $sFile endere�o em disco do arquivo Zip a ser criado
 * @param array $aFiles array com os endere�os em disco dos arquivos a serem adicionados ao zip
 * @return bool
 */
function KM_zipCreate($sFile, $aFiles) {
	/**
	 * Consiste a existencia da classe ZipArchive
	 */
	if (!class_exists('ZipArchive')) {
		$msg = 'A extens�o ZIP n�o est� instalada.';
		if (SYS_idOperador() == 1) {
			$msg .= "\nExecute os comandos abaixo no shell como root\n";
			$msg .= "\n";
			$msg .= "pecl install zip;\n";
			$msg .= "echo extension=zip.so >> /etc/php.ini ;\n";
			$msg .= "apachectl restart ;\n";
		}
		SYS_enviarLog($msg);
		throw new Exception($msg);
	}
	
	/**
	 * Compactando os arquivos
	 */
	$zip = new ZipArchive();
	
	if ($zip->open($sFile, ZIPARCHIVE::OVERWRITE) !== TRUE) {
		throw new Exception('N�o foi possivel abrir: ' . $sFile);
	}
	
	/*adicionando os arquivos do array*/
	foreach ($aFiles as $val) {
		$zip->addFile($val, basename($val)) or die("N�o foi possivel adicionar o arquivo: '$val'");
	}
	
	return $zip->close();
}

/**
 * Verifica se a string � um numero formatado
 *
 * @param string $sValor
 * @param bool $bIgnorarHtml
 */
function is_numeric_str($sValor) {
	return $sValor && !preg_match('/[^0-9,-. %R$]/', $sValor);
}

/**
 * Devolve uma explica��o das mensagens de erro
 *
 * @param integer $error_code
 * @return string
 */
function UPLOAD_ERR_getMsg($error_code) {
	switch ($error_code) {
		case UPLOAD_ERR_OK:
			return 'There is no error, the file uploaded with success';
		case UPLOAD_ERR_INI_SIZE:
			return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
		case UPLOAD_ERR_FORM_SIZE:
			return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
		case UPLOAD_ERR_PARTIAL:
			return 'The uploaded file was only partially uploaded';
		case UPLOAD_ERR_NO_FILE:
			return 'No file was uploaded';
		case UPLOAD_ERR_NO_TMP_DIR:
			return 'Missing a temporary folder';
		case UPLOAD_ERR_CANT_WRITE:
			return 'Failed to write file to disk';
		case UPLOAD_ERR_EXTENSION:
			return 'File upload stopped by extension';
		default:
			return 'Unknown upload error';
	}
}

/**
 * Fun��o que normaliza um array de muitos niveis, deixando-o com apenas um nivel,
 * util quando se vai devolver o resultado para o relat�rio
 *
 * <code>
 * //Array de entrada
 * $aDados = array(
 * 'NUMERO_CONTRATO' => 1, 
 * 'LOCADOR' => array('NOME' => 'Marcelo de Jesus', 'RG' => '123', 'CPF_CNPJ' => '456'));
 *
 * //Executando a normaliza��o
 * $aDadosNormalizado = SYS_Rpt_Relatorio_Config::normalizarArray($aDados);
 *
 * //Resultado
 * $aDadosNormalizado = array(
 * 'NUMERO_CONTRATO' => 1,
 * 'LOCADOR[NOME]' => 'Marcelo de Jesus',
 * 'LOCADOR[RG]' => 123,
 * 'LOCADOR[CPF_CNPJ]' => 456
 * );
 * </code>
 */
function KM_normalizarArray($aDados) {
	/*$f = function ($val, $key, &$userData = null) {
		if (is_array($val)) {
			$oldPrefixo = $userData['prefixo'];
			$userData['prefixo'] .= $key;
			foreach ($val as $key1 => $val1) {
				$userData['callback']($val1, '[' . $key1 . ']', $userData);
			}
			$userData['prefixo'] = $oldPrefixo;
		} else {
			$key = $userData['prefixo'] . $key;
			$userData['aNormalizado'][$key] = $val;
		}
	};*/
	
	/*Array contendo a data da normaliza��o*/
	$aNormalizado = array();
	
	/*Executa a normaliza��o*/
	array_walk($aDados, $f, array('aNormalizado' => &$aNormalizado, 'callback' => $f, 'prefixo' => null));
	return $aNormalizado;
}

/**
 * Encodifica todas as entradas de um array, inclusive as chaves para UTF8
 * @param array $aValores
 * @return array
 */
function KM_arrayToUTF8($aValores) {
	$aResult = array();
	foreach ($aValores as $key => $val) {
		if (is_string($key))
			$key = utf8_encode($key);
		if (is_string($val))
			$val = utf8_encode($val);
		else if (is_array($val))
			$val = KM_arrayToUtf8($val);
		else if (is_object($val))
			throw new Exception('Falha em KM_arrayToUtf8: N�o foi possivel codificar um objeto');
		$aResult[$key] = $val;
	}
	return $aResult;
}

/**
 * Encodifica todas as entradas de um array, inclusive as chaves para ANSI
 * @param array $aValores
 * @return array
 */
function KM_arrayToAnsi($aValores) {
	$aResult = array();
	foreach ($aValores as $key => $val) {
		if (is_string($key))
			$key = utf8_decode($key);
		if (is_string($val))
			$val = utf8_decode($val);
		else if (is_array($val))
			$val = KM_arrayToAnsi($val);
		else if (is_object($val))
			throw new Exception('Falha em KM_arrayToAnsi: N�o foi possivel codificar um objeto');
		$aResult[$key] = $val;
	}
	return $aResult;
}

/**
 * Retorna a extens�o de um arquivo
 * @param array $filename
 * @return string $exts
 */
function _findexts($filename) {
		$filename = strtolower($filename);
		$exts = split('[/\\.]', $filename);
		$n = count($exts) - 1;
		$exts = $exts[$n];
		return $exts;
	}

/**
 * Transforma valor monet�rio em reais para valor tipo float para ser inserido no banco de dados
 * Ex.: R$ 12.000,00
 * @param string $val
 * @return int $val  
 */
function formatMoneyToDb($val){
	$val = str_replace('R$', '', $val);
	$val = str_replace('.', '', $val);
	$val = str_replace(',', '.', $val);
		
	return $val;	
}

/**
 * Limita caracteres de um texto sem cortar palavras ao meio
 * @param string $text Texto a ser limitado
 * @param int $qtd Quantidade de caracteres
 */
function substrText($text, $qtd) {
		
	$aSub1 = substr($text, 0, $qtd);
	$aSub2 = substr($text, 0, strripos($aSub1, ' '));
	
	return $aSub2;
}

function urlName($str) {



	$str = strtolower(utf8_decode($str)); $i=1;

	$str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûýýÿ'), 'aaaaaaaceeeeiiiinoooooouuuyyy');

	$str = preg_replace("/([^a-z0-9])/",'-',utf8_encode($str));

	while($i>0) $str = str_replace('--','-',$str,$i);

	if (substr($str, -1) == '-') $str = substr($str, 0, -1);

	return $str;

}
?>