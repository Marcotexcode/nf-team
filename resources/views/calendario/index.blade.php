@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex justify-content-center">
                    <a class="btn btn-primary my-2" href="{{ route('calendario.index', ["data" => $dataPrecedente]) }}"><i class="fas p-2 align-middle fa-arrow-left"></i></a>
                    <span class="text-center my-2 mx-5"><h2 class="text-capitalize">{{$nomeMese}} - {{$anno}}</h2></span>
                    <a class="btn btn-primary my-2" href="{{ route('calendario.index', ["data" => $dataSuccessiva]) }}"><i class="fas p-2 align-middle fa-arrow-right"></i></a>
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
                                        <td>{{$collaboratore->nome}}</td>
                                        @for ($i=1; $i <= $data->daysInMonth; $i++)
                                            <td scope="col" class="p-0">
                                                <div data-bs-toggle="modal"  id="pro" data-columns="3"  class="add  p-2 datiPres" data-bs-target="#modalePresenze">&nbsp;</div>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal -->
         <div class="modal fade" id="modalePresenze" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form  method="POST">
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
        <div data-bs-toggle="modal"  id="pro" data-columns="3"  class="add clicca  p-2 datiPres" data-bs-target="#modalePresenze">&nbsp;as</div>
        {{-- <div data-bs-toggle="modal"  id="pro" data-columns="3"  class="add clicca  p-2 datiPres" data-bs-target="#modalePresenze">&nbsp;as</div> --}}

        <script>
            let myElement = document.querySelectorAll('.clicca');

            myElement.addEventListener('click', function (event) {

                console.log("Hi! I  am a new Button.");
            });

            // myElement.addEventListener("click", clickMe);
            // function clickMe(){
            //     console.log("Hi! I  am a new Button.");
            // }
        </script>
    </div>
@endsection


{{-- //const article = document.querySelector('.datiPres');

//console.log(article.dataset.columns); --}}
