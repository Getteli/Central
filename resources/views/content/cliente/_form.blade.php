<?php
	use App\Entidades\TipoSexo;
	use App\Entidades\TiposIdentificacao;
?>
<div class="input-field">
	<input type="text" name="primeiroNome" class="validade" value="{{ isset($entidade->primeiroNome) ? $entidade->primeiroNome : old('primeiroNome') }}" required>
	<label>Primeiro Nome <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="sobrenome" class="validade" value="{{ isset($entidade->sobrenome) ? $entidade->sobrenome : old('sobrenome') }}">
	<label>Sobrenome</label>
</div>
<div class="input-field">
	<input type="email" name="email" class="validade" value="{{ isset($entidade->email) ? $entidade->email : old('email') }}" required>
	<label>Email <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="apelido" class="validade" value="{{ isset($entidade->apelido) ? $entidade->apelido : old('apelido') }}" required>
	<label>Apelido <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="razaoSocial" class="validade" value="{{ isset($cliente->razaoSocial) ? $cliente->razaoSocial : old('razaoSocial') }}">
	<label>Razão Social</label>
</div>
<div class="input-field">
	<select name="sexo" class="validade">
		<option value="">Selecione</optio	n>
		@foreach(TipoSexo::getAll() as $sexo => $key )
		<option value="{{ $key }}" {{ (isset($entidade->sexo) && $entidade->sexo == $key) || (old('sexo') == $key) ? 'selected' : '' }} >{{ $sexo }}</option>
		@endforeach
	</select>
	<label>Sexo</label>
</div>
<div class="input-field">
	<input type="text" name="cpf" class="validade" value="{{ isset($entidade->cpf) ? $entidade->cpf : old('cpf') }}">
	<label>Cpf</label>
</div>
<div class="input-field">
	<input type="text" name="rg" class="validade" value="{{ isset($entidade->rg) ? $entidade->rg : old('rg') }}">
	<label>Rg</label>
</div>
<div class="input-field">
	<input type="date" name="dataExpedicao" class="validade" value="{{ isset($entidade->dataExpedicao) ? strftime( '%Y-%m-%d',strtotime($entidade->dataExpedicao) ) : old('dataExpedicao') }}">
	<label>Data de Expedição (RG)</label>
</div>
<div class="input-field">
	<input type="text" name="orgaoEmissor" class="validade" value="{{ isset($entidade->orgaoEmissor) ? $entidade->orgaoEmissor : old('orgaoEmissor') }}">
	<label>Orgão Emissor (RG)</label>
</div>
<div class="input-field">
	<input type="text" name="naturalidade" class="validade" value="{{ isset($entidade->naturalidade) ? $entidade->naturalidade : old('naturalidade') }}">
	<label>Naturalidade</label>
</div>
<div class="input-field">
	<input type="text" name="nacionalidade" class="validade" value="{{ isset($entidade->nacionalidade) ? $entidade->nacionalidade : old('nacionalidade') }}">
	<label>Nacionalidade</label>
</div>
<div class="input-field">
	<input type="date" name="dataNascimento" class="validade" value="{{ isset($entidade->dataNascimento) ? strftime( '%Y-%m-%d',strtotime($entidade->dataNascimento) ) : old('dataNascimento') }}">
	<label>Data de Nascimento</label>
</div>
<div class="input-field">
	<input type="text" name="cnpj" class="validade" value="{{ isset($cliente->cnpj) ? $cliente->cnpj : old('cnpj') }}">
	<label>Cnpj</label>
</div>
<div class="input-field">
	<input type="text" name="link" class="validade" value="{{ isset($cliente->link) ? $cliente->link : old('link') }}">
	<label>Link's</label>
</div>