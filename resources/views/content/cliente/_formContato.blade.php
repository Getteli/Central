<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
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
	<input type="text" maxlength="12" name="contatoForm[numeroContato][]" class="validade numero inputContato" value="{{ isset($contato->numero) ? $contato->numero : old('numeroContato') }}">
	<label>Número (se for numero residencial sem o digito 9 na frente, coloque o numero 0)</label>
</div>

<div class="input-field">
	<input type="text" maxlength="45" name="contatoForm[emailContato][]" class="validade inputContato" value="{{ isset($contato->email) ? $contato->email : old('emailContato') }}">
	<label>E-mail</label>
</div>

<div class="input-field">
	<input type="text" maxlength="30" name="contatoForm[identificacao][]" class="validade inputContato" value="{{ isset($contato->identificacao) ? $contato->identificacao : old('identificacao') }}">
	<label>Identificação</label>
</div>
<script type="text/javascript">
	$('.numero').mask('0 0000-0000', {reverse: true});
</script>