$(function() {
    $('a[rel*=leanModal]').leanModal({top: 50});

    $(".obrigatorio").blur(function() {
        if ($(this).attr("value") != '') {
            $('.janela .error').css("visibility", "hidden");
            $(this).removeClass("error_input");
            $(this).addClass('good_input');
        } else {
            $('.janela .error').css("visibility", "visible");
            $(this).removeClass("good_input");
            $(this).addClass('error_input');
        }
    });

    /* FECHA O POPUP */
    function fechar(campo) {
        $("#" + campo).fadeOut();
        $("#lean_overlay").fadeOut(200);
        $("#loading").fadeOut(200);
    }

    /* FUNÇÕES PARA POPULAR O FORMULÁRIO DE BUSCA */
    /* RETORNA OS VALORES PARA O CAMPO FINALIDADE */
    $("#submit_finalidade").click(function() {
        var aCampo_finalidade = new Array();

        /* Guarda em um array o valor dos campos selecionados. */
        $("input[name='name_finalidade_venda']:checked").each(function() {
            aCampo_finalidade.push($(this).val());
        });

        if (aCampo_finalidade.length > 0) {
            var aVenda_finalidade = new Array();

            /* Coloca a quantidade de itens selecionados no campo de pesquisa. */
            $("#finalidade_venda").attr("checked", true);
            /* Coloca o valor em um campo hidden para fazer submit. */
            $("#hidden_venda").val(aCampo_finalidade.toString());

        }

        /* fecha pop-up */
        fechar("finalidade");
    });


    /* formulario de contato */
    $("#submit_atendimento").click(function() {
        if ($("#encontrar_nome").val() == "") {
            alert("Preencha o campo nome");
            return false;
        }

        if ($("#encontrar_email").val() == "") {
            alert("Preencha o campo email");
            return false;
        }

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
            $("#campo_tipo").val(aCampo_tipo.length + ' seleconado(s)');
            //Coloca o valor em um campo hidden para fazer submit.				
            $("#hidden_tipo").val(aCampo_tipo.toString());
        }
        //fecha pop-up			
        fechar("tipo");
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
                fechar("cidade");
            });
        });
        return false;
    });


    /* FUNÇÕES QUE POPULAM O FORMULÁRIO DE SOLICITAÇÃO DE IMÓVEIS, QUANDO UM IMÓVEL NÃO É ENCONTRADO NA BUSCA */
    /* RETORNA OS VALORES PARA O CAMPO FINALIDADE DA SOLICITAÇÃO DE IMÓVEIS */
    $("#submit_localizarfinalidade").click(function() {
        var aCampo_finalidade = new Array();

        /* Guarda em um array o valor dos campos selecionados. */
        $("input[name='name_localizarfinalidade_venda']:checked").each(function() {
            aCampo_finalidade.push($(this).val());
        });

        if (aCampo_finalidade.length > 0) {
            var aVenda_finalidade = new Array();

            /* Coloca a quantidade de itens selecionados no campo de pesquisa. */
            $("#localizarfinalidade_venda").attr("checked", true);
            /* Coloca o valor em um campo hidden para fazer submit. */
            $("#hidden_localizarvenda").val(aCampo_finalidade.toString());

        }

        /* fecha pop-up */
        fechar("localizarfinalidade");
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
        fechar("localizartipo");
    });


    $("#form_localizarcidade #submit_localizarcidade").click(function() {

        var aCampo_cidade = new Array();
        $("input[name='name_localizarcidade']:checked").each(function() {
            aCampo_cidade.push($(this).val());
        });
        $("#hidden_localizarcidade").val(aCampo_cidade.toString());

        $.get(this.href + '/id/' + aCampo_cidade.toString(), function(data) {
            $("#localizarbairro-ct").css('display', 'block');
            $("#localizarbairro-ct").empty().html(data);
            $("#localizarcidade-ct").css('display', 'none');

            $("#submit_localizarsetor").click(function() {
                var aCampo_setor = new Array();
                $("input[name='name_localizarsetor']:checked").each(function() {
                    aCampo_setor.push($(this).val());
                });

                $("#encontrar_cidade").val(aCampo_setor.toString());
                $("#campo_localizarcidade").val(aCampo_setor.length + " selecionado(s)");
                fechar("localizarcidade");
            });
        });
        return false;
    });


    actionForms("form_visita", "visita");
    actionForms("form_amigo", "amigo");
    actionForms("form_ligar", "ligamos");
    actionForms("form_signup", "signup");
    actionForms("form_signup2", "signup");
    actionForms("form_avaliacao", "avaliacao");
    actionForms("form_encontrar", "encontrar");

    function actionForms(ident, janela) {
        $("#" + ident).submit(function() {
            $("#loading").fadeIn();
            var data = $(this).serializeArray(); // Dados do formulário     

            // Envia o formulário via Ajax
            $.ajax({
                type: "POST",
                url: this.action,
                data: data,
                cache: false,
                dataType: 'json',
                success: function(html)
                {
                    try {
                        jQuery.parseJSON(html);
                        if (html.hasOwnProperty('response')) {
                            
                            // pegamos o path
                            var pathname = window.location.hostname;
                            
                            // tenta um caminho da imagem
                            var caminho = '/media/imagens/captcha/' + html.captcha + '.png';
                            
                            // seta na imagem
                             $("#imgcaptcha").attr('src', caminho);
                             
                            // enquanto a URL da imagem nao for valida, subimos mais um diretório 
                           /* while(!IsValidImageUrl($("#imgcaptcha").attr('src')))
                            {
                                caminho  = '/../'+caminho;
                                $("#imgcaptcha").attr('src', pathname + caminho);
                            }*/
                           
                            $('[name="captcha[id]"]').val(html.captcha);
                            alert('Os caracteres não conferem com o da imagem!');
                            $("#loading").fadeOut();
                        }
                    } catch (error) {
                        $("#sucesso").fadeIn();
                        $("#sucesso").css({
                            'display': 'block',
                            'position': 'fixed',
                            'opacity': 0,
                            'z-index': 11000,
                            'left': 50 + '%',
                            'margin-left': -($("#sucesso").outerWidth() / 2) + "px",
                            'top': "100px"
                        });
                        $("#lean_overlay").fadeIn(200);
                        setTimeout(function() {
                            $("#lean_overlay").fadeOut(100);
                            $("#sucesso").fadeOut();
                        }, 1500);
                        $("#" + ident + " input").each(function() {
                            $(this).val('');
                        });
                        fechar(janela);
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    $("#sucesso").fadeIn();
                    $("#sucesso").css({
                        'display': 'block',
                        'position': 'fixed',
                        'opacity': 0,
                        'z-index': 11000,
                        'left': 50 + '%',
                        'margin-left': -($("#sucesso").outerWidth() / 2) + "px",
                        'top': "100px"
                    });
                    $("#lean_overlay").fadeIn(200);
                    setTimeout(function() {
                        $("#lean_overlay").fadeOut(100);
                        $("#sucesso").fadeOut();
                    }, 1500);
                }
            });
            
            return false; // Previne o form de ser enviado pela forma normal
        });
    }

    /* executa submit da busca */
    $("#submit").click(function() {
        document.buscar_imovel.submit();
    });

});

var mapa = null;
function abrir(URL) {
    var width = 730;
    var height = 557;
    var left = 99;
    var top = 99;
    if (mapa)
        mapa.close();
    mapa = window.open(URL, 'janela', 'width=' + width + ', height=' + height + ', top=' + top + ', left=' + left + ', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
}

function IsValidImageUrl(url) {
    $("<img>", {
        src: url,
        error: function() { return false; },
        load: function() { return true; }
    });
}

