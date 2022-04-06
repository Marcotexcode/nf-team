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
                                <td>€ {{$importoGiornate[$collaboratore->id]['Intera giornata']}} ({{$tipiDiPresenza[$collaboratore->id]['Intera giornata']}})</td>
                                <td>€ {{$importoGiornate[$collaboratore->id]['Mezza giornata']}} ({{$tipiDiPresenza[$collaboratore->id]['Mezza giornata']}})</td>
                                <td>€ {{$importoGiornate[$collaboratore->id]['Giornata all\' estero']}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata all\' estero']}})</td>
                                <td>€ {{$importoGiornate[$collaboratore->id]['Giornata di formazione propria']}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata di formazione propria']}})</td>
                                <td>€ {{$importoGiornate[$collaboratore->id]['Giornata a prezzo concordato']}} ({{$tipiDiPresenza[$collaboratore->id]['Giornata a prezzo concordato']}})</td>
                                <td>€ {{array_sum($giornataRimborso[$collaboratore->id])}}</td>
                                <td>€ {{array_sum($giornataBonus[$collaboratore->id])}}</td>
                                <td>€ {{array_sum($importoGiornate[$collaboratore->id]) + array_sum($giornataRimborso[$collaboratore->id]) + array_sum($giornataBonus[$collaboratore->id])}}</td>
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




































































{{-- {{$collaboratore->presenze->importo}}
{{$tipiDiPresenza[$collaboratore->id]['Intera giornata']}} --}}



{{-- @foreach ($collaboratori as $collaboratore)
                        {{-- Se il collaboratore ha il totale --}}
                        {{-- @if ($tot[$collaboratore->id])

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
                        @endif
                    @endforeach  --}}




                    {{-- @foreach ($collaboratori as $collaboratore)
                        @if ($tot[$collaboratore->id])
                            {{$collaboratore->presenze->data}}
                            <tr>
                                <td>{{$collaboratore->nome}}</td>
                                <td>{{$collaboratore->email}}</td>
                                <td>€ {{$tipiDiPresenza[$collaboratore->id]['Intera giornata'] * $collaboratore->intera_giornata}} ({{$tipiDiPresenza[$collaboratore->id]['Intera giornata']}})</td>
                                <td>€ {{$tipiDiPresenza[$collaboratore->id]['Mezza giornata'] * $collaboratore->mezza_giornata}} ({{$tipiDiPresenza[$collaboratore->id]['Mezza giornata']}})</td>
                            </tr>
                        @endif
                    @endforeach --}}



                    {{-- @foreach ($raccoltaPresenze as $raccoltaPresenza)
                        <tr>
                            <td>{{$raccoltaPresenza->collaboratori->nome}}</td>
                            <td>{{$raccoltaPresenza->collaboratori->email}}</td>
                            <td>€ {{$tipiDiPresenza[$raccoltaPresenza->collaboratori->id]['Intera giornata'] * $raccoltaPresenza->collaboratori->intera_giornata}} ({{$tipiDiPresenza[$raccoltaPresenza->collaboratori->id]['Intera giornata']}})</td>
                        </tr>
                    @endforeach --}}
