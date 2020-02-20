<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Editar Serviço')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>{{$servico->servico}}</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('servico.atualizar', [$servico->idServico]) }}" method="post">
                        {{csrf_field()}}
                        @include('content.servico._form')
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