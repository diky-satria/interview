@extends('layout.app2')

@section('title')
home
@endsection

@section('content')
<div class="row mb-4">
    <div class="col">
        <h5>List Produk</h5>
    </div>
</div>
<div class="row">
    @foreach($data as $d)
    <div class="col-md-3 mb-4">
        <div class="card auth-card">
            <div class="card-body">
                <h6>{{ $d->name }}</h6>
                <h6>{{ format_rupiah($d->price) }}</h6>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection