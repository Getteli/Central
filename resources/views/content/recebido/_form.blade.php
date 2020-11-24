<div class="input-field">
	<input type="number" name="valor" class="validade" value="{{ isset($recebido->valor) ? $recebido->valor : old('valor') }}" required>
	<label>Valor <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="descricao" maxlength="100" class="validade" value="{{ isset($recebido->descricao) ? $recebido->descricao : old('descricao') }}" required>
	<label>Descrição <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="date" name="dataEntrada" class="validade" value="{{ isset($recebido->dataEntrada) ? $recebido->dataEntrada : (old('dataEntrada') ?? date('Y-m-d')) }}" required>
	<label>Data da Entrada <strong style="color: red">*</strong></label>
</div>
