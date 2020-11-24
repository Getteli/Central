<div class="input-field">
	<input type="number" name="valor" class="validade" value="{{ isset($despesa->valor) ? $despesa->valor : old('valor') }}" required>
	<label>Valor <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="descricao" maxlength="100" class="validade" value="{{ isset($despesa->descricao) ? $despesa->descricao : old('descricao') }}" required>
	<label>Descrição <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="date" name="dataPagamento" class="validade" value="{{ isset($despesa->dataPagamento) ? $despesa->dataPagamento : (old('dataPagamento') ?? date('Y-m-d')) }}" required>
	<label>Data de Pagamento <strong style="color: red">*</strong></label>
</div>
