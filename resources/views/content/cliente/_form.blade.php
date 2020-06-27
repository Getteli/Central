<?php
	use App\Entidades\TipoSexo;
	use App\Entidades\TiposIdentificacao;
?>
@if(isset($entidade->idEntidade))
	<a class="btn red"
	href="{{ route('cliente.deleteEntidade',$entidade->idEntidade) }}">
	Excluir</a>
@endif

@if(isset($entidade->ativo))
	@if($entidade->ativo)
	<td>
		<a class="btn green"
		href="{{ route('cliente.desativarEntidade',$cliente->idEntidade) }}">
		Desativar</a>
	</td>
	@else
	<td>
		<a class="btn green"
		href="{{ route('cliente.ativarEntidade',$cliente->idEntidade, false) }}">
		Ativar</a>
	</td>
	@endif
@endif

<select id="btnType">
	<option value="1">PF</option>
	<option value="2">PJ</option>
</select>

<div class="input-field">
	<input type="text" name="primeiroNome" maxlength="45" class="validade" value="{{ isset($entidade->primeiroNome) ? $entidade->primeiroNome : old('primeiroNome') }}" required>
	<label>Primeiro Nome <strong style="color: red">*</strong></label>
</div>
<div class="input-field inputpf">
	<input type="text" name="sobrenome" maxlength="45" class="validade" value="{{ isset($entidade->sobrenome) ? $entidade->sobrenome : old('sobrenome') }}">
	<label>Sobrenome</label>
</div>
<div class="input-field">
	<input type="email" name="email" maxlength="45" class="validade" value="{{ isset($entidade->email) ? $entidade->email : old('email') }}" required>
	<label>Email <strong style="color: red">*</strong></label>
</div>
<div class="input-field">
	<input type="text" name="apelido" maxlength="45" class="validade" value="{{ isset($entidade->apelido) ? $entidade->apelido : old('apelido') }}" required>
	<label>Apelido <strong style="color: red">*</strong></label>
</div>
<div class="input-field inputpj">
	<input type="text" name="razaoSocial" maxlength="45" class="validade" value="{{ isset($cliente->razaoSocial) ? $cliente->razaoSocial : old('razaoSocial') }}">
	<label>Razão Social</label>
</div>
<div class="input-field">
	<select name="sexo" class="validade">
		<option value="">Selecione</option>
		@foreach(TipoSexo::getAll() as $sexo => $key )
		<option value="{{ $key }}" {{ (isset($entidade->sexo) && $entidade->sexo == $key) || (old('sexo') == $key) ? 'selected' : '' }} >{{ $sexo }}</option>
		@endforeach
	</select>
	<label>Sexo</label>
</div>
<div class="input-field inputpf">
	<input type="text" name="cpf" maxlength="14" class="validade cpf">
	<label>Cpf</label>
</div>
<div class="input-field inputpf">
	<input type="text" name="rg" maxlength="12" class="validade rg">
	<label>Rg</label>
</div>
<div class="input-field inputpf">
	<input type="date" name="dataExpedicao" class="validade" value="{{ isset($entidade->dataExpedicao) ? strftime( '%Y-%m-%d',strtotime($entidade->dataExpedicao) ) : old('dataExpedicao') }}">
	<label>Data de Expedição (RG)</label>
</div>
<div class="input-field inputpf">
	<input type="text" name="orgaoEmissor" maxlength="15" class="validade" value="{{ isset($entidade->orgaoEmissor) ? $entidade->orgaoEmissor : old('orgaoEmissor') }}">
	<label>Orgão Emissor (RG)</label>
</div>
<div class="input-field inputpf">
	<input type="text" name="naturalidade" maxlength="25" class="validade" value="{{ isset($entidade->naturalidade) ? $entidade->naturalidade : old('naturalidade') }}">
	<label>Naturalidade</label>
</div>
<div class="input-field inputpf">
	<input type="text" name="nacionalidade" maxlength="25" class="validade" value="{{ isset($entidade->nacionalidade) ? $entidade->nacionalidade : old('nacionalidade') }}">
	<label>Nacionalidade</label>
</div>
<div class="input-field">
	<input type="date" name="dataNascimento" class="validade" value="{{ isset($entidade->dataNascimento) ? strftime( '%Y-%m-%d',strtotime($entidade->dataNascimento) ) : old('dataNascimento') }}">
	<label>Data de Nascimento</label>
</div>
<div class="input-field inputpj">
	<input type="text" name="cnpj" maxlength="18" class="validade cnpj" value="{{ isset($cliente->cnpj) ? $cliente->cnpj : old('cnpj') }}">
	<label>Cnpj</label>
</div>
<div class="input-field">
	<input type="text" name="link" maxlength="300" class="validade" value="{{ isset($cliente->link) ? $cliente->link : old('link') }}">
	<label>Link's</label>
</div>
<script type="text/javascript">
	// inicia somente com pf exibindo, e pj escondido
	$(".inputpj").hide();
	$("#btnType").change(function(){
		// 1 = pf
		if ( $(this).children("option:selected").val() == 1) {
			$(".inputpf").show();
			$(".inputpj").hide();
		// 2 = pj
		}else{
			$(".inputpj").show();
			$(".inputpf").hide();
		}
	});

	$('.cpf').mask('000.000.000-00', {reverse: true});
	$('.rg').mask('00.000.000-0', {reverse: true});
	$('.cnpj').mask('00.000.000/0000-00', {reverse: true});
</script>