<!-- layout onde esse conteudo sera apresentado -->
@extends('layouts.main')
<!-- titulo desta pagina -->
@section('title', 'Editar Segmento')
<!-- conteudo -->
@section('content')
    <div>
        <div>
            <div>
                <h1>{{$segmento->segmento}}</h1>
            </div>

            <div class="container">
                <div class="row">
                    <form action="{{ route('segmento.atualizar', $segmento->idSegmento) }}" method="post">
                        {{csrf_field()}}
                        @include('content.segmento._form')
                        <button class="btn blue">Atualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection