@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">2 fattori</div>
                    <div class="card-body">
                        <form action="/user/two-factor-authentication" method="POST">
                            @csrf
                            {{-- Quando l'autenticazione a due fattori e abilitata --}}
                            @if (auth()->user()->two_factor_secret)
                                <div>
                                    {{-- In questo modo vedo il codice qr --}}
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>
                                <div class="py-4">
                                    <h3>Codici Di Recupero</h3>
                                    <ul>
                                        @foreach (auth()->user()->recoveryCodes() as $codiceRecupero)
                                            <li>{{$codiceRecupero}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            @else
                                <button class="btn btn-primary">Abilitare</button>
                            @endif
                        </form>
                        {{-- Confermare che il codice qr e stato abilitato inserendo il codice per proseguire  --}}
                        @if (auth()->user()->two_factor_secret)
                            <div>
                                <form method="POST" action="{{ route('two-factor.confirm') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="code" class="col-md-4 col-form-label text-md-end">Inserire codice a sei cifre</label>
                                        <div class="col-md-6 d-flex">
                                            <input id="code" type="code" class="form-control @error('code') is-invalid @enderror" name="code" required autocomplete="current-code">
                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <button type="submit" class="btn btn-primary mx-3">
                                                {{ __('Invio') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @if (session('status') == 'two-factor-authentication-confirmed')
                                <div class="mb-4 font-medium text-sm alert alert-success">
                                    Il tuo codice a 6 cifre e corretto
                                </div>
                            @else
                                <div class="mb-4 font-medium text-sm alert alert-danger">
                                    Inserire codice a 6 cifre per continuare
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
