<div class="input-field">
	<input type="text" name="servico" class="validade" value="{{ isset($servico->servico) ? $servico->servico : '' }}">
	<label>Nome do Serviço</label>
</div>
<div class="input-field">
	<input type="text" name="descricao" class="validade" value="{{ isset($servico->descricao) ? $servico->descricao : '' }}">
	<label>Descrição</label>
</div>
<div class="input-field">
	<input type="number" name="preco" class="validade" value="{{ isset($servico->preco) ? $servico->preco : '' }}">
	<label>Preço</label>
</div>
<div class="input-field">
	<input type="number" name="idSegmento" class="validade">
	<label>Segmento (select com o $servico->idSegmento)</label>
</div>