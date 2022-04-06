@extends('layouts.app')

@section('content')
    <div id="container" class="container">
        <div class="row">
            <div class="col">
                @foreach ($mesi as $mese)
                    @foreach ($mesiNumero as $meseNumero)
                        @foreach ($anni as $anno)
                            <div class="d-flex justify-content-center">
                                <a class="btn btn-primary my-2" href="{{route('presenze.index', ["data" => $dataPrecedente])}}"><i class="fas fa-arrow-left"></i></a>
                                <span class="text-center my-2 mx-5"><h2 class="text-center">{{$mese}} - {{$anno}}</h2></span>
                                <a class="btn btn-primary my-2" href="{{route('presenze.index', ["data" => $dataSuccessiva])}}"><i class="fas fa-arrow-right"></i></a>
                            </div>
                            <div class="my-3">
                                <span>Legenda colori:</span>
                                <div class="circle mx-1 verde"></div>
                                <span>Intera</span>
                                <div class="circle mx-1 azzurro"></div>
                                <span>Mezza</span>
                                <div class="circle mx-1 giallo"></div>
                                <span>Estera</span>
                                <div class="circle mx-1 marrone"></div>
                                <span>Formazione</span>
                                <div class="circle mx-1 viola"></div>
                                <span>Concordato</span>
                                <span class="mx-5"><span class="h5">S</span> ha il rimborso spese</span>
                                <span class="mx-3"><span class="h5">B</span> ha il bonus</span>
                            </div>
                            <span id="messaggioSuccesso"></span>
                            <div class="row"><i class="fa-solid fa-right"></i>
                                <div class="col">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">COLL</th>
                                                @for ($i=1; $i <= $data->daysInMonth; $i++)
                                                    <th scope="col">{{$i}}</th>
                                                @endfor
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($collaboratori as $collaboratore)
                                                <tr>
                                                    {{-- qui passo il nome e l'id selezionati --}}
                                                    <td>{{$collaboratore->nome}}</td>
                                                    @for ($i=1; $i <= $data->daysInMonth; $i++)
                                                        <td scope="col" class="p-0">
                                                            @php
                                                                if ($i < 10) {
                                                                    $giorno = '0'. $i;
                                                                } else {
                                                                    $giorno = $i;
                                                                }

                                                                if ($meseNumero < 10) {
                                                                    $mese = '0'. $meseNumero;
                                                                } else {
                                                                    $mese = $meseNumero;
                                                                }

                                                                $dataCella = $anno . '-' . $mese . '-' . $giorno;

                                                                $datiCella = $collaboratore->id . '-' . $anno . '-' . $mese . '-' . $giorno;

                                                                $rimborso = null;
                                                                $bonus = null;

                                                            @endphp
                                                            @if (array_key_exists($dataCella, $arrPresenze) && array_key_exists($collaboratore->id, $arrPresenze[$dataCella]))
                                                                @php
                                                                    // Condizione se seleziono bonus o rimborso mi aggiunge S o B
                                                                    if($arrPresenze[$dataCella][$collaboratore->id]->spese_rimborso) {
                                                                        $rimborso = 'S';
                                                                    }
                                                                    if($arrPresenze[$dataCella][$collaboratore->id]->bonus) {
                                                                        $bonus = 'B';
                                                                    }

                                                                    // Condizione che in base al tipo di data mi colora a cella
                                                                    if ($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Intera giornata") {
                                                                        $colore = 'verde';
                                                                    } elseif ($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Mezza giornata") {
                                                                        $colore = 'azzurro';
                                                                    }elseif ($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Giornata all' estero") {
                                                                        $colore = 'giallo';
                                                                    }elseif ($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Giornata di formazione propria") {
                                                                        $colore = 'marrone';
                                                                    }else {
                                                                        $colore = 'viola';
                                                                    }
                                                                @endphp

                                                                <div data-bs-toggle="modal" id="{{$datiCella}}" class="add apriModale p-2 {{$colore}} datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                            @else
                                                                <div data-bs-toggle="modal" id="{{$datiCella}}" class="add apriModale p-2 datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;</div>
                                                            @endif
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="modalePresenze" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nomeCollaboratore"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="StampaErrori"></ul>
                        <form id="creaAggiornaPresenza" method="POST">
                            {{-- Passo idSelezionata --}}
                            <div class="form-group my-3">
                                <input id="idCollaboratore" type="hidden" class="form-control">
                            </div>

                            {{-- Data iziale aggiunta con jquery --}}
                            <div class="form-group my-3">
                                <label for="aggiungiDataSpan">Data:</label>
                                <span id="aggiungiDataSpan"></span>
                            </div>

                            {{-- Data finale  --}}
                            <div class="form-group my-3">
                                <label for="fino_a">Fino a:</label>
                                <input class="mb-2" type="date" name="fino_a" id="fino_a">
                            </div>

                            {{-- Passo dataSelezionata --}}
                            <div class="form-group my-3">
                                <input id="aggiungiData" type="hidden" class="form-control">
                            </div>
                            <div class="form-group my-3">
                                <label for="tipo_di_presenza">Tipo di presenza</label>
                                <select class="form-control cambiaImporto" id="tipo_di_presenza">
                                    <option value="null" select>Importo</option>
                                    <option class="intera" data-tariffa="" value="Intera giornata">Intera giornata</option>
                                    <option class="mezza" data-tariffa="" value="Mezza giornata">Mezza giornata</option>
                                    <option class="estera" data-tariffa="" value="Giornata all' estero">Giornata all' estero</option>
                                    <option class="formazione" data-tariffa="" value="Giornata di formazione propria">Giornata di formazione propria</option>
                                    <option class="concordato">Giornata a prezzo concordato</option>
                                </select>
                            </div>

                            <div class="form-group my-3">
                                <label for="importo">Importo</label>
                                <input type="number" disabled="disabled" class="form-control importo" id="importo">
                            </div>

                            <div class="form-group my-3">
                                <label for="luogo">Luogo</label>
                                <input type="text" class="form-control" id="luogo">
                            </div>

                            <div class="form-group my-3">
                                <label for="descrizione">Descrizione libera:</label>
                                <textarea class="form-control" id="descrizione" rows="3"></textarea>
                            </div>

                            <div class="form-group my-3">
                                <label for="spese_rimborso">Spese da rimborsare</label>
                                <input type="number" class="form-control" id="spese_rimborso">
                            </div>

                            <div class="form-group my-3">
                                <label for="bonus">Bonus gradimento clienti</label>
                                <input type="number" class="form-control" id="bonus">
                            </div>
                            <button type="button" id="eliminaPresenza" class="btn bottone-elimina btn-danger ">Elimina</button>
                            <button type="submit" class="btn bottone-modifica btn-primary"></button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection






