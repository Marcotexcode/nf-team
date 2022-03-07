@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="nav d-block text-center">
                <a href="">
                    <button class="btn btn-primary text-white">indietro</button>
                </a>
                <span class="text-uppercase px-4">MARZO 2022</span>
                <a href="">
                    <button class="btn btn-primary text-white">avanti</button>
                </a>
            </div>
            <div class="my-5">
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
            <div class="table-responsive">
                <table class="table table-bordered text-center table-responsive calendario">
                    <thead>
                        <tr>
                            <th class="fixed-both bg-white">Coll</th>
                            <th class="fixed-td">mar 1</th>
                            <th class="fixed-td">mer 2</th>
                            <th class="fixed-td">gio 3</th>
                            <th class="fixed-td">ven 4</th>
                            <th class="fixed-td bg-danger">sab 5</th>
                            <th class="fixed-td bg-danger">dom 6</th>
                            <th class="fixed-td">lun 7</th>
                            <th class="fixed-td">mar 8</th>
                            <th class="fixed-td">mer 9</th>
                            <th class="fixed-td">gio 10</th>
                            <th class="fixed-td">ven 11</th>
                            <th class="fixed-td bg-danger">sab 12</th>
                            <th class="fixed-td bg-danger">dom 13</th>
                            <th class="fixed-td">lun 14</th>
                            <th class="fixed-td">mar 15</th>
                            <th class="fixed-td">mer 16</th>
                            <th class="fixed-td">gio 17</th>
                            <th class="fixed-td">ven 18</th>
                            <th class="fixed-td bg-danger">sab 19</th>
                            <th class="fixed-td bg-danger">dom 20</th>
                            <th class="fixed-td">lun 21</th>
                            <th class="fixed-td">mar 22</th>
                            <th class="fixed-td">mer 23</th>
                            <th class="fixed-td">gio 24</th>
                            <th class="fixed-td">ven 25</th>
                            <th class="fixed-td bg-danger">sab 26</th>
                            <th class="fixed-td bg-danger">dom 27</th>
                            <th class="fixed-td">lun 28</th>
                            <th class="fixed-td">mar 29</th>
                            <th class="fixed-td">mer 30</th>
                            <th class="fixed-td">gio 31</th>
                        </tr>
                        <tr>
                            <th>marco</th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                            <th class="fixed-td"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
