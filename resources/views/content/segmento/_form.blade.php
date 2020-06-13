<div class="input-field">
	<input type="text" name="segmento" class="validade" value="{{ isset($segmento->segmento) ? $segmento->segmento : old('segmento') }}">
	<label>Nome do Segmento</label>
</div>
<div class="input-field">
	<input type="text" name="descricao" class="validade" value="{{ isset($segmento->descricao) ? $segmento->descricao : old('descricao') }}">
	<label>Descrição</label>
</div>