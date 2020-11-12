<?php
	use App\Servicos\FormasPagamento;
	use App\Entidades\TiposIdentificacao;
	use App\Servicos\Segmento;
	use App\Servicos\Servico;
?>
<h2>CONTATO</h2>
<?php
if(isset($contato->idContato)){
?>
<button type="button" class="btnDel" onclick="delContato({{$contato->idContato}})">EXCLUIR</button>
<?php
}else{
?>
<button type="button" class="btnDel" onclick="delFormContato()">EXCLUIR</button>
<?php
}
?>
<div class="input-field">
	<input type="number" maxlength="2" min="0" name="contatoForm[ddd][]" class="validade inputContato" value="{{ isset($contato->ddd) ? $contato->ddd : old('ddd') }}">
	<label>DDD</label>
</div>

<div class="input-field">
	<input type="text" id="numContatoLabel" maxlength="12" name="contatoForm[numeroContato][]" class="validade numero inputContato" value="{{ isset($contato->numero) ? $contato->numero : old('numeroContato') }}">
	<label for="numContatoLabel">Número (se for numero residencial sem o digito 9 na frente, coloque o numero 0)</label>
</div>

<div class="input-field">
	<input type="text" maxlength="45" name="contatoForm[emailContato][]" class="validade inputContato" value="{{ isset($contato->email) ? $contato->email : old('emailContato') }}">
	<label>E-mail</label>
</div>

<div class="input-field">
	<label>Identificação</label>

	<select name="contatoForm[identificacao][]" id="identificacaoContato" class="validade inputContato" maxlength="30">
		<option value="">Selecione</option>
		@foreach(TiposIdentificacao::getAll() as $tipo => $key )
		<option value="{{ $tipo }}" {{ (isset($contato->identificacao) && $contato->identificacao == $tipo) || (old('identificacao') == $tipo) ? 'selected' : '' }}>{{ $tipo }}</option>
		@endforeach
	</select>

	<input type="text" disabled="disabled" id="identContatoManual" maxlength="30" name="contatoForm[identificacaoManual][]" class="validade inputContato none" placeholder="Digite a Identificação do contato" value="{{ isset($contato->identificacao) ? $contato->identificacao : old('identificacao') }}">
</div>

<script type="text/javascript">
	$('.numero').mask('0 0000-0000', {reverse: true});

	document.getElementById("identificacaoContato").addEventListener("change", function(){
		if (this.selectedIndex == 8) {
			$("#identContatoManual").removeClass("none");
			$("#identContatoManual").removeAttr("disabled");
		}
		if (this.selectedIndex != 8) {
			$("#identContatoManual").addClass("none");
			$("#identContatoManual").attr("disabled", "disabled");
		}
	});
</script>
