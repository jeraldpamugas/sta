@extends('layout')
 
@section('content')
<div class="row">
    <div class="col-sm-6">
        <div style="padding: 5px;" class="card">
            <h3>Pending Transactions</h3>
            <div class="card-body">
                <h5 class="card-title">Panel title</h5>
                <p class="card-text">Some quick example text to build on the panel title and make up the bulk of the panel's content.</p>
                <a class="card-link">Card link</a>
                <a class="card-link">Another link</a>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div style="padding: 5px;" class="card">
            <h3>Upcoming Transactions</h3>
            <div class="card-body">
                <h5 class="card-title">Panel title</h5>
                <p class="card-text">Some quick example text to build on the panel title and make up the bulk of the panel's content.</p>
                <p class="card-text">Some quick example text to build on the panel title and make up the bulk of the panel's content.</p>
                <p class="card-text">Some quick example text to build on the panel title and make up the bulk of the panel's content.</p>
                <p class="card-text">Some quick example text to build on the panel title and make up the bulk of the panel's content.</p>
                <a class="card-link">Card link</a>
                <a class="card-link">Another link</a>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <hr>
        <div class="card">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Cras justo odio</li>
              <li class="list-group-item">Dapibus ac facilisis in</li>
              <li class="list-group-item">Vestibulum at eros</li>
            </ul>
        </div>
    </div>
</div>
@endsection