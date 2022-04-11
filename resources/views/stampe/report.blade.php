@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{route('filtroDate')}}" class="text-center my-5" method="POST">
            @csrf
            <h4>Da qui puoi generare i report per tutti i collaboratori</h4>
            <h5>Inserisci le date di interesse</h5>
            <label for="">Da</label>
            <input type="date" name="dataIniziale"  value="{{ session('filtriDate') ? $filtriDate['dataIniziale'] : ''}}">
            <label for="">A</label>
            <input type="date" name="dataFinale" value="{{ session('filtriDate') ? $filtriDate['dataFinale'] : ''}}">
            <button type="submit" class="btn btn-primary">CONFERMA</button>
        </form>

        {{-- Se filtriDate ha un dato  --}}
        @if ($tipiDiPresenza)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Collaboratori</th>
                        <th scope="col">Email</th>
                        <th scope="col">Intere giornata</th>
                        <th scope="col">Mezze giornate</th>
                        <th scope="col">Giornate all'estero</th>
                        <th scope="col">Formazione propria</th>
                        <th scope="col">Prezzo concordato</th>
                        <th scope="col">Rimborsi</th>
                        <th scope="col">Bonus gradimento clienti</th>
                        <th scope="col">Totale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($collaboratori as $collaboratore)
                        @if ($tipiDiPresenza)
                            <tr>
                                <td>{{$collaboratore->nome}}</td>
                                <td>{{$collaboratore->email}}</td>
                                <td>€ {{number_format($importoGiornate[$collaboratore->id]['Intera giornata'],2)}} ({{$tipiDiPresenza[$collaboratore->id]['Intera giornata']}})</td>
                                <td>€ {{number_format($importoGiornate[$collaboratore->id]['Mezza giornata'],2)}} ({{$tipiDiPresenza[$collaboratore->id]['Mezza giornata']}})</td>
                                <td>€ {{number_format($importoGiornate[$collaboratore->id]['Giornata all\' estero'],2)}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata all\' estero']}})</td>
                                <td>€ {{number_format($importoGiornate[$collaboratore->id]['Giornata di formazione propria'],2)}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata di formazione propria']}})</td>
                                <td>€ {{number_format($importoGiornate[$collaboratore->id]['Giornata a prezzo concordato'],2)}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata a prezzo concordato']}})</td>
                                <td>€ {{number_format(array_sum($giornataRimborso[$collaboratore->id]),2)}}</td>
                                <td>€ {{number_format(array_sum($giornataBonus[$collaboratore->id]),2)}}</td>
                                <td>€ {{number_format(array_sum($importoGiornate[$collaboratore->id]) + array_sum($giornataRimborso[$collaboratore->id]) + array_sum($giornataBonus[$collaboratore->id]),2)}}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            <span class="text-danger">riepilogo giornate di prestazioni professionali di formazione, da verificare, confermare e far seguire fattura come per legge</span>
        @else
            <h2 class="text-center">Nessuna Presenza</h2>
        @endif
    </div>
@endsection
