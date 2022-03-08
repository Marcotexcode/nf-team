@extends('layouts.app')
@section('content')
    <div class="container">
        <a class="btn btn-success" href="{{ route('collaborators.create') }}">Nuovo Collaboratore</a>
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
                @foreach ($collaborators as $collaborator)
                <tr>
                    <th scope="row">{{$collaborator->id}}</th>
                    <td>{{$collaborator->nome}}</td>
                    <td>{{$collaborator->email}}</td>
                        <form action="{{route('collaborators.destroy', $collaborator->id)}}" method="POST">
                            <td>
                                <a class="btn btn-primary" href="{{ route('collaborators.edit', $collaborator->id) }}">Modifica</a>
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
