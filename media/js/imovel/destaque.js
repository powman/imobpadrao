$(document).ready(function() {
	/* Formulário */
	$("#submeter").click(function(){
		
		/* Validar radiobutton */
		if(!document.form_busca.finalidade[0].checked && !document.form_busca.finalidade[1].checked) {
			alert("Selecione o tipo da busca, Aluguel ou Venda.");
			return false;
		}
					
		document.form_busca.submit();
	});
});
