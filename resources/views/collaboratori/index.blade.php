@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-success" href="{{ route('collaboratori.create') }}">Nuovo Collaboratore</a>
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
                @foreach ($collaboratori as $collaboratore)
                <tr>
                    <th scope="row">{{$collaboratore->id}}</th>
                    <td>{{$collaboratore->nome}}</td>
                    <td>{{$collaboratore->email}}</td>
                        <form action="{{route('collaboratori.destroy', $collaboratore->id)}}" method="POST">
                            <td>
                                <a class="btn btn-primary" href="{{ route('collaboratori.edit', $collaboratore->id) }}">Modifica</a>
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
