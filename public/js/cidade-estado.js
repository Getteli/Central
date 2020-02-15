function montaCidade(estado, pais)
{
	$.ajax({
		type:'GET',
		url:'http://api.londrinaweb.com.br/PUC/Cidades/'+estado+'/'+pais+'/0/10000',
		contentType: "application/json; charset=utf-8",
		dataType: "jsonp",
		async:false
	}).done(function(response){
		cidades='';

		$.each(response, function(c, cidade){

			cidades+='<option value="'+cidade+'">'+cidade+'</option>';

		});

		// PREENCHE AS CIDADES DE ACORDO COM O ESTADO
		$('#cidade').html(cidades);

	});
}

function montaUF(pais)
{
	$.ajax({
		type:'GET',
		url:'http://api.londrinaweb.com.br/PUC/Estados/'+pais+'/0/10000',
		contentType: "application/json; charset=utf-8",
		dataType: "jsonp",
		async:false
	}).done(function(response){
		estados='';
		$.each(response, function(e, estado){

			estados+='<option value="'+estado.UF+'">'+estado.Estado+'</option>';

		});

		// PREENCHE OS ESTADOS BRASILEIROS
		$('#estado').html(estados);

		// CHAMA A FUNÇÃO QUE PREENCHE AS CIDADES DE ACORDO COM O ESTADO
		montaCidade($('#estado').val(), pais);

		// VERIFICA A MUDANÇA NO VALOR DO CAMPO ESTADO E ATUALIZA AS CIDADES
		$('#estado').change(function(){
			montaCidade($(this).val(), pais);
		});

	});
}

function montaPais()
{
	$.ajax({
		type:	'GET',
		url:	'http://api.londrinaweb.com.br/PUC/Paisesv2/0/1000',
		contentType: "application/json; charset=utf-8",
		dataType: "jsonp",
		async:false
	}).done(function(response){
		
		paises='';

		$.each(response, function(p, pais){

			if(pais.Pais == 'Brasil'){
				paises+='<option value="'+pais.Sigla+'" selected>'+pais.Pais+'</option>';
			} else {
				paises+='<option value="'+pais.Sigla+'">'+pais.Pais+'</option>';
			}

		});

		// PREENCHE O SELECT DE PAÍSES
		$('#pais').html(paises);

		// PREENCHE O SELECT DE ACORDO COM O VALOR DO PAÍS
		montaUF($('#pais').val());

		// VERIFICA A MUDANÇA DO VALOR DO SELECT DE PAÍS
		$('#pais').change(function(){
			if($('#pais').val() == 'BR'){
				// SE O VALOR FOR BR E CONFIRMA OS SELECTS
				$('#estado').remove();
				$('#cidade').remove();
				$('#campo_estado').append('<select id="estado"></select>');
				$('#campo_cidade').append('<select id="cidade"></select>');

				// CHAMA A FUNÇÃO QUE MONTA OS ESTADOS
				montaUF('BR');		
			} else {
				// SE NÃO FOR, TROCA OS SELECTS POR INPUTS DE TEXTO
				$('#estado').remove();
				$('#cidade').remove();
				$('#campo_estado').append('<input type="text" id="estado">');
				$('#campo_cidade').append('<input type="text" id="cidade">');
			}
		})

	});
}

//Quando o campo cep perde o foco.
$("#cep").blur(function() {

//Nova variável "cep" somente com dígitos.
var cep = $(this).val().replace(/\D/g, '');

//Verifica se campo cep possui valor informado.
if (cep != "") {

	//Expressão regular para validar o CEP.
	var validacep = /^[0-9]{8}$/;

	//Valida o formato do CEP.
	if(validacep.test(cep)) {

		//Preenche os campos com "..." enquanto consulta webservice.
		$("#rua").val("...");
		$("#bairro").val("...");
		$("#cidade").val("...");
		$("#uf").val("...");
		$("#ibge").val("...");

		//Consulta o webservice viacep.com.br/
		$.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

			if (!("erro" in dados)) {
				//Atualiza os campos com os valores da consulta.
				$("#rua").val(dados.logradouro);
				$("#bairro").val(dados.bairro);
				$("#cidade").val(dados.localidade);
				$("#uf").val(dados.uf);
				$("#ibge").val(dados.ibge);
			} //end if.
			else {
				//CEP pesquisado não foi encontrado.
				limpa_formulário_cep();
				alert("CEP não encontrado.");
			}
		});
	} //end if.
	else {
		//cep é inválido.
		limpa_formulário_cep();
		alert("Formato de CEP inválido.");
	}
} //end if.
else {
	//cep sem valor, limpa formulário.
	limpa_formulário_cep();
}
});

// execute
montaPais();