@extends('layouts.app')

@section('content')
    <div class="container">
        {{$collaboratore->id}}
        <form>
            <div class="form-group">
              <label for="exampleInputEmail1">A partire da</label>
              <input type="date" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Fino a</label>
                <input type="date" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Tipo di presenza</label>
                <select class="form-control" id="exampleFormControlSelect1">
                  <option>1</option>
                  <option>2</option>
                  <option>3</option>
                  <option>4</option>
                  <option>5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Luogo</label>
                <input type="text" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Descrizione libera:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Spese da rimborsare</label>
                <input type="number" class="form-control" id="exampleInputEmail1">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Bonus gradimento clienti</label>
                <input type="number" class="form-control" id="exampleInputEmail1">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
