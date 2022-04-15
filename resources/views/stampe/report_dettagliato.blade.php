@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row my-5 no_print_display">
            <div class="col text-center">
                <h3>Da qui puoi generare il report dettagliato </h3>
                <form class="my-3" action="{{route('filtroReportDettagliato')}}" method="POST">
                    @csrf
                    <h5 class="d-inline">Scegli il mese: </h5>
                    <input type="month" name="meseAnno" value="{{$filtroMese}}">
                    <button class="btn btn-primary">
                        CONFERMA
                    </button>
                </form>
            </div>
        </div>
        <div class="row no_print_display">
            <div class="col">
                <button onclick="window.print()" class="btn btn-primary"><i class="fa-solid fa-print"></i> Stampa</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{-- Modificare passandogli il nome del mese in italiano e non il numero --}}
                <h4 class="text-center mb-4">Report dettagliato del mese di {{$meseTesto}}</h4>
            </div>
        </div>
       <div class="row">
           <div class="col">
               <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nominativo</th>
                            <th scope="col">Data</th>
                            <th scope="col">Tipo di presenza</th>
                            <th scope="col">Luogo</th>
                            <th scope="col">Descrizione</th>
                            <th scope="col">Prezzo unitario</th>
                            <th scope="col">Spese da rimborsare</th>
                            <th scope="col">Bonus gradimento clienti</th>
                            <th scope="col">Totale importo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presenze as $presenza)
                            <tr>
                                <th scope="row">{{$presenza->collaboratori->nome}}</th>
                                <th scope="row">{{$presenza->data}}</th>
                                <th scope="row">{{$presenza->tipo_di_presenza}}</th>
                                <th scope="row">{{$presenza->luogo}}</th>
                                <th scope="row">{{$presenza->descrizione}}</th>
                                <th scope="row">
                                    @if ($presenza->importo > 0)
                                        € {{$presenza->importo}}
                                    @else
                                        € 0.00
                                    @endif
                                </th>
                                <th scope="row">
                                    @if ($presenza->spese_rimborso)
                                        € {{$presenza->spese_rimborso}}
                                    @else
                                        € 0.00
                                    @endif
                                </th>
                                <th scope="row">
                                    @if ($presenza->bonus)
                                        € {{$presenza->bonus}}
                                    @else
                                        € 0.00
                                    @endif
                                </th>
                                <th scope="row">€ {{number_format($presenza->importo + $presenza->spese_rimborso + $presenza->bonus,2)}}</th>
                            </tr>
                        @endforeach
                    </tbody>
               </table>
           </div>
       </div>
    </div>
@endsection
