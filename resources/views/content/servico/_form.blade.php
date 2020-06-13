<?php
	use App\Segmento;
?>

<div class="input-field">
	<input type="text" name="servico" class="validade" value="{{ isset($servico->servico) ? $servico->servico : old('servico') }}">
	<label>Nome do Serviço</label>
</div>
<div class="input-field">
	<input type="text" name="descricao" required class="validade" value="{{ isset($servico->descricao) ? $servico->descricao : old('descricao') }}">
	<label>Descrição</label>
</div>
<div class="input-field">
	<input type="number" name="preco" class="validade" value="{{ isset($servico->preco) ? $servico->preco : old('preco') }}">
	<label>Preço</label>
</div>
<div class="input-field">
	<select name="idSegmento" class="validade">
		<option value="">Selecione</option>
		@foreach(Segmento::all() as $Segmento )
		<option value="{{ $Segmento->idSegmento }}" {{ (isset($servico->idSegmento) && $servico->idSegmento == $Segmento->idSegmento) || (old('idSegmento') == $Segmento->idSegmento ) ? 'selected' : '' }}>{{ $Segmento->segmento }}</option>
		@endforeach
	</select>
	<label>Segmento</label>
</div>