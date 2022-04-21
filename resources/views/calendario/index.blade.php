@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @foreach ($mesiNumero as $meseNumero)
                    <div class="d-flex justify-content-center">
                        <a class="btn btn-primary my-2" href="{{ route('calendario.index', ["data" => $dataPrecedente]) }}"><i class="fas p-2 align-middle fa-arrow-left"></i></a>
                        <span class="text-center my-2 mx-5"><h2 class="text-capitalize">{{$nomeMese}} - {{$anno}}</h2></span>
                        <a class="btn btn-primary my-2" href="{{ route('calendario.index', ["data" => $dataSuccessiva]) }}"><i class="fas p-2 align-middle fa-arrow-right"></i></a>
                    </div>
                    <div class="row"><i class="fa-solid fa-right"></i>
                        <div class="col">
                            <table id="dati" class="table table-bordered">
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
                                            <td class="nome" data-nome="{{$collaboratore->nome}}">{{$collaboratore->nome}}</td>
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

                                                    @endphp
                                                    @if (array_key_exists($dataCella, $arrPresenze) && array_key_exists($collaboratore->id, $arrPresenze[$dataCella]))

                                                        @php
                                                            $rimborso = null;
                                                            $bonus = null;
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
                                                        <div data-bs-toggle="modal" data-nome="{{$collaboratore->nome}}" data-id="{{$collaboratore->id}}" data-data="{{$dataCella}}" id="{{$datiCella}}" class="add {{$colore}} p-2 datiColl" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                    @else
                                                        <div data-bs-toggle="modal" data-nome="{{$collaboratore->nome}}" data-id="{{$collaboratore->id}}" data-data="{{$dataCella}}" id="{{$datiCella}}" class="add p-2 datiColl" data-bs-target="#modalePresenze">&nbsp;</div>
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
                        <form id="creaAggiorna"  method="POST">

                            {{-- Id collaboratore ********--}}
                            <div class="form-group d-none my-3">
                                <input id="idCollaboratore" type="text" class="form-control">
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

                            {{-- Passo dataSelezionata ********--}}
                            <div class="form-group d-none my-3">
                                <input id="aggiungiData" type="text" class="form-control">
                            </div>

                            <div class="form-group my-3">
                                <label for="tipo_di_presenza">Tipo di presenza</label>
                                <select class="form-control cambia" id="tipo_di_presenza">
                                    <option value="null" id="imp">Importo</option>
                                    <option id="intera" data-tariffa="" value="Intera giornata">Intera giornata</option>
                                    <option id="mezza" data-tariffa="" value="Mezza giornata">Mezza giornata</option>
                                    <option id="estera" data-tariffa="" value="Giornata all' estero">Giornata all' estero</option>
                                    <option id="formazione" data-tariffa="" value="Giornata di formazione propria">Giornata di formazione propria</option>
                                    <option id="concordato" value="Giornata a prezzo concordato">Giornata a prezzo concordato</option>
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
                            <button type="submit" id="testoBottone"  class="btn btn-primary"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>

            // Prendere dati selezionati  e inserirli nel modale
            document.querySelector("#dati").addEventListener("click", function(event){
                console.log(event.target.tagName);

                if (event.target.tagName == 'DIV') {

                    let nomeCollaboratore = event.target.dataset.nome;
                    let idCollaboratore = event.target.dataset.id;
                    let dataPresenza = event.target.dataset.data;

                    document.getElementById("nomeCollaboratore").textContent = nomeCollaboratore;
                    document.getElementById("idCollaboratore").value = idCollaboratore;
                    document.getElementById("aggiungiDataSpan").textContent = dataPresenza;
                    document.getElementById("aggiungiData").value = dataPresenza;
                    document.getElementById("fino_a").value = dataPresenza;

                    axios.get("/datiColl", { params: { idCollaboratore } })
                    .then(function(response) {
                        document.getElementById('intera').setAttribute('data-tariffa', response.data.intera_giornata);
                        document.getElementById('mezza').setAttribute('data-tariffa', response.data.mezza_giornata);
                        document.getElementById('estera').setAttribute('data-tariffa', response.data.giornata_estero);
                        document.getElementById('formazione').setAttribute('data-tariffa', response.data.giornata_formazione);
                    })
                    .catch(function(error) {

                        console.log(error);

                    });

                    // Prendo dati presenze
                    axios.get("/datiPres", { params: { idCollaboratore, dataPresenza } })
                    .then(function(response) {

                        document.getElementById('luogo').setAttribute('value', response.data.luogo);
                        document.getElementById('importo').setAttribute('value', response.data.importo);
                        document.getElementById('idCollaboratore').setAttribute('value', response.data.collaborator_id);
                        document.getElementById('aggiungiData').setAttribute('value', response.data.data);
                        document.getElementById('descrizione').innerHTML = response.data.descrizione;
                        document.getElementById('spese_rimborso').setAttribute('value', response.data.spese_rimborso);
                        document.getElementById('bonus').setAttribute('value', response.data.bonus);
                        document.getElementById('fino_a').setAttribute('value', response.data.luogo);

                        // Il tipo di presenza nella modifica
                        if (response.data.tipo_di_presenza == 'Intera giornata') {
                            document.getElementById('intera').selected = 'selected';
                        }
                        if(response.data.tipo_di_presenza == 'Mezza giornata') {
                            document.getElementById('mezza').selected = 'selected';
                        }
                        if (response.data.tipo_di_presenza == 'Giornata all\' estero') {
                            document.getElementById('estera').selected = 'selected';
                        }
                        if (response.data.tipo_di_presenza == 'Giornata di formazione propria') {
                            document.getElementById('formazione').selected = 'selected';
                        }
                        if (response.data.tipo_di_presenza == 'Giornata a prezzo concordato') {
                            document.getElementById('concordato').selected = 'selected';
                        }
                        if (response.data.tipo_di_presenza == null) {
                            document.getElementById('imp').selected = 'selected';
                        }

                        // In base ai dati nome bottone modifica o salva
                        if (!response.data.importo == '' ) {
                            document.getElementById('testoBottone').innerHTML = 'Modifica';
                        }

                        if (response.data.importo == '') {
                            document.getElementById('testoBottone').innerHTML = 'Salva';
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                }
            });

            // Cambio importo
            document.querySelector('.cambia').addEventListener('change',function(){
                if (document.getElementById('tipo_di_presenza').options[this.selectedIndex].value == 'Giornata a prezzo concordato') {
                    document.querySelector('.importo').removeAttribute("value");
                    document.querySelector('.importo').disabled = false;
                } else {
                    document.querySelector('.importo').setAttribute("value", document.getElementById('tipo_di_presenza').options[this.selectedIndex].dataset.tariffa);
                    document.querySelector('.importo').disabled = true;
                }
            });

            // Inviare dati con  axios
            document.querySelector("#creaAggiorna").addEventListener("submit", function(e){
                e.preventDefault();

                axios.post("/crea_aggiorna", {
                    luogo: document.getElementById('luogo').value,
                    importo: document.getElementById('importo').value,
                    idColl: document.getElementById('idCollaboratore').value,
                    data: document.getElementById('aggiungiData').value,
                    tipoPresenza: document.getElementById('tipo_di_presenza').value,
                    descrizione: document.getElementById('descrizione').value,
                    speseRimborso: document.getElementById('spese_rimborso').value,
                    bonus: document.getElementById('bonus').value,
                    finoA: document.getElementById('fino_a').value,
                })
                .then(function(response) {
                        $('#modalePresenze').modal('hide');

                    let idDataPresenza = 0;

                    for(var i=0; i < response.data.length; i++){
                        // Creo una variabile uguale all'id che ho messo nel div cella
                        idDataPresenza = response.data[i].collaborator_id + '-' + response.data[i].data;

                        let colore = 0;
                        let tipoPresenza = response.data[i].tipo_di_presenza;

                        if (tipoPresenza == 'Intera giornata') {
                            colore = '#35964b';
                        }
                        if(tipoPresenza == 'Mezza giornata') {
                            colore = '#68aeca';
                        }
                        if(tipoPresenza == 'Giornata all\' estero') {
                            colore = '#c7c422';
                        }
                        if(tipoPresenza == 'Giornata di formazione propria') {
                            colore = '#757442';
                        }
                        if(tipoPresenza == 'Giornata a prezzo concordato') {
                            colore = '#7e467e';
                        }
                        if (response.data[i].spese_rimborso) {
                            document.getElementById(idDataPresenza).innerHTML = 'S';
                        }
                        if (response.data[i].bonus) {
                            document.getElementById(idDataPresenza).innerHTML = 'B';
                        }
                        if (response.data[i].spese_rimborso && response.data[i].bonus) {
                            document.getElementById(idDataPresenza).innerHTML = 'SB';
                        }
                        //prendere l'id con il dato presenza
                        document.getElementById(idDataPresenza).style.backgroundColor  = colore;
                    }

                })
                .catch(function(error) {

                    console.log(error);
                });

            });

        </script>
    </div>
@endsection


{{-- // Prendere dati selezionati  e inserirli nel modale
            // Prendo i dati di ogni cella con il foreach
            // document.querySelectorAll('.datiColl').forEach(element => {

            //     // Prendo i dati che mi srvono e li salvo in una variabile
            //     let nomeCollaboratore = element.dataset.nome;
            //     let idCollaboratore = element.dataset.id;
            //     let dataPresenza = element.dataset.data;

            //     // al click della cella
            //     element.addEventListener('click', function(event) {

            //        // document.getElementById("nomeCollaboratore").textContent = nomeCollaboratore;
            //         // document.getElementById("idCollaboratore").value = idCollaboratore;
            //         // document.getElementById("aggiungiDataSpan").textContent = dataPresenza;
            //         // document.getElementById("aggiungiData").value = dataPresenza;
            //         // document.getElementById("fino_a").value = dataPresenza;


            //         // Prendo dati per la select tipo di presenza  con una chiamata axios
            //         axios.get("/datiColl", { params: { idCollaboratore } })
            //         .then(function(response) {
            //             document.getElementById('intera').setAttribute('data-tariffa', response.data.intera_giornata);
            //             document.getElementById('mezza').setAttribute('data-tariffa', response.data.mezza_giornata);
            //             document.getElementById('estera').setAttribute('data-tariffa', response.data.giornata_estero);
            //             document.getElementById('formazione').setAttribute('data-tariffa', response.data.giornata_formazione);
            //         })
            //         .catch(function(error) {

            //             console.log(error);

            //         });

            //         // Prendo dati presenze
            //         axios.get("/datiPres", { params: { idCollaboratore, dataPresenza } })
            //         .then(function(response) {

            //             document.getElementById('luogo').setAttribute('value', response.data.luogo);
            //             document.getElementById('importo').setAttribute('value', response.data.importo);
            //             document.getElementById('idCollaboratore').setAttribute('value', response.data.collaborator_id);
            //             document.getElementById('aggiungiData').setAttribute('value', response.data.data);
            //             document.getElementById('descrizione').innerHTML = response.data.descrizione;
            //             document.getElementById('spese_rimborso').setAttribute('value', response.data.spese_rimborso);
            //             document.getElementById('bonus').setAttribute('value', response.data.bonus);
            //             document.getElementById('fino_a').setAttribute('value', response.data.luogo);

            //             // Il tipo di presenza nella modifica
            //             if (response.data.tipo_di_presenza == 'Intera giornata') {
            //                 document.getElementById('intera').selected = 'selected';
            //             }
            //             if(response.data.tipo_di_presenza == 'Mezza giornata') {
            //                 document.getElementById('mezza').selected = 'selected';
            //             }
            //             if (response.data.tipo_di_presenza == 'Giornata all\' estero') {
            //                 document.getElementById('estera').selected = 'selected';
            //             }
            //             if (response.data.tipo_di_presenza == 'Giornata di formazione propria') {
            //                 document.getElementById('formazione').selected = 'selected';
            //             }
            //             if (response.data.tipo_di_presenza == 'Giornata a prezzo concordato') {
            //                 document.getElementById('concordato').selected = 'selected';
            //             }
            //             if (response.data.tipo_di_presenza == null) {
            //                 document.getElementById('imp').selected = 'selected';
            //             }

            //             // In base ai dati nome bottone modifica o salva
            //             if (!response.data.importo == '' ) {
            //                 document.getElementById('testoBottone').innerHTML = 'Modifica';
            //             }

            //             if (response.data.importo == '') {
            //                 document.getElementById('testoBottone').innerHTML = 'Salva';
            //             }
            //         })
            //         .catch(function(error) {

            //             console.log(error);

            //         });
            //     });
            // }); --}}
