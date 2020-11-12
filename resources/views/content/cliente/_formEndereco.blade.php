<?php
	use App\Servicos\FormasPagamento;
	use App\Servicos\Segmento;
	use App\Servicos\Servico;
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
	<input type="text" maxlength="10" name="enderecoForm[cep][]" class="validade cep inputEndereco" value="{{ isset($endereco->cep) ? $endereco->cep : old('cep') }}">
	<label>CEP <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[logradouro][]" maxlength="90" class="validade inputEndereco" value="{{ isset($endereco->logradouro) ? $endereco->logradouro : old('logradouro') }}">
	<label>Logradouro <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[numero][]" maxlength="10" class="validade inputEndereco" value="{{ isset($endereco->numero) ? $endereco->numero : old('numero') }}">
	<label>Número <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[complemento][]" maxlength="45" class="validade inputEndereco" value="{{ isset($endereco->complemento) ? $endereco->complemento : old('complemento') }}">
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
	<input type="text" name="enderecoForm[bairro][]" maxlength="45" class="validade inputEndereco" value="{{ isset($endereco->bairro) ? $endereco->bairro : old('bairro') }}">
	<label>Bairro <strong style="color: red">*</strong></label>
</div>

<div class="input-field">
	<input type="text" name="enderecoForm[descricaoEndereco][]" maxlength="45" class="validade inputEndereco" value="{{ isset($endereco->descricao) ? $endereco->descricao : old('descricaoEndereco') }}">
	<label>Descrição</label>
</div>
<script type="text/javascript">
	$('.cep').mask('00000-000', {reverse: true});
	new dgCidadesEstados({
		cidade: document.getElementsByClassName('cid')[document.getElementsByClassName('cid').length-1],
		estado: document.getElementsByClassName('uf')[document.getElementsByClassName('uf').length-1],
		// para setar um valor:
		estadoVal: "{{ isset($endereco->estado) ? $endereco->estado : old('estado') }}",
		cidadeVal: "{{ isset($endereco->cidade) ? $endereco->cidade : old('cidade') }}"
	})
</script>
