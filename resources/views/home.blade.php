@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2 class="text-center">
                    Benvenuto
                    @if (Auth::user())
                        {{Auth::user()->name}}
                    @else
                        anonimo
                    @endif
                </h2>
            </div>
        </div>
    </div>
@endsection
