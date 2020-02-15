<div class="input-field">
	<input type="text" name="primeiroNome" class="validade" value="{{ isset($entidade->primeiroNome) ? $entidade->primeiroNome : '' }}">
	<label>Primeiro Nome</label>
</div>
<div class="input-field">
	<input type="text" name="sobrenome" class="validade" value="{{ isset($entidade->sobrenome) ? $entidade->sobrenome : '' }}">
	<label>Sobrenome</label>
</div>
<div class="input-field">
	<input type="email" name="email" class="validade" value="{{ isset($entidade->email) ? $entidade->email : '' }}">
	<label>Email</label>
</div>
<div class="input-field">
	<input type="text" name="razaoSocial" class="validade" value="{{ isset($cliente->razaoSocial) ? $cliente->razaoSocial : '' }}">
	<label>Razão Social</label>
</div>
<div class="input-field">
	<input type="text" name="apelido" class="validade" value="{{ isset($entidade->apelido) ? $entidade->apelido : '' }}">
	<label>Apelido</label>
</div>
<div class="input-field">
	<input type="text" name="sexo" class="validade" value="{{ isset($entidade->sexo) ? $entidade->sexo : '' }}">
	<label>Sexo</label>
</div>

<div class="input-field">
	<input type="text" name="cpf" class="validade" value="{{ isset($entidade->cpf) ? $entidade->cpf : '' }}">
	<label>Cpf</label>
</div>
<div class="input-field">
	<input type="text" name="rg" class="validade" value="{{ isset($entidade->rg) ? $entidade->rg : '' }}">
	<label>Rg</label>
</div>
<div class="input-field">
	<input type="date" name="dataExpedicao" class="validade" value="{{ isset($entidade->dataExpedicao) ? $entidade->dataExpedicao : '' }}">
	<label>Data de Expedição (RG)</label>
</div>
<div class="input-field">
	<input type="text" name="orgaoEmissor" class="validade" value="{{ isset($entidade->orgaoEmissor) ? $entidade->orgaoEmissor : '' }}">
	<label>Orgão Emissor (RG)</label>
</div>
<div class="input-field">
	<input type="text" name="naturalidade" class="validade" value="{{ isset($entidade->naturalidade) ? $entidade->naturalidade : '' }}">
	<label>Naturalidade</label>
</div>
<div class="input-field">
	<input type="text" name="nacionalidade" class="validade" value="{{ isset($entidade->nacionalidade) ? $entidade->nacionalidade : '' }}">
	<label>Nacionalidade</label>
</div>
<div class="input-field">
	<input type="date" name="dataNascimento" class="validade" value="{{ isset($entidade->dataNascimento) ? $entidade->dataNascimento : '' }}">
	<label>Data de Nascimento</label>
</div>
<div class="input-field">
	<input type="text" name="cnpj" class="validade" value="{{ isset($cliente->cnpj) ? $cliente->cnpj : '' }}">
	<label>Cnpj</label>
</div>
<div class="input-field">
	<input type="text" name="link" class="validade" value="{{ isset($cliente->link) ? $cliente->link : '' }}">
	<label>Link's</label>
</div>
<div class="input-field">
	<input type="date" name="dataPagamento" class="validade" value="{{ isset($cliente->dataPagamento) ? $cliente->dataPagamento : '' }}">
	<label>Data de Pagamento (SOME E ELE RECEBE O MESMO VALOR DO PLANO ou vice e versa??)</label>
</div>
