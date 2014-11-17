var urlIcoGeral = 'http://labs.google.com/ridefinder/images/mm_20_gray.png';
var urlIcoSelec = 'http://labs.google.com/ridefinder/images/mm_20_yellow.png';
var urlIcoSombra = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
var latitude = -16.6808;//-16.680842;
var longitude = -49.2566;//-49.256687;
var map = null;//objeto mapa
var markers = null;//objeto para apontar
var pontos = null;//guarda todos os pontos
var pontosSel = null;//guarda os pontos selecionados
var centro = new google.maps.LatLng(latitude, longitude);//centro do mapa
var zoom = 7;//zoon do mapa
var urlPesquisa = 'http://'+document.location.hostname + '/imovel/pesquisa';//Endereco de pesquisa dos imoveis
var urlDetalhamento = 'http://'+document.location.hostname + '/imovel/destaque/id/[IDEMPREENDIMENTO]';//Endereco para abrir o detalhamento do imovel
var aImovelTudo = null;
var icone = null;// marcador p/ imoveis em geral
var icoSemel = null;// marcador p/ imoveis semelhantes a procura
var icoSelec = null;// marcador p/ imoveis selecionados na procura
var infowindow = [];


var image = new google.maps.MarkerImage(urlIcoGeral,
        new google.maps.Size(20, 32),
        new google.maps.Point(0,0),
        new google.maps.Point(0, 32));
var shadow = new google.maps.MarkerImage(urlIcoSombra,
	    new google.maps.Size(37, 32),
	    new google.maps.Point(0,0),
	    new google.maps.Point(0, 32));
var shape = {
        coord: [1, 1, 1, 20, 18, 20, 18 , 1],
        type: 'poly'
    };
    
/**
 * função de inicialização
 */
function initialize(){
		var myOptions = {
			zoom : zoom,
			center : centro,
			mapTypeId : google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
		map.enableKeyDragZoom();
		$.ajax({
		  url: TratarUrl(true),
		  cache: false,
		  success: function(html) {
			  parseText(html);
		  }
		});
}

/**
 * Faz uma requisição ao servidor para pesquisar
 * imoveis pelas opções selecionadas
 *
 * @param {Object} pesqTudo
 */
function TratarUrl(pesqTudo){
	var url = urlPesquisa;
	var finalidade = '';
	var cidade_setor = '';
	var tipo = '';
	var quartos = '';
	var suites = '';
	var valor_inicial = '';
	var valor_final = '';
	if (!pesqTudo) {
		finalidade = $('#FINALIDADE').val();
		cidade_setor = $('#NMCIDADE_NMBAIRRO').val();
		tipo = $('#TIPO').val();
		quartos = $('#QUARTOS').val();
		suites = $('#SUITES').val();
		valor_inicial = $('#VALOR_INICIAL').val();
		valor_final = $('#VALOR_FINAL').val();
	}
	url += '/pesquisar_tudo/'+ ((pesqTudo) ? '1' : '0');
	if(finalidade)
		url += '/finalidade/'+finalidade;
	if(cidade_setor)
		url += '/nmcidade_nmbairro/'+cidade_setor;
	if(tipo)
		url += '/tipo/'+tipo;
	if(quartos)
		url += '/quartos/'+quartos;
	if(suites)
		url += '/suites/'+suites;
	if(valor_inicial)
		url += '/valor_inicial/'+valor_inicial;
	if(valor_final)
		url += '/valor_final/'+valor_final;
	return url;
}

function clearOverlays() {
  if (markers) {
    for (var i = 0; i < markers.length; i++ ) {
    	if(markers[i] != null)
    		markers[i].setMap(null);
    }
  }
}

/**
 * Processa o texto devolvido pelo servidor contendo os imoveis
 *
 * @param {Object} texto
 */
function parseText(texto){
	var linha = null;
	var linhas = texto.split("\n");
	var pesqTudo = false;
	
	/*checando o resultado da requisição*/
	linha = linhas[0].split("\t");
	switch (linha[1]) {
		case '1':
			/*requisição OK*/
			pesqTudo = (linha[2] == '1');
			break;
		case '0':
			/*falha na requisição*/
			alert('Erro ao carregar imóveis.\n\n' + linha[2]);
			return false;
			break;
		default:
			alert('Erro: codigo de retorno indefinido');
			return false;
	}
	
	if (pesqTudo) {
		/*se atualizar - remove todos os marcadores do mapa*/
		clearOverlays();
		markers = [];
		pontos = new google.maps.LatLngBounds();
	} else {
		/* se pesquisar - coloca todos os outros selecionados com a 
		 * cor default para mudar a cor dos selecionados
		 */
		for (i in markers) {
			if(i>=0)
				markers[i].setIcon(urlIcoGeral);
		}
	}
	pontosSel = new google.maps.LatLngBounds();
	
	if (!pesqTudo && linhas.length == 1) {
		pontosSel = pontos;
		alert('Sem resultado para a pesquisa');
	}
	
	/*le os dados devolvidos*/
	for (var i = 1; i < linhas.length; i++) {
		linha = linhas[i].split("\t");
		var id = linha[0];
		
		if (pesqTudo) {
			var lat = linha[1] * 1;
			var lng = linha[2] * 1;
			var ponto = new google.maps.LatLng(lat, lng);
			
			pontos.extend(ponto);
			hint = 'Cód.:' + id;
			html = '<table width="400" border="0" cellspacing="0" cellpadding="0"  style="color: #000;">';
			html += '<tr><td width="10%" height="30" align="right" valign="top" class="tituloImovel">Cód.:</td>';
			html += '<td width="90%" height="30" align="left" valign="top">&nbsp;&nbsp;'+id+'</td>';
			html += '</tr><tr><td height="30" align="right" valign="top" class="tituloImovel">Finalidade:</td>';
			html += '<td height="30" align="left" valign="top">&nbsp;&nbsp;'+linha[3]+'</td>';
			html += '</tr><tr><td height="20" align="left" valign="top" colspan=\"2\" class="tituloImovel">Descrição:</td></tr><tr>';
			html += '<td height="30" align="left" valign="top" colspan=\"2\" style="padding-left: 10px;">&nbsp;&nbsp;'+linha[9]+'</td>';
			html += '</tr></table><br/>';
			html += '<a href="javascript:verImovel(' + id + ');" class="linkCinza14">Zoom no imóvel</a>';
			html += ' | ';
			html += '<a href="javascript:verTodos(pontos);" class="linkCinza14">Mostrar todos</a>';
			html += ' | ';
			url = urlDetalhamento.replace('[IDEMPREENDIMENTO]', id);
			html += '<a target="_blank" href="' + url + '" class="linkCinza14">Abrir ficha do imóvel</a>';

			markers[id] = new google.maps.Marker({
	            position: ponto,
	            map: map,
	            shadow: shadow,
	            icon: image,
	            shape: shape,
	            title: hint
	        });
			
			adicionarJanela(markers[id], html, id);
		} else {
			markers[id].setIcon(urlIcoSelec);
			var ponto = markers[id].getPosition();
		}
		pontosSel.extend(ponto);
	}
	verTodos(pontosSel);
}

/**
 * Adiciona janela de informação
 *
 * @param {Object} pin
 * @param {Object} html
 */
function adicionarJanela(pin, html, id){
	infowindow[id] = new google.maps.InfoWindow({
		content: html
	});
	google.maps.event.addListener(pin, 'click', function(){
		fecharWindows();
		infowindow[id].open(map,pin);
	})
}

function fecharWindows(){
	if(infowindow.length > 0){
		for (var i = 0; i < infowindow.length; i++) {
			if(infowindow[i] != null)
				infowindow[i].close();
		}
	}
}

/**
 * Da zoom e centraliza o mapa para mostrar
 * todos os pontos definidos em pontos
 *
 * @param {Object} pontos
 */
function verTodos(pontos){
	fecharWindows();
	if(map != null){
		map.fitBounds(pontos);
		map.setCenter(pontos.getCenter());
	}
}

/**
 * Da zoom no mapa para mostrar o imovel definido em id
 *
 * @param {Object} id
 */
function verImovel(id){ 
     map.setCenter(markers[id].getPosition());
     map.setZoom(20);
}

$(document).ready(function(){
	
	$("#pesquisar").click(function() {
		$.ajax({
		  url: TratarUrl(false),
		  cache: false,
		  success: function(html) {
			  parseText(html);
		  }
		});
	});
	
	
});