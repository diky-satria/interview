@extends('layout.app2')

@section('title')
dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="back">
            <div class="front front-produk">
                <h6>Produk</h6>
                <div class="d-flex justify-content-between">
                    <h5>{{ $count }}</h5>
                    <a href="{{ url('produk') }}">Lihat</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection