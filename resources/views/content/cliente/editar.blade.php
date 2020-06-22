<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Editar cliente')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<div>
				<h1>{{$entidade->apelido}}</h1>
			</div>

			<div class="container">
				<div class="row">
					<form action="{{ route('cliente.atualizar', [$cliente->idEntidade, $plano->idPlano, $cliente->idCliente]) }}" method="post">
						{{csrf_field()}}
						@include('content.cliente._form')
						<!-- endereco -->
						<button type="button" id="btnAddEndereco">Add mais endereco</button>
						<div class="row" id="divEndereco" style="border-style: dotted;">
						<?php
						if (!$enderecos->isEmpty()) {
						foreach ($enderecos as $key => $endereco) {
						?>
							<div class="containerEndereco" id="{{$endereco->idEndereco}}">
								@include('content.cliente._formEndereco')
							</div>
						<?php
						}
						}else{
						?>
							<div class="containerEndereco">
								@include('content.cliente._formEndereco')
							</div>
						<?php
						}
						?>
						</div>

						<button type="button" id="btnAddContato">Add mais contato</button>
						<div class="row" id="divContato" style="border-style: dotted;">
						<?php
						if (!$contatos->isEmpty()) {
						foreach ($contatos as $key => $contato) {
						?>
							<div class="containerContato" id="{{$contato->idContato}}">
								@include('content.cliente._formContato')
							</div>
						<?php
						}
						}else{
						?>
							<div class="containerContato">
								@include('content.cliente._formContato')
							</div>
						<?php
						}
						?>
						</div>
						<div class="row">
							@include('content.cliente._formPlano')
						</div>
						<button class="btn blue">Atualizar</button>
					</form>
				</div>
			</div>

			@if(Session::has('mensagem'))
				<div>
					{{ Session::get('mensagem')['msg'] }}
				</div>
			@endif
		</div>
	</div>
	<script type="text/javascript">
		// endereco
		if (!$(".containerEndereco:first .inputEndereco").val()) {
			$(".containerEndereco:first .btnDelE").attr("disabled", true);
		}
		$("#btnAddEndereco").click(function(){
			$(".containerEndereco").last().clone().appendTo("#divEndereco");
			$(".containerEndereco:last-child").removeAttr("id");
			$(".containerEndereco:last-child .inputEndereco").val("");
			$(".containerEndereco:last-child .btnDelE").attr("disabled", false);
			$(".containerEndereco:last-child .btnDelE").attr("onclick", "delFormEndereco()");

			$(".containerEndereco:last-child .select-wrapper input").remove();
			$(".containerEndereco:last-child .select-wrapper ul").remove();
			$(".containerEndereco:last-child .select-wrapper svg").remove();
			populaEstadoCidade();
		});
		function delEndereco($idEndereco) {
			// manda o token como cabecalho
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				}
			});
			$.ajax({
				url: "{{ route('cliente.deleteEndereco') }}",
				type: "POST",
				data: {
					'idEndereco': $idEndereco
				},
				success: function(response){
					alert(response);
					// verifica se só existe uma div de endereco
					if ($(".containerEndereco").length === 1) {
						$(".containerEndereco:last-child .inputEndereco").val("");
						$(".containerEndereco:last-child .btnDelE").attr("disabled", true);
					}else{
						document.getElementById($idEndereco).outerHTML = "";
					}
				},
				error: function(response){
					alert("erro ao excluir endereço, Avisa o Douglas :v");
				}
			});
		}
		function delFormEndereco() {
			$(".containerEndereco").last().remove();
		}
		// ----------------------------------------------------------------------
		// contato
		if (!$(".containerContato:first .inputContato").val()) {
			$(".containerContato:first .btnDel").attr("disabled", true);
		}
		$("#btnAddContato").click(function(){
			$(".containerContato").last().clone().appendTo("#divContato");
			$(".containerContato:last-child").removeAttr("id");
			$(".containerContato:last-child .inputContato").val("");
			$(".containerContato:last-child .btnDel").attr("disabled", false);
			$(".containerContato:last-child .btnDel").attr("onclick", "delFormEndereco()");
		});
		function delContato($idContato) {
			// manda o token como cabecalho
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': "{{ csrf_token() }}"
				}
			});
			$.ajax({
				url: "{{ route('cliente.deleteContato') }}",
				type: "POST",
				data: {
					'idContato': $idContato
				},
				success: function(response){
					alert(response);
					// verifica se só tem 1 div de contato
					if ($(".containerContato").length === 1) {
						$(".containerContato:last-child .inputContato").val("");
						$(".containerContato:last-child .btnDel").attr("disabled", true);
					}else{
						document.getElementById($idContato).outerHTML = "";
					}
				},
				error: function(response){
					alert("erro ao excluir contato, Avisa o Douglas :v");
				}
			});
		}
		function delFormContato() {
			$(".containerContato").last().remove();
		}
		// buscar estado e cidades
		function populaEstadoCidade() {
			new dgCidadesEstados({
				cidade: document.getElementsByClassName('cid')[document.getElementsByClassName('cid').length-1],
				estado: document.getElementsByClassName('uf')[document.getElementsByClassName('uf').length-1]
				// para setar um valor:
				// estadoVal: '',
				// cidadeVal: ''
			})
			$('select').formSelect();
		}
		populaEstadoCidade();
	</script>
@endsection