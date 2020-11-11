<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Novo Segmento')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>Novo segmento</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('segmento.salvar') }}" method="post">
                        {{csrf_field()}}
                        @include('content.segmento._form')
                        <button class="btn blue">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection