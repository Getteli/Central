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

<h5>se escolher o segmento que possua site, na gestao tecnologica</h5>
<div class="input-field">
	<input type="date" name="codLicense" class="validade" value="{{ isset($license->codLicense) ? $license->codLicense : '' }}">
	<label>Código para o script q vai na pasta do site do cliente</label>
</div>