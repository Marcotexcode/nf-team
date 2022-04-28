@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crea utente</div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="{{route('collaboratore.store')}}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Nome</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="nome" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Cognome</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="cognome" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Telefono</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="telefono" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Città</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="citta" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Indirizzo</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="indirizzo" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Cap</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="CAP" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Intera giornata</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="intera_giornata" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Mezza giornata</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="mezza_giornata" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Giornata all'estero</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="giornata_estero" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Giornata di formazione propria</label>
                                <div class="col-md-6">
                                    <input id="name" type="number" class="form-control" name="giornata_formazione" value="">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Salva
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
