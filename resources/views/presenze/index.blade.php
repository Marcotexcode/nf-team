@extends('layouts.app')

@section('content')
    <div class="container">
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
                                <div class="circle bg-primary"></div>
                                <span>Intera</span>
                                <div class="circle bg-secondary"></div>
                                <span>Mezza</span>
                                <div class="circle bg-success"></div>
                                <span>Estera</span>
                                <div class="circle bg-danger"></div>
                                <span>Formazione</span>
                                <div class="circle bg-warning"></div>
                                <span>Concordato</span>
                                <div class="circle bg-info"></div>
                                <span>S ha il rimborso spese</span>
                                <span>B ha il bonus</span>
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
                                                        <td scope="col" class="p-0 childDiv nomeCollaboratore">
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
                                                            @endphp

                                                            @if (array_key_exists($dataCella, $arrPresenze) && array_key_exists($collaboratore->id, $arrPresenze[$dataCella]))
                                                                <div data-bs-toggle="modal" class="add apriModale p-2 color prendiDatiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;</div>
                                                            @else
                                                                <div data-bs-toggle="modal" class="add apriModale p-2 prendiDatiPresenza" data-nome="{{$collaboratore->nome}}" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#modalePresenze">&nbsp;</div>
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
                                <input id="aggiungiId" type="hidden" class="form-control">
                            </div>

                            {{-- Data iziale aggiunta con jquery --}}
                            <div class="form-group my-3">
                                <label for="aggiungiDataSpan">Data:</label>
                                <span id="aggiungiDataSpan"></span>
                            </div>

                            {{-- Passo dataSelezionata --}}
                            <div class="form-group my-3">
                                <input id="aggiungiData" type="hidden" class="form-control">
                            </div>

                            <div class="form-group my-3">
                                <label for="tipo_di_presenza">Tipo di presenza</label>
                                <select class="form-control" id="tipo_di_presenza">
                                    <option>Giornata a prezzo concordato</option>
                                    <option data-tariffa="{{$collaboratore->intera_giornata}}" value="Intera giornata" {{--value="{{ $collaboratore->intera_giornata}}"--}}>Intera giornata</option>
                                    <option data-tariffa="{{$collaboratore->mezza_giornata}}" value="Mezza giornata" {{--value="{{ $collaboratore->mezza_giornata}}"--}}>Mezza giornata</option>
                                    <option data-tariffa="{{$collaboratore->giornata_estero}}" value="Giornata all' estero" {{--value="{{ $collaboratore->giornata_estero}}"--}}>Giornata all' estero</option>
                                    <option data-tariffa="{{$collaboratore->giornata_formazione}}" value="Giornata di formazione propria" {{--value="{{ $collaboratore->giornata_formazione}}"--}}>Giornata di formazione propria</option>
                                    <option>Giornata a prezzo concordato</option>
                                </select>
                            </div>

                            <div class="form-group my-3">
                                <label for="importo">Importo</label>
                                <input type="number" class="form-control" id="importo">
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

            $( "#creaAggiornaPresenza" ).submit(function(event) {

                event.preventDefault();

                $.ajax({
                    url: "/aggiorna_presenza",
                    type: "POST",
                    data:{
                        idColl: $('#aggiungiId').val(),
                        dataInizio: $('#aggiungiData').val(),
                        tipoPresenza: $('#tipo_di_presenza').val(),
                        importo: $('#importo').val(),
                        luogo: $('#luogo').val(),
                        descrizione: $('#descrizione').val(),
                        speseRimborso: $('#spese_rimborso').val(),
                        bonus: $('#bonus').val(),
                    },

                    success:function(response){
                        console.log(response);
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
                            location.reload();
                        }
                    },
                });
            });

            $(".prendiDatiPresenza").click(function(){

                let dataSelezionata = $(this).data('data-cella');
                let idCollaboratoreSelezionato =  $(this).data('id-collaboratore-cella');

                $('#nomeCollaboratore').text($(this).data('nome'));
                $('#aggiungiData').attr('value', dataSelezionata);
                $('#aggiungiDataSpan').text(dataSelezionata);
                $('#aggiungiId').attr('value', idCollaboratoreSelezionato);

                $.ajax({
                    url: "/prendiDatiPresenza",
                    method: 'GET',
                    data: {
                        dataSel: dataSelezionata,
                        idColl: idCollaboratoreSelezionato
                    },
                    success: function (data) {

                        if (data) {
                            $('#tipo_di_presenza').val(data.tipo_di_presenza);
                            $('#importo').attr('value', data.importo);
                            $('#luogo').attr('value', data.luogo);
                            $('#descrizione').val(data.descrizione);
                            $('#spese_rimborso').attr('value', data.spese_rimborso);
                            $('#bonus').attr('value', data.bonus);
                        }

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

            $('#eliminaPresenza').click( function () {
                $.ajax({
                    url: "/eliminaPresenza",
                    type: "DELETE",
                    data:{
                        idColl: $('#aggiungiId').val(),
                        dataInizio: $('#aggiungiData').val(),
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
        //             idColl: $('#aggiungiId').val(),
        //             dataInizio: $('#aggiungiData').val(),
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
