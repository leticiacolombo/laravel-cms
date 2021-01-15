@extends('adminlte::page')

@section('plugins.Chartjs', true)

{{-- Título da página --}}
@section('title', 'Painel')

@section('content_header')
    <div class="row">
        <div class="col-md-6">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6">
            <form method="GET">
                <select name="datelimit" class="float-md-right" onchange="this.form.submit()">
                    <option value="30" @if ($daysLimit == 30 ) selected="selected" @endif>Últimos 30 dias</option>
                    <option value="60" @if ($daysLimit == 60 ) selected="selected" @endif>Últimos 60 dias</option>
                </select>
            </form>
        </div>
    </div>
@endsection

{{-- Conteúdo da página --}}
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $visitsCount }}</h3>
                    <p>Visitas</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-eye"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $onlineCount }}</h3>
                    <p>Usuários Online</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-heart"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pageCount }}</h3>
                    <p>Pages</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-sticky-note"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $userCount }}</h3>
                    <p>Usuários</p>
                </div>
                <div class="icon">
                    <i class="far fa-fw fa-user"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    <canvas id="pagePie"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Páginas mais visitadas</h3>
                </div>
                <div class="card-body">
                    ...
                </div>
            </div>
        </div>
    </div>

<script>
window.onload = function() {
    let ctx = document.getElementById('pagePie').getContext('2d');
    window.pagePie = new Chart(ctx, {
        type : 'pie',
        data : {
            datasets : [{
                data : {{ $pageValues }},
                backgroundColor : '#0000FF'
            }],
            labels : {!! $pageLabels !!} //não colocar & no html
        },
        options : {
            responsive : true,
            legend : {
                display : false
            }
        }
    })
}

</script>
@endsection

{{-- Adicionar css na página --}}
@section('css')
    {{-- <link rel="stylesheet" href="...." />     --}}
@endsection

{{-- Adicionar JS na página --}}
@section('js')
    {{-- <script>alert('Rodando')</script> --}}
@endsection