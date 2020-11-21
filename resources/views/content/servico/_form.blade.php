<?php
	use App\Servicos\Segmento;
?>
@if(isset($servico->idServico))
<td>
	<a class="btn red"
	href="{{ route('servico.deleteServico',$servico->idServico) }}">
	Excluir</a>
</td>
@endif

@if(isset($servico->ativo))
	@if($servico->ativo)
	<td>
		<a class="btn green"
		href="{{ route('servico.desativarServico',$servico->idServico) }}">
		Desativar</a>
	</td>
	@else
	<td>
		<a class="btn green"
		href="{{ route('servico.ativarServico',$servico->idServico) }}">
		Ativar</a>
	</td>
	@endif
@endif
<div class="input-field">
	<input type="text" name="servico" maxlength="30" class="validade" value="{{ isset($servico->servico) ? $servico->servico : old('servico') }}" required>
	<label>Nome do Serviço <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="descricao" maxlength="90" class="validade" value="{{ isset($servico->descricao) ? $servico->descricao : old('descricao') }}" required>
	<label>Descrição <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="preco" min="0" id="preco" class="validade" value="{{ isset($servico->preco) ? $servico->preco : old('preco') }}" required>
	<label>Preço <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<select name="idSegmento" class="validade" required>
		<option value="">Selecione</option>
		@foreach(Segmento::where('ativo','=',1)->get() as $Segmento )
		<option value="{{ $Segmento->idSegmento }}" {{ (isset($servico->idSegmento) && $servico->idSegmento == $Segmento->idSegmento) || (old('idSegmento') == $Segmento->idSegmento ) ? 'selected' : '' }}>{{ $Segmento->segmento }}</option>
		@endforeach
	</select>
	<label>Segmento <strong style="color: red">*</strong></label>
</div>
<script type="text/javascript">
	$('#preco').mask('000000.00', {reverse: true});
</script>
