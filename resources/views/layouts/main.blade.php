<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- metas -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- titulo -->
        <title>@yield('title')</title>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Icones materilalize -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <!-- Styles -->
        <!-- Compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashb.css') }}">
    </head>
    <body>
        <!-- navbar desktop -->
        <div class="navbar-fixed">
            <nav>
                <div class="nav-wrapper orange">
                    <!-- logo -->
                    <a href="{{ url('/') }}" class="brand-logo">Central</a>
                    <!-- icone para abrir o navbar no mobile (carrega apenas em modo mobile) -->
                    <a href="#" data-target="mobile-navbar" class="sidenav-trigger">
                        <i class="material-icons">menu</i>
                    </a>

                    <ul id="navbar-items" class="hide-on-med-and-down right">
                        <!-- entidade -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-ent">
                            <i class="material-icons left">supervisor_account</i>
                            Entid.
                            <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-ent" class="dropdown-content">
                                <li><a href="{{route('clientes')}}">Clientes</a></li>
                                <li><a href="{{route('cliente.adicionar')}}">Adicionar cliente</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Usuários</a></li>
                                <li><a href="#">Adicionar usuários</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Listar planos</a></li>
                            </ul>
                        </li>
                        <!-- servicos -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-seg">
                            <i class="material-icons left">style</i>
                            Jobs
                            <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-seg" class="dropdown-content">
                                <li><a href="{{route('segmentos')}}">Segmentos</a></li>
                                <li><a href="{{route('segmento.adicionar')}}">Criar segmentos</a></li>
                                <li class="divider"></li>
                                <li><a href="{{route('servicos')}}">Serviços</a></li>
                                <li><a href="{{route('servico.adicionar')}}">Criar serviços</a></li>
                            </ul>
                        </li>
                        <!-- Contas -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-pay">
                            <i class="material-icons left">attach_money</i>
                            Contas
                            <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-pay" class="dropdown-content">
                                <li><a href="#">Despesas</a></li>
                                <li><a href="#">Adicionar uma despesa</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Recebidos</a></li>
                            </ul>
                        </li>
                        <!-- calendario -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-dt">
                            <i class="material-icons left">date_range</i>
                            Datas
                            <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-dt" class="dropdown-content">
                                <li><a href="#">Datas</a></li>
                                <li><a href="#">Criar uma nova data</a></li>
                            </ul>
                        </li>
                        <!-- Tarefas -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-dt">
                            <i class="material-icons left">view_list</i>
                            Tarefas
                            <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-dt" class="dropdown-content">
                                <li><a href="#">Tarefas</a></li>
                                <li><a href="#">Criar uma nova tarefa</a></li>
                            </ul>
                        </li>
                        <!-- Configuracoes -->
                        <li>
                            <a href="#" class="dropdown-trigger" data-target="dropdown-conf">
                                <i class="material-icons left">settings</i>
                                Ajustes
                                <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <ul id="dropdown-conf" class="dropdown-content">
                                <li><a href="#">Configurações</a></li>
                                <li><a href="#">Regras</a></li>
                                @auth
                                    <li><a href="{{ route('logout') }}">Sair</a></li>
                                @endauth
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- navbar mobile -->
        <ul id="mobile-navbar" class="sidenav">
            <!-- entidade -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-ent">
                <i class="material-icons left">supervisor_account</i>
                Entidades
                <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-ent" class="dropdown-content">
                    <li><a href="{{route('clientes')}}">Clientes</a></li>
                    <li><a href="{{route('cliente.adicionar')}}">Adicionar cliente</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Usuários</a></li>
                    <li><a href="#">Adicionar usuários</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Listar planos</a></li>
                </ul>
            </li>
            <!-- servicos -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-seg">
                <i class="material-icons left">style</i>
                Segmentos
                <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-seg" class="dropdown-content">
                    <li><a href="{{route('segmentos')}}">Segmentos</a></li>
                    <li><a href="{{route('segmento.adicionar')}}">Criar segmentos</a></li>
                    <li class="divider"></li>
                    <li><a href="{{route('servicos')}}">Serviços</a></li>
                    <li><a href="{{route('servico.adicionar')}}">Criar serviços</a></li>
                </ul>
            </li>
            <!-- Contas -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-pay">
                <i class="material-icons left">attach_money</i>
                Contas
                <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-pay" class="dropdown-content">
                    <li><a href="#">Despesas</a></li>
                    <li><a href="#">Adicionar uma despesa</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Recebidos</a></li>
                </ul>
            </li>
            <!-- calendario -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-dt">
                <i class="material-icons left">date_range</i>
                Datas
                <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-dt" class="dropdown-content">
                    <li><a href="#">Datas</a></li>
                    <li><a href="#">Criar uma nova data</a></li>
                </ul>
            </li>
            <!-- Tarefas -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-dt">
                <i class="material-icons left">view_list</i>
                Tarefas
                <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-dt" class="dropdown-content">
                    <li><a href="#">Tarefas</a></li>
                    <li><a href="#">Criar uma nova tarefa</a></li>
                </ul>
            </li>
            <!-- Configuracoes -->
            <li>
                <a href="#" class="dropdown-trigger" data-target="dropdown-m-conf">
                    <i class="material-icons left">settings</i>
                    Ajustes
                    <i class="material-icons right">arrow_drop_down</i>
                </a>
                <ul id="dropdown-m-conf" class="dropdown-content">
                    <li><a href="#">Configurações</a></li>
                    <li><a href="#">Regras</a></li>
                    @auth
                        <li><a href="{{ route('logout') }}">Sair</a></li>
                    @endauth
                </ul>
            </li>
        </ul>

        <!-- conteudo -->
        <div>
            <main>
                @yield('content')
            </main>
        </div>

        <!-- scripts -->
        <!-- Compiled and minified JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
        <script src="{{ asset('js/dashb.js') }}"></script>