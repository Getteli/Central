@if(isset($segmento->idSegmento))
<td>
	<a class="btn red"
	href="{{ route('segmento.deleteSegmento',$segmento->idSegmento) }}">
	Excluir</a>
</td>
@endif

@if(isset($segmento->ativo))
	@if($segmento->ativo)
	<td>
		<a class="btn green"
		href="{{ route('segmento.desativarSegmento',$segmento->idSegmento) }}">
		Desativar</a>
	</td>
	@else
	<td>
		<a class="btn green"
		href="{{ route('segmento.ativarSegmento',$segmento->idSegmento) }}">
		Ativar</a>
	</td>
	@endif
@endif
<div class="input-field">
	<input type="text" name="segmento" maxlength="30" class="validade" value="{{ isset($segmento->segmento) ? $segmento->segmento : old('segmento') }}" required>
	<label>Nome do Segmento <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="descricao" maxlength="90" class="validade" value="{{ isset($segmento->descricao) ? $segmento->descricao : old('descricao') }}" required>
	<label>Descrição <strong style="color: red">*</strong></label>
</div>