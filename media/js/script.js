$(document).ready(function() {		
	
	/* Scrool to top */
	$("#topButton").click(function(){
		$('html,body').animate({
			scrollTop: $('#topo').offset().top
		}, 2000);
	});

    
    
    if($('#iview').length != 0){
    	yepnope([{
		  load: [ pathSite+"media/js/slider/js/raphael-min.js", pathSite+"media/js/slider/js/jquery.easing.js", pathSite+"media/js/slider/js/iview.js", pathSite+"media/js/slider/css/iview.css" ],
		  complete: function () {
		    $('#iview').iView({
		            pauseTime: 7000,
		            directionNav: true,
		            controlNav: false,
		            tooltipY: -15,
		            width:990,
		            height:270,
		            timerBg:"#961720",
		            timerColor:"#000000",
		            timerOpacity:0.8
		    });
		  }
		}]);
    }

			  
	if($("a[rel=youtube_galeria]").length != 0){  
	    $("a[rel=youtube_galeria]").click(function() {
		        $.fancybox({
		                'padding'		: 0,
		                'autoScale'		: false,
		                'transitionIn'	: 'none',
		                'transitionOut'	: 'none',
		                'title'			: this.title,
		                'width'			: 680,
		                'height'		: 495,
		                'href'			: this.href.replace(new RegExp("watch\\?v=", "i"), 'v/'),
		                'type'			: 'swf',
		                'swf'			: {
		                    'wmode'				: 'transparent',
		                        'allowfullscreen'	: 'true'
		                }
		        });
		
		        return false;
		});
	}
    
    
	if($("a[rel=imagem_grupo]").length != 0){
	    $("a[rel=imagem_grupo]").fancybox({
		    helpers:  {
		        thumbs : {
		            width: 50,
		            height: 50
		        }
		    },
		    beforeClose : function() {
		        $(".formError").remove();
		    }
		});
	}
	
	
	  if($('.carousel').length != 0){
	        yepnope([{
	          load: [ pathSite+"media/js/carousel/carousel.js" ],
	          complete: function () {
	            $('.carousel').carouFredSel({
	                    auto: true,
	                    pagination: "#pager2",
	                    mousewheel: true,
	                    prev: '#prev2Homer',
	                    next: '#next2Homer',
	                    swipe: {
	                            onMouse: true,
	                            onTouch: true
	                    },
	                    width: 940,
	                    height: 120,
	                    scroll : {
	                            items           : 6,
	                            easing          : "quadratic",
	                            duration        : 1000,                         
	                            pauseOnHover    : true
	                    },
	                    items               : 6,
	                    pagination: ".dev7-caroufredsel-pag",
	                    align:'left'
	             
	            });
	          }
	        }]);
	    }
	  
  	/*
		 * FUNÇÃO PARA CRIAR FORMULARIO DE ENVIO DE CONTATO AJAX
		 */ 	
	    if($('.mostraMapa').length != 0 || $('#mapaImovel').length != 0){
	    	/* MAPA DE CONTATO */
	    	var latitude = $("#latitudeEmpresa").val();
	    	var longitude = $("#longitudeEmpresa").val();
	    	var enderecoCompleto = $("#enderecoCompletoEmpresa").val();
	    	
	    	/* MAPA DE DESTAQUE */
	    	var latitudeDestaque = $("#latitudeDestImovel").val();
	    	var longitudeDestaque = $("#longitudeDestImovel").val();
			yepnope([{load:'http://www.google.com/jsapi', callback: function() {
			    google.load("maps", "3",
			                {
			                    callback: function () {
			                        yepnope([{
									  load: [ pathSite+"media/js/gmap3/gmap3.js" ],
									  complete: function () {
											
											
										 if($('.mostraMapa').length != 0){	
											$(".mostraMapa").gmap3({ 
	                                            marker: { 
	                                                values:[
												      {latLng:[latitude, longitude], data:"<div align='center'>"+enderecoCompleto+"</div>"}
												    ],
	                                                options: { 
	                                                    icon: pathSite + "media/imagens/mapa.png", 
	                                                    draggable: false
	                                                }, 
	                                                events:{
												      click: function(marker, event, context){
												        var map = $(this).gmap3("get"),
												          infowindow = $(this).gmap3({get:{name:"infowindow"}});
												        if (infowindow){
												          infowindow.open(map, marker);
												          infowindow.setContent(context.data);
												        } else {
												          $(this).gmap3({
												            infowindow:{
												              anchor:marker, 
												              options:{content: context.data}
												            }
												          });
												        }
												      }
												    }
	                                            }, 
	                                            map: { 
	                                                options: { 
	                                                    zoom: 18 
	  
	                                                } 
	                                            } 
	                                        });
	                                        
										 }
										 
										 
										if(latitudeDestaque && longitudeDestaque){	
										 if($('#mapaImovel').length != 0){	
											$("#mapaImovel").gmap3({ 
	                                            marker: { 
	                                                values:[
												      {latLng:[latitudeDestaque, longitudeDestaque], data:"<div align='center'>Localização</div>"}
												    ],
	                                                options: { 
	                                                    icon: pathSite + "media/imagens/mapa.png", 
	                                                    draggable: false
	                                                }, 
	                                                events:{
												      click: function(marker, event, context){
												        var map = $(this).gmap3("get"),
												          infowindow = $(this).gmap3({get:{name:"infowindow"}});
												        if (infowindow){
												          infowindow.open(map, marker);
												          infowindow.setContent(context.data);
												        } else {
												          $(this).gmap3({
												            infowindow:{
												              anchor:marker, 
												              options:{content: context.data}
												            }
												          });
												        }
												      }
												    }
	                                            }, 
	                                            map: { 
	                                                options: { 
	                                                    zoom: 18 
	  
	                                                } 
	                                            } 
	                                        });
	                                        
										 }
									  }
											
									    
									  }
									}]);
			                    },
			                    other_params: "sensor=false"
			                });
				}}]);
		    }
	  
	  
	  /*
	     * FUNÇAO PARA CRIAR RADIO E CHECKBOX PERSONALIZADOS
	     */
	     if($('.multselectTipo').length != 0 || $('.multselectCategoria').length != 0 || $('.multselectPreco').length != 0){
	        yepnope([{
	          load: [ pathSite+"media/js/multiselect/jquery.multiselect.min.js", pathSite+"media/js/multiselect/jquery.multiselect.filter.min.js", pathSite+"media/js/multiselect/css/jquery.multiselect.css", pathSite+"media/js/multiselect/css/jquery.multiselect.filter.css" ],
	          complete: function () {
	        	 if($('.multselectTipo').length != 0){  
		            $(".multselectTipo").multiselect({
		                noneSelectedText: "Tipo",
		                header: true,
		                show: ["fade", 200],
		                hide: ["fade", 200],
		                height: 175,
		                minWidth: 20,
		                classes: "maiormultiselect",
		                position: {
		                	my: 'left bottom',
		                    at: 'left top'
	                  }
		            });
		          }
	        	  if($('.multselectCategoria').length != 0){  
	        		  $(".multselectCategoria").multiselect({
	        			  noneSelectedText: "Categoria",
	        			  header: true,
	        			  show: ["fade", 200],
	        			  hide: ["fade", 200],
	        			  height: 175,
	        			  minWidth: 20,
	        			  classes: "maiormultiselect",
	        			  position: {
	        				  my: 'left bottom',
	        			      at: 'left top'
		                  }
	        		  });
	        	  }
	        	  if($('.multselectPreco').length != 0){  
	        		  $(".multselectPreco").multiselect({
	        			  noneSelectedText: "Preço",
	        			  header: true,
	        			  show: ["fade", 200],
	        			  hide: ["fade", 200],
	        			  height: 175,
	        			  minWidth: 20,
	        			  classes: "maiormultiselect",
	        			  multiple:false,
	        			  selectedList: 1,
	        			  position: {
	        				  my: 'left bottom',
	        			      at: 'left top'
		                  }
	        		  });
	        	  }
	        	  if($('.multselectBairro').length != 0){  
		            $(".multselectBairro").multiselect({
		                noneSelectedText: "Bairro",
		                header: true,
		                show: ["fade", 200],
		                hide: ["fade", 200],
		                height: 175,
		                minWidth: 20,
		                classes: "maiormultiselect",
		                position: {
		                	my: 'left bottom',
		                    at: 'left top'
		                }
		            });
		          }
	        	  
	        	  if($('.multselectValores').length != 0){  
		            $(".multselectValores").multiselect({
		                header: true,
		                show: ["fade", 200],
		                hide: ["fade", 200],
		                height: 175,
		                minWidth: 20,
		                multiple:false,
		                classes: "maiormultiselect",
		                selectedList: 1,
		                position: {
		                	my: 'left bottom',
		                    at: 'left top'
		                }
		            });
		          }
	        	  
	        	  if($('.multselectCidade').length != 0){  
	        		  $(".multselectCidade").multiselect({
	        			  noneSelectedText: "Cidade",
	        			  header: true,
	        			  show: ["fade", 200],
	        			  hide: ["fade", 200],
	        			  height: 175,
	        			  minWidth: 20,
	        			  classes: "maiormultiselect",
	        			  multiple:true,
	        			  close: function(){
	        				  var aValor = [];
	        				  $(this).multiselect("widget").find("input:checked").each(function(index, value){
	        					  aValor[index] = ( value ).value;
	        					  
	        				  });
	        				  
	        				  $.ajax({
        		                url: $('#acaoCidade').val()+(aValor),
        		                dataType: 'json',
        		                type: 'POST',
        		                data: {
        		                	
        		                },
        		                success: function(obj){
        		                    if(obj.situacao=="sucess"){
        		                       var i = 0;
        		                       var option = "";
        		                       for(i=0;i<obj.num;i++){
        		                    	   option += "<option value='"+obj.bairros[i].idSetor+"'>"+obj.bairros[i].nmSetor+"</option>"; 
        		                       }
        		                       $(".multselectBairro").html('');
        		                       $(".multselectBairro").append(option);
        		                       $(".multselectBairro").multiselect("enable");
        		                       $(".multselectBairro").multiselect('refresh');
        		                    } else if(obj.situacao=="error"){
        		                       $(".multselectBairro").html('');
            		                   $(".multselectBairro").multiselect('refresh');
        		                    }
        		                },
        		                error : function (XMLHttpRequest, textStatus, errorThrown) {
        		                	$(".multselectBairro").html('');
        		                	$(".multselectBairro").multiselect('refresh');
        		                	mostraMensagem('Selecione uma cidade',3,'info');
        		                },

        		                beforeSend : function(requisicao){
        		                }
        		            });
	        			  },
	        			  position: {
	        				  my: 'left bottom',
	        			      at: 'left top'
		                  }
	        		  });
	        	  }
	           }  
	        }]);
	    }
	     
	     
	     /* botoes de financiamento bancario */
	     $(".financiamento-button-caixa").live('click', function(e) { 
	     	window.open('http://www8.caixa.gov.br/siopiinternet/simulaOperacaoInternet.do?method=inicializarCasoUso', 'caixa', 'status=1, resizable=1, scrollbars=1, width=480, height=670');
	     	e.preventDefault(); return false;
	     });

	     $(".financiamento-button-bancodobrasil").live('click', function(e) { 
	     	window.open('https://www42.bancodobrasil.com.br/portalbb/creditoImobiliario/Proposta,2,2250,2250.bbx', 'bancodobrasil', 'status=1, resizable=1, scrollbars=1, width=600');
	     	e.preventDefault(); return false;
	     });	

	     $(".financiamento-button-santander").live('click', function(e) { 
	     	window.open('http://www.santander.com.br/portal/wps/script/templates/GCMRequest.do?page=5516', 'santander', 'status=1, resizable=1, scrollbars=1, width=650, height=600');
	     	e.preventDefault(); return false;
	     });

	     $(".financiamento-button-itau").live('click', function(e) { 
	     	window.open('https://ww3.itau.com.br/imobline/pre/simuladores_new/fichaProposta/index.aspx?IMOB_TipoBKL=&ident_bkl=pre', 'itau', 'status=1, resizable=1, scrollbars=1, width=800');
	     	e.preventDefault(); return false;
	     });

	     $(".financiamento-button-hsbc").live('click', function(e) { 
	     	window.open('https://wwws3.hsbc.com.br/HPB-CHM-SIMULADOR/servlets/HPBCreditoImobiliarioServlet', 'hsbc', 'status=1, resizable=1, scrollbars=1, width=800, height=600');
	     	e.preventDefault(); return false;
	     });		

	     $(".financiamento-button-bradesco").live('click', function(e) { 
	     	window.open('http://www.shopcredit.com.br/shopcredit/br/stsm/stsmcredimobsimulador0.asp?layout=F&retorno=simulado', 'bradesco', 'status=1, resizable=1, scrollbars=1, width=800');
	     	e.preventDefault(); return false;
	     });

   
    
    
});


var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};

function mostraMensagem(msg,tempo,type) {
   
	    var timere = null;
	    if(tempo == ""){
	        tempo = 10;
	        
	    }else{
	        tempo = tempo;
	    }
	    
	    var opts = {
	    };
	    switch (type) {
	    case 'error':
	        opts.title = "Erro";
	        opts.text = msg;
	        opts.type = "error";
	        break;
	    case 'info':
	        opts.title = "Informação";
	        opts.text = msg;
	        opts.type = "information";
	        break;
	    case 'success':
	        opts.title = "Sucesso";
	        opts.text = msg;
	        opts.type = "success";
	        break;
	    }
	    //$.pnotify(opts);
	    
	    noty({
	    	text: opts.title+" - "+opts.text,
	    	maxVisible: 1,
	    	layout: 'bottom',
	    	killer: true,
	    	timeout: (tempo * 1000),
	    	force:true,
	    	animation: {
		        open: {height: 'toggle'},
		        close: {height: 'toggle'},
		        easing: 'swing',
		        speed: 200 // opening & closing animation speed
		    },
		    type: opts.type
	    	});
    
    
}





$(function(){
	
	$("#form_visita").validationEngine({
        onValidationComplete: function(form, status){
         if (status == true) {
                mostraMensagem("Aguarde...","",'info');
                $.ajax({
                url: $('#acaoAgende').val(),
                dataType: 'json',
                type: 'POST',
                data: $('#form_visita').serialize(),
                success: function(obj){
                    if(obj.situacao=="sucess"){
                    	$.fancybox.close();
                        mostraMensagem(obj.msg,4,'success');
                        $("#form_visita").each(function(){
                           this.reset(); //Cada volta no la�o o form atual ser� resetado
                        });
                    } else if(obj.situacao=="error"){
                        mostraMensagem(obj.msg,4,'error');
                    }
                },
                error : function (XMLHttpRequest, textStatus, errorThrown) {

                },

                beforeSend : function(requisicao){
                }
            });
         }
        }

   });
	
	$("#form_signup2").validationEngine({
		onValidationComplete: function(form, status){
			if (status == true) {
				mostraMensagem("Aguarde...","",'info');
				$.ajax({
					url: $('#acaoContato').val(),
					dataType: 'json',
					type: 'POST',
					data: $('#form_signup2').serialize(),
					success: function(obj){
						if(obj.situacao=="sucess"){
							$.fancybox.close();
							mostraMensagem(obj.msg,4,'success');
							$("#form_signup2").each(function(){
								this.reset(); //Cada volta no la�o o form atual ser� resetado
							});
						} else if(obj.situacao=="error"){
							mostraMensagem(obj.msg,4,'error');
						}
					},
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						
					},
					
					beforeSend : function(requisicao){
					}
				});
			}
		}
	
	});
	
	$("#form_ligar").validationEngine({
		onValidationComplete: function(form, status){
			if (status == true) {
				mostraMensagem("Aguarde...","",'info');
				$.ajax({
					url: $('#acaoLigar').val(),
					dataType: 'json',
					type: 'POST',
					data: $('#form_ligar').serialize(),
					success: function(obj){
						if(obj.situacao=="sucess"){
							$.fancybox.close();
							mostraMensagem(obj.msg,4,'success');
							$("#form_ligar").each(function(){
								this.reset(); //Cada volta no la�o o form atual ser� resetado
							});
						} else if(obj.situacao=="error"){
							mostraMensagem(obj.msg,4,'error');
						}
					},
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						
					},
					
					beforeSend : function(requisicao){
					}
				});
			}
		}
	
	});
	
	$("#form_amigo").validationEngine({
		onValidationComplete: function(form, status){
			if (status == true) {
				mostraMensagem("Aguarde...","",'info');
				$.ajax({
					url: $('#acaoIndique').val(),
					dataType: 'json',
					type: 'POST',
					data: $('#form_amigo').serialize(),
					success: function(obj){
						if(obj.situacao=="sucess"){
							$.fancybox.close();
							mostraMensagem(obj.msg,4,'success');
							$("#form_amigo").each(function(){
								this.reset(); //Cada volta no la�o o form atual ser� resetado
							});
						} else if(obj.situacao=="error"){
							mostraMensagem(obj.msg,4,'error');
						}
					},
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						
					},
					
					beforeSend : function(requisicao){
					}
				});
			}
		}
	
	});
	
	$("#form_signup").validationEngine({
		onValidationComplete: function(form, status){
			if (status == true) {
				mostraMensagem("Aguarde...","",'info');
				$.ajax({
					url: $('#acaoContatoFull').val(),
					dataType: 'json',
					type: 'POST',
					data: $('#form_signup').serialize(),
					success: function(obj){
						if(obj.situacao=="sucess"){
							$.fancybox.close();
							mostraMensagem(obj.msg,4,'success');
							$("#form_signup").each(function(){
								this.reset(); //Cada volta no la�o o form atual ser� resetado
							});
						} else if(obj.situacao=="error"){
							mostraMensagem(obj.msg,4,'error');
						}
					},
					error : function (XMLHttpRequest, textStatus, errorThrown) {
						
					},
					
					beforeSend : function(requisicao){
					}
				});
			}
		}
	
	});
	
	
	
	 /* RETORNA OS VALORES PARA O CAMPO TIPO DA SOLICITAÇÃO DE IMÓVEIS */
    $("#submit_localizartipo").click(function() {

        //Guarda em um array o valor dos campos selecionados.			
        var aCampo_tipo = new Array();
        $("input[name='name_localizartipo']:checked").each(function() {

            aCampo_tipo.push($(this).val());
        });

        if (aCampo_tipo != "") {

            //Coloca a quantidade de itens selecionados no campo de pesquisa.				
            //$("#campo_localizartipo").val(aCampo_tipo.length+' seleconado(s)');
            //Coloca o valor em um campo hidden para fazer submit.				
            $("#campo_localizartipo").val(aCampo_tipo.toString());
        }
        //fecha pop-up			
        $.fancybox.close();
    });
    
    
    //Valores para o campo tipo
    $("#submit_tipo").click(function() {
        //Guarda em um array o valor dos campos selecionados.			
        var aCampo_tipo = new Array();
        $("input[name='name_tipo']:checked").each(function() {
            aCampo_tipo.push($(this).val());
        });

        if (aCampo_tipo != "") {
            //Coloca a quantidade de itens selecionados no campo de pesquisa.				
            $("#campo_tipo").val(aCampo_tipo.length + ' selecionado(s)');
            //Coloca o valor em um campo hidden para fazer submit.				
            $("#hidden_tipo").val(aCampo_tipo.toString());
        }
        //fecha pop-up			
        $.fancybox.close();
    });
    
    
    $("#bairro-ct").css('display', 'none');

    //Valores para o campo finalidade
    $("#form_cidade #submit_cidade").click(function() {

        var aCampo_cidade = new Array();
        $("input[name='name_cidade']:checked").each(function() {
            aCampo_cidade.push($(this).val());
        });
        $("#hidden_cidade").val(aCampo_cidade.toString());

        $.get(this.href + '/id/' + aCampo_cidade.toString(), function(data) {
            $("#bairro-ct").css('display', 'block');
            $("#bairro-ct").empty().html(data);
            $("#localidade-ct").css('display', 'none');

            $("#submit_setor").click(function() {
                var aCampo_setor = new Array();
                $("input[name='name_setor']:checked").each(function() {
                    aCampo_setor.push($(this).val());
                });

                $("#hidden_bairro").val(aCampo_setor.toString());
                $("#campo_cidade").val(aCampo_setor.length + " selecionado(s)");
                $.fancybox.close();
            });
        });
        return false;
    });
	
});