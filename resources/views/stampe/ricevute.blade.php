@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="col-12 no_print_display text-center  pt-5">
            <form class="my-5" action="{{route('filtroMese')}}" method="POST">
                @csrf
                <h4>Da qui puoi generare le ricevute per tutti i collaboratori</h4>
                <h5 class="d-inline">Scegli il mese: </h5>
                <input class="mb-2" type="month" name="meseAnno" id="meseAnno" value="{{$filtroMese}}">
                <button class="btn btn-primary text-white mx-3">CONFERMA</button>
            </form>
            <form action="{{route('filtroNome')}}" class="my-5" method="POST">
                @csrf
                <div class="d-xl-flex justify-content-between">
                    <div class="d-md-flex d-sm-block">
                        <div class="col-auto mx-2">
                            <span>Nome Collaboratore</span>
                        </div>
                        <div class="col-auto mx-2">
                            <select class="form-select" name="filtroNome" id="">
                                <option value="0">Sciegli tutti</option>

                                @foreach ($collaboratori as $collaboratore)
                                    <option value="{{$collaboratore->nome}}">{{$collaboratore->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button class="btn btn-primary">Filtra</button>
                        </div>
                    </div>
                    <div>
                        <div class="text-end d-md-flex">
                            <div class="col-auto ms-2">
                                <span>Per i risultati presenti: </span>
                            </div>
                            <div class="col-auto mx-2">
                                <button onclick="window.print()" class="btn btn-primary">Stampa</button>
                            </div>
                            <div class="col-auto mx-2">
                                <a href="download_ricevute" class="btn btn-primary">Scarica PDF</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            @foreach ($collaboratori as $collaboratore)
                <div onload="window.print();" class="col-12  border border-dark p-5 mt-5">
                    <div class="offset-7  col-5 text-danger fw-bold">
                        <span>periodo report da data 01-{{$data['mese']}}-{{$data['anno']}} a data {{$data['giorni']}}-{{$data['mese']}}-{{$data['anno']}}</span>
                    </div>
                    <div class="row">
                        <div class="col3">
                            {{$collaboratore->nome}}
                            <br>
                            {{$collaboratore->citta}}
                            <br>
                            {{$collaboratore->indirizzo}}
                            <br>
                            {{$collaboratore->telefono}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="offset-9 col-3">
                            Luogo____________
                            <br>
                            Data_____________
                            <br>
                            <br>
                            Spett.le
                            <br>
                            Nuova Fapam S.r.l.
                            <br>
                            Via Ravenna 61
                            <br>
                            65122 Pescara
                            <br>
                            P.iva 01278030687
                            <br>
                            codice Sdi: SUBM70N
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            fattura n° _________ del _________
                            <br>
                            Si rimette fattura per prestazioni professionali di formazione, giusto contratto sottoscritto, come da dettaglio:
                        </div>
                    </div>
                    <div class="row p-3">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Data</th>
                                    <th scope="col">Tipo di giornata/luogo</th>
                                    <th scope="col">Prezzo unitario</th>
                                    <th scope="col">Totale imponibile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($raccoltaPresenze as $presenza)
                                    @if ($collaboratore->id == $presenza->collaborator_id)
                                        <tr>
                                            <th scope="row">
                                                {{$presenza->data}}
                                                <br>
                                            </th>
                                            <td>
                                                {{$presenza->tipo_di_presenza}}
                                                <br>
                                                @if ($presenza->bonus)
                                                    Bonus
                                                    <br>
                                                @endif

                                                @if ($presenza->spese_rimborso)
                                                    Rimborso
                                                @endif
                                            </td>
                                            <td>
                                                € {{$presenza->importo}}
                                                <br>
                                                @if ($presenza->bonus)
                                                    € {{$presenza->bonus}}
                                                    <br>
                                                @endif
                                                @if ($presenza->spese_rimborso)
                                                    € {{$presenza->spese_rimborso}}
                                                @endif
                                            </td>
                                            <td>
                                                € {{$presenza->importo}}
                                                <br>
                                                @if ($presenza->bonus)
                                                    € {{$presenza->bonus}}
                                                    <br>
                                                @endif
                                                @if ($presenza->spese_rimborso)
                                                    € {{$presenza->spese_rimborso}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Totale imponibile</td>
                                    <td>
                                        € {{number_format($totale[$collaboratore->id],2)}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection






