<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Novo Cliente')
<!-- conteudo -->
@section('content')
	<div>
		<div>
			<div>
				<h1>Novo cliente</h1>
			</div>

			<div class="container">
				<div class="row">
					<form action="{{ route('cliente.salvar') }}" method="post">
						{{csrf_field()}}
						@include('content.cliente._form')
						<button type="button" id="btnAddEndereco">Add mais enderecos</button>
						<div class="row" id="divEndereco" style="border-style: dotted;">
							<div class="containerEndereco">
								@include('content.cliente._formEndereco')
							</div>
						</div>
						<button type="button" id="btnAddContato">Add mais contato</button>
						<div class="row" id="divContato" style="border-style: dotted;">
							<div class="containerContato">
								@include('content.cliente._formContato')
							</div>
						</div>
						<div class="row">
							@include('content.cliente._formPlano')
						</div>
						<button class="btn blue">Adicionar</button>
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
		$(".containerEndereco:first .btnDelE").attr("disabled", true);
		$("#btnAddEndereco").click(function(){
			$(".containerEndereco").last().clone().appendTo("#divEndereco");
			$(".containerEndereco:last-child .inputEndereco").val("");
			$(".containerEndereco:last-child .btnDelE").attr("disabled", false);

			$(".containerEndereco:last-child .select-wrapper input").remove();
			$(".containerEndereco:last-child .select-wrapper ul").remove();
			$(".containerEndereco:last-child .select-wrapper svg").remove();
			populaEstadoCidade();
		});

		function delFormEndereco() {
			$(".containerEndereco").last().remove();
		}

		$(".containerContato:first .btnDel").attr("disabled", true);
		$("#btnAddContato").click(function(){
			$(".containerContato").last().clone().appendTo("#divContato");
			$(".containerContato:last-child .inputContato").val("");
			$(".containerContato:last-child .btnDel").attr("disabled", false);
		});
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