<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>PLANO DO CLIENTE </h2>

<div class="input-field">
	<select multiple name="idServico" id="idServico" class="validade">
		<option value="" disabled>Selecione</option>
		@foreach(Servico::all()->where('ativo', 1) as $Servico )
			<option value="{{ $Servico->preco }}">{{ $Servico->servico }}</option>
		@endforeach
	</select>
	<label>Serviços</label>
</div>

<div class="input-field {{ isset($plano->descricao) || !empty(old('descricao')) ? '' : 'none' }}">
	<input type="text" readonly name="descricao" maxlength="350" id="descricao" class="validade noEdit" value="{{ isset($plano->descricao) ? $plano->descricao : old('descricao') }}">
	<label>Descrição</label>
</div>
<div class="input-field">
	<input type="text" name="preco" id="preco" min="0" class="validade preco" value="{{ isset($plano->preco) ? $plano->preco : old('preco') ?? 0 }}" required>
	<label>preco ( R$ )<strong style="color: red">*</strong></label>
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
	<input type="text" min="1" max="31" name="dataPagamentoPlano" id="dataPagamento" class="validade" value="{{ isset($plano->dataPagamento) ? $plano->dataPagamento : old('dataPagamentoPlano') }}" required>
	<label>DIA (Data de pagamento) <strong style="color: red">*</strong></label>
</div>	
<div class="input-field">
	<select type="text" name="especialLicense" class="validade">
		<option value="0" {{ ( isset($license->special) ? $license->special : old('especialLicense') ?? 0 ) == 0 ? 'selected' : '' }}>Não</option1>
		<optgroup label="Temporário">
			<option value="1" {{ ( isset($license->special) ? $license->special : old('especialLicense') ?? 0 ) == 1 ? 'selected' : '' }}>Apenas este cliente</option>
			<option value="2" {{ ( isset($license->special) ? $license->special : old('especialLicense') ?? 0 ) == 2 ? 'selected' : '' }}>Promoção</option>
		</optgroup>
		<optgroup label="Sem tempo">
			<option value="3" {{ ( isset($license->special) ? $license->special : old('especialLicense') ?? 0 ) == 3 ? 'selected' : '' }}>Vitalício</option>
			<option value="4" {{ ( isset($license->special) ? $license->special : old('especialLicense') ?? 0 ) == 4 ? 'selected' : '' }}>Outros (manual)</option>
		</optgroup>
	</select>
	<label>É um cliente especial ? (ex: vitalicio, promoção, etc..)</label>
</div>

<div class="input-field">
	<input type="text" name="observacaoLicense" maxlength="100" class="validade" value="{{ isset($license->observacao) ? $license->observacao : old('observacaoLicense') }}">
	<label>Observação</label>
</div>

<div class="input-field {{ isset($license->codLicense) || !empty(old('codLicense')) ? '' : 'none' }}">
	<input readonly type="text" name="codLicense" class="validade noEdit" value="{{ isset($license->codLicense) ? $license->codLicense : old('codLicense') }}">
	<label>Código de licença</label>
</div>
<script>
	$('.preco').mask('#########.##', {reverse: true});
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
				valor += Number(this.options[i].value);
				desc += this.options[i].text + "; ";
			}
		}
		// add aos inputs
		preco.focus();
		preco.value = valor.toFixed(2);
		descricao.value = desc;
		preco.blur();

		// limpa os valores
		desc = "";
		valor = 0;
	});
</script>