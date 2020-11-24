<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Nova Despesa')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>Nova despesa</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('despesa.salvar') }}" method="post">
                        {{csrf_field()}}
                        @include('content.despesa._form')
                        <button class="btn blue">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
