<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>PLANO DO CLIENTE </h2>
<p>por um select com o segmento, e escolher pelo segmento os serviços, criar checkbox e ir marcando eles
colocando seus nomes na descricao + somando seus valores para o preço. select com tipos de pagamento</p>

<div class="input-field">
	<select name="idSegmento" id="idSegmento" class="validade">
		<option value="">Selecione</option>
		@foreach(Segmento::all() as $Segmento )
		<option value="{{ $Segmento->idSegmento }}">{{ $Segmento->segmento }}</option>
		@endforeach
	</select>
	<label>Segmento</label>
</div>

<div class="input-field">
	<select multiple name="idServico" class="validade">
		<option value="" disabled="disabled">Selecione</option>
		@foreach(Servico::where('idSegmento','=', 1)->get() as $Servico )
		<option value="{{ $Servico->idServico }}">{{ $Servico->servico }}</option>
		@endforeach
	</select>
	<label>Serviços</label>
</div>

<div class="input-field">
	<input type="text" name="descricao" class="validade" value="{{ isset($plano->descricao) ? $plano->descricao : '' }}">
	<label>Descrição</label>
</div>

<div class="input-field">
	<input type="number" name="preco" class="validade" value="{{ isset($plano->preco) ? $plano->preco : '' }}">
	<label>preco</label>
</div>

<div class="input-field">
	<select name="formaPagamentoPlano" class="validade">
		<option value="">Selecione</option>
		@foreach(FormasPagamento::getAll() as $meioPagto => $key )
		<option value="{{ $key }}" {{ isset($plano->formaPagamento) && $plano->formaPagamento == $meioPagto ? 'selected' : '' }}>{{ $meioPagto }}</option>
		@endforeach
	</select>
	<label>Forma de pagamento</label>
</div>

<div class="input-field">
	<input type="date" name="dataPagamentoPlano" class="validade" value="{{ isset($plano->dataPagamento) ? $plano->dataPagamento : '' }}">
	<label>Data de pagamento</label>
</div>

<script>
document.getElementById("idSegmento").addEventListener("change", function(){
	alert(this.value);
	/* com o id do segmento, eu envio via AJAX para uma rota que vai executar uma funcao que vai retornar
	a lista com os valores dos servicos
	OU criar um arquivo apenas para isso, que retorna.
	*/
});
</script>
