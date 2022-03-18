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
                                                        <td scope="col" class="p-0 childDiv aggNomeCollaboratore" data-nome="{{$collaboratore->nome}}">
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

                                                                $dataCellaId[$anno . '-' . $mese . '-' . $giorno][$collaboratore->id] = 'hello';
                                                               // dd($dataCellaId);
                                                            @endphp

                                                            {{-- Preprendere il valore dell'array --}}
                                                            {{-- @foreach ($arrPresenze as $arrPresenza)
                                                                @foreach ($arrPresenza as $item)
                                                                    {{$item}}
                                                                @endforeach
                                                            @endforeach --}}

                                                            {{-- @if (array_key_exists($dataCella, $arrPresenze) )
                                                                @foreach ($arrPresenze as $item)
                                                                    @if (array_key_exists($collaboratore->id, $item))
                                                                    {{}}
                                                                    @endif
                                                                @endforeach
                                                            @endif --}}

                                                            {{-- @if (array_key_exists($dataCella, $arrPresenze) )
                                                                {{'ciao'}}
                                                            @endif --}}

                                                            <!-- Button trigger modal -->
                                                            {{-- {{array_key_exists($dataCella, $arrPresenze) ? "color" : ''}} --}}
                                                            <div data-bs-toggle="modal" class="add p-2 prendiDati" data-id-collaboratore-cella="{{$collaboratore->id}}" data-data-cella="{{$dataCella}}" data-bs-target="#exampleModal">&nbsp;</div>
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
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="aggNomeCollModale"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_presenze" action="{{ route('presenze.store')}}" method="POST">

                            {{-- Passo idSelezionata --}}
                            <div class="form-group my-3">
                                <input id="aggiungiIdInput" type="hidden" class="form-control">
                            </div>

                            {{-- Data iziale aggiunta con jquery --}}
                            <div class="form-group my-3">
                                <label for="aggiungiDataSpan">Data:</label>
                                <span id="aggiungiDataSpan"></span>
                            </div>

                            {{-- Passo dataSelezionata --}}
                            <div class="form-group my-3">
                                <input id="aggiungiDataInput" type="hidden" class="form-control">
                            </div>

                            {{-- Data finale manuale --}}
                            {{-- <div class="form-group my-3">
                                <label for="exampleInputEmail1">Fino a</label>
                                <input type="date" class="form-control" name="data_fine" id="data_fine">
                                <span class="text-danger" id="data_fine-error"></span>
                            </div> --}}

                            {{-- Tipo di presenza --}}
                            <div class="form-group my-3">
                                <label for="tipo_di_presenza">Tipo di presenza</label>
                                <select class="form-control" id="tipo_di_presenza">
                                    <option>Giornata a prezzo concordato</option>
                                    <option data-tariffa="{{$collaboratore->intera_giornata}}"  value="Intera giornata" {{--value="{{ $collaboratore->intera_giornata}}"--}}>Intera giornata</option>
                                    <option data-tariffa="{{$collaboratore->mezza_giornata}}" value="Mezza giornata" {{--value="{{ $collaboratore->mezza_giornata}}"--}}>Mezza giornata</option>
                                    <option data-tariffa="{{$collaboratore->giornata_estero}}" value="Giornata all' estero" {{--value="{{ $collaboratore->giornata_estero}}"--}}>Giornata all' estero</option>
                                    <option data-tariffa="{{$collaboratore->giornata_formazione}}" value="Giornata di formazione propria" {{--value="{{ $collaboratore->giornata_formazione}}"--}}>Giornata di formazione propria</option>
                                    <option>Giornata a prezzo concordato</option>
                                </select>
                            </div>

                            {{-- Importo --}}
                            <div class="form-group my-3">
                                <label for="importo">Importo</label>
                                <input type="number" class="form-control" id="importo">
                            </div>

                            {{-- Luogo --}}
                            <div class="form-group my-3">
                                <label for="luogo">Luogo</label>
                                <input type="text" class="form-control" id="luogo">
                            </div>

                            {{-- Descrizione --}}
                            <div class="form-group my-3">
                                <label for="descrizione">Descrizione libera:</label>
                                <textarea class="form-control" id="descrizione" rows="3"></textarea>
                            </div>

                            {{-- Spese rimborso --}}
                            <div class="form-group my-3">
                                <label for="spese_rimborso">Spese da rimborsare</label>
                                <input type="number" class="form-control" id="spese_rimborso">
                            </div>

                            {{-- Bonus clienti --}}
                            <div class="form-group my-3">
                                <label for="bonus">Bonus gradimento clienti</label>
                                <input type="number" class="form-control" id="bonus">
                            </div>

                            {{-- class cambia colore  --}}
                            <button type="submit" aria-label="Close" data-bs-dismiss="modal" class="btn btn-primary">Salva</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Invio dati tramite ajax
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Prendi il dato dalla classe .aggNomeCollaboratore e aggiungi all'id del form modale
            $('.aggNomeCollaboratore').on('click', function () {
                $('#aggNomeCollModale').text($(this).data('nome'));
            });

            // Invio dati tramite ajax
            $( "#form_presenze" ).submit(function( event ) {
                event.preventDefault();

                let idCollaboratore = $('#aggiungiIdInput').val();

                let dataInizio = $('#aggiungiDataInput').val();

                let tipoPresenza = $('#tipo_di_presenza').val();

                let importo = $('#importo').val();

                let luogo = $('#luogo').val();

                let descrizione = $('#descrizione').val();

                let speseRimborso = $('#spese_rimborso').val();

                let bonus = $('#bonus').val();

                $.ajax({
                    url: "/presenze_store",
                    type: "POST",
                    data:{
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        idColl: idCollaboratore,
                        dataInizio: dataInizio,
                        tipoPresenza: tipoPresenza,
                        importo: importo,
                        luogo: luogo,
                        descrizione: descrizione,
                        speseRimborso: speseRimborso,
                        bonus: bonus,
                    },

                    success:function(response){
                        console.log(response);
                        if (response) {
                            $('#success-message').text(response.success);
                            $("#form_presenze")[0].reset();
                        }
                    },
                    error: function(response) {
                        $('#idCollaboratore-error').text(response.responseJSON.errors.idCollaboratore);
                        $('#aggiungiDataInput-error').text(response.responseJSON.errors.dataInizio);
                        $('#tipo_di_presenza-error').text(response.responseJSON.errors.tipoPresenza);
                        $('#importo-error').text(response.responseJSON.errors.importo);
                        $('#luogo-error').text(response.responseJSON.errors.luogo);
                        $('#descrizione-error').text(response.responseJSON.errors.descrizione);
                        $('#spese_rimborso-error').text(response.responseJSON.errors.speseRimborso);
                        $('#bonus-error').text(response.responseJSON.errors.bonus);
                    }
                });
            });

            // Prendere i dati tramite ajax
            $(".prendiDati").click(function(){

                $('#aggiungiDataInput').attr('value', $(this).data('data-cella'));
                $('#aggiungiDataSpan').text($(this).data('data-cella'));
                $('#aggiungiIdInput').attr('value', $(this).data('id-collaboratore-cella'));

                //prende il dato che si trova nella casella selezionata
                let dataSelezionata = $(this).data('data-cella');
                let idCollaboratore =  $(this).data('id-collaboratore-cella');

                $.ajax({
                    url: "/prendiDati",
                    method: 'GET',
                    data: {
                        idColl: idCollaboratore,
                        dataSel: dataSelezionata
                    },

                    success: function (data) {

                        $.each(data.prendiDatiPresenze, function(key, item){
                           // $('#tipo_di_presenza').prop('selected', item.tipo_di_presenza);
                            $('#importo').attr('value', item.importo);
                            $('#luogo').attr('value', item.luogo);
                            //$('#descrizione').attr('value', item.descrizione);
                            $('#spese_rimborso').attr('value', item.spese_rimborso);
                            $('#bonus').attr('value', item.bonus);
                        });

                    },

                    error: function() {
                    }
                });
            });


        </script>
    </div>
@endsection






{{-- // $('.casella').on('click', function () {
    //     $('#aggiungiDataInput').attr('value', $(this).data('data'));
    //     $('#aggiungiDataSpan').text($(this).data('data'));
    //     $('#aggiungiIdInput').attr('value', $(this).data('id-collaboratore-cella'));
    // });

    // // Aggiunta id collaboratore al tag input
    // $('.aggiungiId').on('click', function () {
    //     $('#aggiungiIdInput').attr('value', $(this).data('id-collaboratore-cella'));
    // }); --}}



    {{-- console.log(data.prendiDatiCollaboratore);
    console.log(data.prendiDatiPresenze); --}}























































{{-- // // Aggiunta data al tag span
// $(').on('click', function () {
//     $('#aggiungiDataSpan').text($(this).data('data'));
// });

// Aggiunta data al tag span DISABILITARE Tariffe
// $('#TipoPresenza').change(function () {
//     console.log($(this).data('tariffa'));

// $('#tariffaPresenza').attr('value', $(this).data('tariffa')); //.prop('disabled', true);
// }); --}}











{{--
// Aggiunta data al tag span DISABILITARE Tariffe
// $('#TipoPresenza').change(function () {
//     console.log($(this).data('tariffa'));
//    $('#tariffaPresenza').attr('value', $(this).data('tariffa')); //.prop('disabled', true);
// });

// Cambiare colore al click
// $('.cambiaColore').click(function () {
//     console.log('ciao');
//   // $(this).parent().find('.childDiv').css('background-color', 'rgba(138, 138, 138, 0.404)');
// }); --}}
