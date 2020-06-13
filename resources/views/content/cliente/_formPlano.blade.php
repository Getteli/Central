<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>PLANO DO CLIENTE </h2>

<div class="input-field">
	<select multiple name="idServico" id="idServico" class="validade">
		<option value="" disabled>Selecione</option>
		@foreach(Servico::all() as $Servico )
			<option value="{{ $Servico->preco }}">{{ $Servico->servico }}</option>
		@endforeach
	</select>
	<label>Serviços</label>
</div>

<div class="input-field {{ isset($plano->descricao) || (isset(old('descricao')) ? '' : 'none' }}">
	<input type="text" name="descricao" id="descricao" class="validade" value="{{ isset($plano->descricao) ? $plano->descricao : old('descricao') }}">
	<label>Descrição</label>
</div>

<div class="input-field">
	<input type="number" name="preco" id="preco" class="validade" value="{{ isset($plano->preco) ? $plano->preco : old('preco') }}">
	<label>preco</label>
</div>

<div class="input-field">
	<select name="formaPagamentoPlano" class="validade">
		<option value="">Selecione</option>
		@foreach(FormasPagamento::getAll() as $meioPagto => $key )
		<option value="{{ $key }}" {{ (isset($plano->formaPagamento) && $plano->formaPagamento == $key) || (old('formaPagamentoPlano') == $key) ? 'selected' : '' }}>{{ $meioPagto }}</option>
		@endforeach
	</select>
	<label>Forma de pagamento</label>
</div>

<div class="input-field">
	<input type="date" name="dataPagamentoPlano" class="validade" value="{{ isset($plano->dataPagamento) ? strftime( '%Y-%m-%d',strtotime($plano->dataPagamento) ) : old('dataPagamentoPlano') }}">
	<label>Data de pagamento</label>
</div>

<div class="input-field">
	<input type="text" name="observacaoLicense" class="validade" value="{{ isset($license->observacao) ? $license->observacao : old('observacaoLicense') }}">
	<label>Observação</label>
</div>

<div class="input-field">
	<input type="text" name="especialLicense" class="validade" value="{{ isset($license->special) ? $license->special : old('especialLicense') }}">
	<label>Especial ?</label>
</div>

<div class="input-field {{ isset($license->codLicense) || isset(old('codLicense')) ? '' : 'none' }}">
	<input readonly type="text" name="codLicense" class="validade" value="{{ isset($license->codLicense) ? $license->codLicense : old('codLicense') }}">
	<label>Código de licença</label>
</div>


<script>
	// var aux
	var valor = 0;
	var desc = "";
	var descricao = document.getElementById("descricao");
	var preco = document.getElementById("preco");

	document.getElementById("idServico").addEventListener("change", function(){	
		// passa por todos os options selecionados
		for(var i = 1; i < this.options.length; i++)
		{
			if(this.options[i].selected == true)
			{
				// coloca os valores e os nomes dos serviços
				valor += parseInt(this.options[i].value);
				desc += this.options[i].text + "; ";
			}
		}
		// add aos inputs
		preco.focus();
		preco.value = valor;
		preco.blur();

		descricao.focus();
		descricao.value = desc;
		preco.blur();

		// limpa os valores
		desc = "";
		valor = 0;
	});
</script>