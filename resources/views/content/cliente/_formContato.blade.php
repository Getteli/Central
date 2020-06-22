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
	<input type="text" name="contatoForm[ddd][]" class="validade inputContato" value="{{ isset($contato->ddd) ? $contato->ddd : old('ddd') }}">
	<label>DDD</label>
</div>

<div class="input-field">
	<input type="text" name="contatoForm[numeroContato][]" class="validade inputContato" value="{{ isset($contato->numero) ? $contato->numero : old('numeroContato') }}">
	<label>Número</label>
</div>

<div class="input-field">
	<input type="text" name="contatoForm[emailContato][]" class="validade inputContato" value="{{ isset($contato->email) ? $contato->email : old('emailContato') }}">
	<label>E-mail</label>
</div>

<div class="input-field">
	<input type="text" name="contatoForm[identificacao][]" class="validade inputContato" value="{{ isset($contato->identificacao) ? $contato->identificacao : old('identificacao') }}">
	<label>Identificação</label>
</div>