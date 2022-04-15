@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-success" href="{{ route('utenti.create') }}">Nuovo utente</a>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Modifica</th>
                <th scope="col">Cancella</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($utenti as $utente)
                <tr>
                    <th scope="row">{{$utente->id}}</th>
                    <td>{{$utente->name}}</td>
                    <td>{{$utente->email}}</td>
                    <form action="{{route('utenti.destroy', $utente->id)}}" method="POST">
                        <td>
                            <a class="btn btn-primary" href="{{ route('utenti.edit', $utente->id) }}">Modifica</a>
                        </td>
                        @csrf
                        @method('DELETE')
                        <td>
                            <button type="submit"  class="btn btn-danger">Elimina</button>
                        </td>
                    </form>
                  </tr>
                @endforeach
            </tbody>
          </table>
    </div>
@endsection
