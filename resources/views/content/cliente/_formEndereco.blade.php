<?php
	use App\Servicos\FormasPagamento;
	use App\Segmento;
	use App\Servico;
?>
<h2>ENDEREÇO</h2>
<p>obs: campos obrigatorios apenas se quiser adicionar um endereço</p>
<?php
if(isset($endereco->idEndereco)){
?>
<button type="button" class="btnDelE" onclick="delEndereco({{$endereco->idEndereco}})">EXCLUIR</button>
<?php
}else{
?>
<button type="button" class="btnDelE" onclick="delFormEndereco()">EXCLUIR</button>
<?php
}
?>
<div class="input-field">
	<input type="text" name="enderecoForm[cep][]" class="validade inputEndereco" value="{{ isset($endereco->cep) ? $endereco->cep : old('cep') }}">
	<label>CEP <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[logradouro][]" class="validade inputEndereco" value="{{ isset($endereco->logradouro) ? $endereco->logradouro : old('logradouro') }}">
	<label>Logradouro <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[numero][]" class="validade inputEndereco" value="{{ isset($endereco->numero) ? $endereco->numero : old('numero') }}">
	<label>Número <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[complemento][]" class="validade inputEndereco" value="{{ isset($endereco->complemento) ? $endereco->complemento : old('complemento') }}">
	<label>Complemento</label>
</div>

<div class="input-field">
	<!-- value="{{ isset($endereco->estado) ? $endereco->estado : old('estado') }}" -->
	<select type="text" name="enderecoForm[estado][]" class="validade inputEndereco uf">
	</select>
	<label>Estado (UF) <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<!-- value="{{ isset($endereco->cidade) ? $endereco->cidade : old('cidade') }}" -->
	<select type="text" name="enderecoForm[cidade][]" class="validade inputEndereco cid">
	</select>
	<label>cidade <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[bairro][]" class="validade inputEndereco" value="{{ isset($endereco->bairro) ? $endereco->bairro : old('bairro') }}">
	<label>Bairro <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[descricaoEndereco][]" class="validade inputEndereco" value="{{ isset($endereco->descricao) ? $endereco->descricao : old('descricaoEndereco') }}">
	<label>Descrição</label>
</div>