<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Despesas')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>Despesas</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('recebido.atualizar') }}" method="post">
                        {{csrf_field()}}
                        @include('content.despesa._form')
                        <button class="btn blue">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
