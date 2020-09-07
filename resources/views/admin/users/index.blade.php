@extends('adminlte::page')

@section('title', 'Usuários')

@section('content_header')
    <h1>
        Meus Usuários
        <a class="btn btn-sm btn-success" href="{{route('users.create')}}">Novo Usuário</a>
    </h1>
@endsection

@section('content')
    
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="btn btn-sm btn-info">Editar</a>

                                @if ($loggedId != $user->id)
                                    <form class="d-inline" action="{{ route('users.destroy', ['user' => $user->id]) }}" method="post" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                        @csrf
                                        @method('delete')

                                        <button class="btn btn-sm btn-danger">Excluir</button>
                                    </form>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $users->links() }} 
        </div>
    </div>   

@endsection