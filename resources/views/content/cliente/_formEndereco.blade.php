<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>ENDEREÇO</h2>

<div class="input-field">
	<input type="text" name="cep" class="validade" value="{{ isset($endereco->cep) ? $endereco->cep : old('cep') }}">
	<label>CEP</label>
</div>

<div class="input-field">
	<input type="text" name="logradouro" class="validade" value="{{ isset($endereco->logradouro) ? $endereco->logradouro : old('logradouro') }}">
	<label>Logradouro</label>
</div>

<div class="input-field">
	<input type="text" name="numero" class="validade" value="{{ isset($endereco->numero) ? $endereco->numero : old('numero') }}">
	<label>Número</label>
</div>

<div class="input-field">
	<input type="text" name="complemento" class="validade" value="{{ isset($endereco->complemento) ? $endereco->complemento : old('complemento') }}">
	<label>Complemento</label>
</div>

<div class="input-field">
	<input type="text" name="estado" class="validade" value="{{ isset($endereco->estado) ? $endereco->estado : old('estado') }}">
	<label>Estado (UF)</label>
</div>

<div class="input-field">
	<input type="text" name="cidade" class="validade" value="{{ isset($endereco->cidade) ? $endereco->cidade : old('cidade') }}">
	<label>cidade</label>
</div>

<div class="input-field">
	<input type="text" name="bairro" class="validade" value="{{ isset($endereco->bairro) ? $endereco->bairro : old('bairro') }}">
	<label>Bairro</label>
</div>

<div class="input-field">
	<input type="text" name="descricaoEndereco" class="validade" value="{{ isset($endereco->descricao) ? $endereco->descricao : old('descricaoEndereco') }}">
	<label>Descrição</label>
</div>