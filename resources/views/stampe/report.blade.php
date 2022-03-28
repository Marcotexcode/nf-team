@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Report</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Collaboratori</th>
                    <th scope="col">Email</th>
                    <th scope="col">Intere giornata</th>
                    <th scope="col">Mezze giornate</th>
                    <th scope="col">Giornate all'estero</th>
                    <th scope="col">Formazione propria</th>
                    {{-- <th scope="col">Prezzo concordato</th> --}}
                    <th scope="col">Rimborsi</th>
                    <th scope="col">Bonus gradimento clienti</th>
                    <th scope="col">Totale</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($collaboratori as $collaboratore)
                    <tr>
                        <td>{{$collaboratore->nome}}</td>
                        <td>{{$collaboratore->email}}</td>
                        <td>{{$intereGiornate[$collaboratore->id]}}</td>
                        <td>{{$mezzaGiornata[$collaboratore->id]}}</td>
                        <td>{{$giornataEstero[$collaboratore->id]}}</td>
                        <td>{{$giornataFormazione[$collaboratore->id]}}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
