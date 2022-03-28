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

                                                                $rimborso = null;
                                                                $bonus = null;

                                                            @endphp
                                                            @if (array_key_exists($dataCella, $arrPresenze) && array_key_exists($collaboratore->id, $arrPresenze[$dataCella]))
                                                                @php
                                                                    if($arrPresenze[$dataCella][$collaboratore->id]->spese_rimborso) {
                                                                        $rimborso = 'S';
                                                                    }
                                                                    if($arrPresenze[$dataCella][$collaboratore->id]->bonus) {
                                                                        $bonus = 'B';
                                                                    }
                                                                @endphp
                                                                @if ($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Intera giornata")
                                                                    <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 verde datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                                @elseif($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Mezza giornata")
                                                                    <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 azzurro datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                                @elseif($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Giornata all' estero")
                                                                    <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 giallo datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                                @elseif($arrPresenze[$dataCella][$collaboratore->id]->tipo_di_presenza == "Giornata di formazione propria")
                                                                    <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 marrone datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                                @else
                                                                    <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 viola datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;{{$rimborso}} {{$bonus}}</div>
                                                                @endif
                                                            @else
                                                                <div data-bs-toggle="modal" id="{{$collaboratore->id}} - {{$dataCella}}" class="add prova apriModale p-2 datiCollaboratore datiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;</div>
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

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".datiPresenza").click(function(){
                let dataSelezionata = $(this).data('data-cella');
                let idCollaboratoreSelezionato =  $(this).data('id-collaboratore-cella');

                $('#aggiungiData').attr('value', dataSelezionata);
                $('#fino_a').attr('value', dataSelezionata);
                $('#aggiungiDataSpan').text(dataSelezionata);

                $.ajax({
                    url: "/datiPresenza",
                    method: 'GET',
                    data: {
                        dataSel: dataSelezionata,
                        idColl: idCollaboratoreSelezionato
                    },
                    success: function (data) {
                        $('#tipo_di_presenza').val(data.tipo_di_presenza);
                        $('#importo').attr('value', data.importo);
                        $('#luogo').attr('value', data.luogo);
                        $('#descrizione').val(data.descrizione);
                        $('#spese_rimborso').attr('value', data.spese_rimborso);
                        $('#bonus').attr('value', data.bonus);

                        if (!data.importo == '' ) {
                            $('.bottone-elimina').html("Elimina");
                            $('.bottone-modifica').html("Modifica");
                            $('.bottone-elimina').removeClass("d-none").addClass("d-inline");
                        }

                        if (data.importo == '') {
                            $('.bottone-elimina').html("Elimina");
                            $('.bottone-modifica').html("Salva");
                            $('.bottone-elimina').removeClass("d-inline").addClass("d-none");
                        }
                    }
                });
            });

            $('.datiCollaboratore').click(function() {
                let idCollaboratoreSelezionato =  $(this).data('id-collaboratore-cella');

                $('#nomeCollaboratore').text($(this).data('nome'));
                $('#idCollaboratore').attr('value', idCollaboratoreSelezionato);


                $.ajax({
                    url: "/datiCollaboratore",
                    method: 'GET',
                    data: {
                        idColl: idCollaboratoreSelezionato
                    },
                    success: function (data) {
                        $('.intera').attr('data-tariffa', data.intera_giornata);
                        $('.mezza').attr('data-tariffa', data.mezza_giornata);
                        $('.estera').attr('data-tariffa', data.giornata_estero);
                        $('.formazione').attr('data-tariffa', data.giornata_formazione);
                       // $('.concordato').attr('data-tariffa', 'Importo');
                    }
                });
            });

            $( "#creaAggiornaPresenza" ).submit(function(event) {
                event.preventDefault();

                let imp = 0;
                if ($('#tipo_di_presenza').find(":selected").data('tariffa')) {
                    imp = $('#tipo_di_presenza').find(":selected").data('tariffa')
                } else {
                    imp = $('#importo').val()
                }

                $.ajax({
                    url: "/crea_aggiorna_presenza",
                    type: "POST",
                    data:{
                        idColl: $('#idCollaboratore').val(),
                        data: $('#aggiungiData').val(),
                        tipoPresenza: $('#tipo_di_presenza').val(),
                        importo: imp,
                        luogo: $('#luogo').val(),
                        descrizione: $('#descrizione').val(),
                        speseRimborso: $('#spese_rimborso').val(),
                        bonus: $('#bonus').val(),
                        finoA: $('#fino_a').val(),
                    },

                    success:function(response){
                        if (response.status == 400) {
                            $('#StampaErrori').html("");
                            $('#StampaErrori').addClass("alert alert-danger");
                            $.each(response.errors, function($key, err_value){
                                $('#StampaErrori').append('<li>' + err_value + '</li>');
                            });
                            $('#modalePresenze').modal('show');

                        }else {
                            $('#messaggioSuccesso').html("");
                            $('#messaggioSuccesso').addClass("alert alert-success");
                            $('#messaggioSuccesso').text(response.message);
                            $('#modalePresenze').modal('hide');

                            //let idCella = response[0].collaborator_id + ' - ' + response[0].data;

                            //console.log(idCella);

                            let idCella = response.collaborator_id + ' - ' + response.data;

                            $(".datiPresenza").each(function(){
                              //  console.log('dato' +  idCella);
                              //  console.log(($(this).attr("id")));

                                if (($(this).attr("id")) == idCella) {
                                    if ($('#spese_rimborso').val()) {
                                    $(this).text('S');
                                    }
                                    if ($('#bonus').val()) {
                                        $(this).text('B');
                                    }
                                    if ($('#spese_rimborso').val() && $('#bonus').val()) {
                                        $(this).text('SB');
                                    }

                                    if ($('#tipo_di_presenza').val() == 'Intera giornata') {
                                        $(this).css('background-color', '#35964b');
                                    }
                                    if($('#tipo_di_presenza').val() == "Mezza giornata") {
                                        $(this).css('background-color', '#68aeca');
                                    }
                                    if($('#tipo_di_presenza').val() == "Giornata all' estero") {
                                        $(this).css('background-color', '#c7c422');
                                    }
                                    if($('#tipo_di_presenza').val() == "Giornata di formazione propria") {
                                        $(this).css('background-color', '#757442');
                                    }
                                    if($('#tipo_di_presenza').val() == "Giornata a prezzo concordato")  {
                                        $(this).css('background-color', '#7e467e');
                                    }
                                }
                            });
                        }
                    },
                });
            });

            $(".cambiaImporto").change(function(){
                if ($('#tipo_di_presenza').find(":selected").val() == 'Giornata a prezzo concordato') {
                    $('.importo').prop('disabled', false).attr("placeholder", $('#tipo_di_presenza').find(":selected").data('tariffa'));
                } else{
                    $('.importo').prop('disabled', 'disabled').attr("placeholder", $('#tipo_di_presenza').find(":selected").data('tariffa'));
                }
               // $('.tip').attr("placeholder", $('#tipo_di_presenza').find(":selected").data('tariffa'));
            });

            $('#eliminaPresenza').click( function() {
                $.ajax({
                    url: "/eliminaPresenza",
                    type: "DELETE",
                    data:{
                        prendiIdColl: $('#idCollaboratore').val(),
                        prendiData: $('#aggiungiData').val(),
                    },
                    success: function (data) {
                        $('#modalePresenze').modal('hide');
                        location.reload();
                    }
                });
            });
        </script>
    </div>
@endsection








{{--
// Quando trovo la carella con la data corrispondente, passo il dato
                            $('#creaAggiornaPresenza').each(function(i) {
                                console.log(i + ' ' + $('#aggiungiData').val());
                            });
                            console.log($('#tipo_di_presenza').val());
                            if ($('#aggiungiData').val() == response.data) {
                                $('#dati').css('background-color', 'red');
                            } --}}


















{{-- // Prendi il dato dalla classe .nomeCollaboratore e aggiungi all'id del form modale
// $('.nomeCollaboratore').on('click', function () {
//     $('#nomeCollaboratore').text($(this).data('nome'));
// }); --}}









{{-- // $('#modalePresenze').modal('hide');
                        //window.location.reload(true);
                        // $.ajax.url( "/aggiorna_presenza" ).load();
                        // ajax.reload(response);
                        // oTable.ajax.url( 'url-to-updated-json-data' ).load();
                        //location.reload(); --}}




{{-- <p id="risposta"></p> --}}



    {{-- Data finale manuale --}}
    {{-- <div class="form-group my-3">
        <label for="exampleInputEmail1">Fino a</label>
        <input type="date" class="form-control" name="data_fine" id="data_fine">
        <span class="text-danger" id="data_fine-error"></span>
    </div> --}}


{{--
    // $('body').on('click', '#eliminaPresenza', function () {
        //     $.ajax({
        //         url: "/eliminaPresenza",
        //         type: "POST",
        //         data:{
        //             idColl: $('#idCollaboratore').val(),
        //             data: $('#aggiungiData').val(),
        //         },
        //         success:function(response){
        //             console.log(response);
        //             $('#modalePresenze').modal('hide');

        //             location.reload();
        //         },
        //         error: function(response) {
        //             console.log(response.responseJSON);
        //             $('#modalePresenze').modal('show');

        //         }
        // }); --}}




        {{-- // //Svuota il form una volta chiuso il modale
        // $('body').on('hidden.bs.modal', '.modal', function () {
        //     $('#importo').attr('value', '');
        //     $('#tipo_di_presenza').val('');
        //     $('#importo').attr('value', '');
        //     $('#luogo').attr('value', '');
        //     $('#descrizione').val('');
        //     $('#spese_rimborso').attr('value', '');
        //     $('#bonus').attr('value', '');
        // }); --}}
