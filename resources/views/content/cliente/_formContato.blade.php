<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>CONTATO</h2>

<div class="input-field">
	<input type="text" name="ddd" class="validade" value="{{ isset($contato->ddd) ? $contato->ddd : old('ddd') }}">
	<label>DDD</label>
</div>

<div class="input-field">
	<input type="text" name="numeroContato" class="validade" value="{{ isset($contato->numero) ? $contato->numero : old('numeroContato') }}">
	<label>Número</label>
</div>

<div class="input-field">
	<input type="text" name="emailContato" class="validade" value="{{ isset($contato->email) ? $contato->email : old('emailContato') }}">
	<label>E-mail</label>
</div>

<div class="input-field">
	<input type="text" name="identificacao" class="validade" value="{{ isset($contato->identificacao) ? $contato->identificacao : old('identificacao') }}">
	<label>Identificação</label>
</div>