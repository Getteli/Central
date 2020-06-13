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
                    <form action="{{ route('cliente.atualizar', [$cliente->idEntidade, $plano->idPlano, $cliente->idCliente, isset($endereco->idEndereco), isset($contato->idContato)]) }}" method="post">
                        {{csrf_field()}}
                        @include('content.cliente._form')
                       <div class="row">
                            @include('content.cliente._formEndereco')
                        </div>
                        <div class="row">
                            @include('content.cliente._formContato')
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
@endsection