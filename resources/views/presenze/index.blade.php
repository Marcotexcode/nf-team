@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                @foreach ($mesi as $mese)
                    <div class="d-flex justify-content-center">
                        <a href="{{route('presenze.index', ["data" => $dataPrecedente])}}">a</a>
                        <span class="text-center mx-5"><h2 class="text-center">{{$mese}}</h2></span>
                        <a href="{{route('presenze.index', ["data" => $dataSuccessiva])}}">b</a>
                    </div>
                    <div class="row">
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
                                                <td scope="col">
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title {{$collaboratore->id}}</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{route('presenze.store', $collaboratore->id)}}" method="POST">
                                                                        @csrf
                                                                        <div class="form-group my-3">
                                                                        <label for="exampleInputEmail1">A partire da</label>
                                                                        <input type="date" name="data_inizio" class="form-control" id="exampleInputEmail1">
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleInputEmail1">Fino a</label>
                                                                            <input type="date" class="form-control" name="data_fine" id="exampleInputEmail1">
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleFormControlSelect1">Tipo di presenza</label>
                                                                            <select class="form-control" name="tipo_di_presenza" id="exampleFormControlSelect1">
                                                                            <option>1</option>
                                                                            <option>2</option>
                                                                            <option>3</option>
                                                                            <option>4</option>
                                                                            <option>5</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleInputEmail1">Luogo</label>
                                                                            <input type="text" class="form-control" name="luogo" id="exampleInputEmail1">
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleFormControlTextarea1">Descrizione libera:</label>
                                                                            <textarea class="form-control" name="descrizione" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleInputEmail1">Spese da rimborsare</label>
                                                                            <input type="number" class="form-control" name="spese_rimborso" id="exampleInputEmail1">
                                                                        </div>
                                                                        <div class="form-group my-3">
                                                                            <label for="exampleInputEmail1">Bonus gradimento clienti</label>
                                                                            <input type="number" class="form-control" name="bonus" id="exampleInputEmail1">
                                                                        </div>

                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">{{$collaboratore->id}}</button>
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

    </div>
@endsection
