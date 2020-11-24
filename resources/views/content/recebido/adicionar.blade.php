<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Recebido externo')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>Recebido externo</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('recebido.salvar') }}" method="post">
                        {{csrf_field()}}
                        @include('content.recebido._form')
                        <button class="btn blue">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
