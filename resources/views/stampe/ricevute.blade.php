@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 d-flex justify-content-center pt-5">
            <form action="">
                <h4>Da qui puoi generare le ricevute per tutti i collaboratori</h4>
                <h5 class="d-inline">Scegli il mese: </h5>
                <input class="mb-2" type="month" name="meseAnno" id="meseAnno" min="2021-01" value="2022-03">
                <button class="btn btn-primary text-white mx-3">CONFERMA</button>
                <div class="d-xl-flex justify-content-between">
                    <div class="d-md-flex d-sm-block">
                        <div class="col-auto mx-2">
                            <span>Nome Collaboratore</span>
                        </div>
                        <div class="col-auto mx-2">
                            <select class="form-select" name="" id="">
                                <option value="">Scegli...</option>
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
                                <button class="btn btn-primary">Stampa</button>
                            </div>
                            <div class="col-auto mx-2">
                                <button class="btn btn-primary">Scarica PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="row">
            @foreach ($collaboratori as $collaboratore)
                <div class="col-12 border mt-5">
                    <div class="offset-7 col-5 text-danger fw-bold">
                        <span>periodo report da data 01-03-2022 a data 31-03-2022</span>
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
                            Luogo____
                            <br>
                            Data_____
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
                                @foreach ($collaboratore->presenze as $key => $presenza)
                                <tr>
                                    <th scope="row">{{$presenza->data_inizio}}</th>
                                    <td>{{$presenza->tipo_di_presenza}}
                                        <br>
                                        @if ($presenza->bonus > 0)
                                            Bonus gradimento clienti
                                        @endif
                                        <br>
                                        @if ($presenza->spese_rimborso > 0)
                                            Rimborso spese
                                        @endif
                                    </td>
                                    <td>
                                        € {{$presenza->importo}}
                                        <br>
                                        @if ($presenza->bonus > 0)
                                            € {{$presenza->bonus}}
                                        @endif
                                        <br>
                                        @if ($presenza->spese_rimborso > 0)
                                            € {{$presenza->spese_rimborso}}
                                        @endif
                                    </td>
                                    <td>
                                        € {{$presenza->importo}}
                                        <br>
                                        @if ($presenza->bonus > 0)
                                            € {{$presenza->bonus}}
                                        @endif
                                        <br>
                                        @if ($presenza->spese_rimborso > 0)
                                            € {{$presenza->spese_rimborso}}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    <td>Totale imponibile</td>
                                    <td>
                                        @foreach ($somme as $somma)
                                            {{$somma}}
                                        @endforeach
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




