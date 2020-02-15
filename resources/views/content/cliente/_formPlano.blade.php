<hr>
<h2>PLANO DO CLIENTE </h2>
<p>por um select com o segmento, e escolher pelo segmento os serviços, criar checkbox e ir marcando eles
colocando seus nomes na descricao + somando seus valores para o preço. select com tipos de pagamento</p>
<div class="input-field">
	<input type="text" name="descricao" class="validade" value="{{ isset($plano->descricao) ? $plano->descricao : '' }}">
	<label>Descrição</label>
</div>
<div class="input-field">
	<input type="number" name="preco" class="validade" value="{{ isset($plano->preco) ? $plano->preco : '' }}">
	<label>preco</label>
</div>
<div class="input-field">
	<input type="text" name="formaPagamentoPlano" class="validade" value="{{ isset($plano->formaPagamento) ? $plano->formaPagamento : '' }}">
	<label>Forma de pagamento</label>
</div>
<div class="input-field">
	<input type="date" name="dataPagamentoPlano" class="validade" value="{{ isset($plano->dataPagamento) ? $plano->dataPagamento : '' }}">
	<label>Data de pagamento</label>
</div>