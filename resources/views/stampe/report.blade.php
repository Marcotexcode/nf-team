@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('filtroDate')}}" class="text-center my-5" method="POST">
            @csrf
            <h4>Da qui puoi generare i report per tutti i collaboratori</h4>
            <h5>Inserisci le date di interesse</h5>
            <label for="">Da</label>
            <input type="date" name="dataIniziale">
            <label for="">A</label>
            <input type="date" name="dataFinale">
            <button type="submit" class="btn btn-primary">CONFERMA</button>
        </form>
        {{-- @if ($filtriDate['dataIniziale']) --}}
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
                            <td>€ {{$sommainteraGiornata[$collaboratore->id]}} ({{$intereGiornate[$collaboratore->id]}})</td>
                            <td>€ {{$sommaMezzaGiornata[$collaboratore->id]}} ({{$mezzaGiornata[$collaboratore->id]}})</td>
                            <td>€ {{$sommaGiornataEstero[$collaboratore->id]}} ({{$giornataEstero[$collaboratore->id]}})</td>
                            <td>€ {{$sommaGiornataFormazione[$collaboratore->id]}} ({{$giornataFormazione[$collaboratore->id]}})</td>
                            <td>€ {{$giornataRimborso[$collaboratore->id]}}</td>
                            <td>€ {{$giornataBonus[$collaboratore->id]}}</td>
                            <td>€ {{$tot[$collaboratore->id]}}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <span class="text-danger">riepilogo giornate di prestazioni professionali di formazione, da verificare, confermare e far seguire fattura come per legge</span>
        {{-- @endif --}}

    </div>
@endsection
