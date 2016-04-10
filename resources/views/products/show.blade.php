@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product[0]->name }}</h1>
        <div class="row">
            <div class="col-xs-12 col-sm-3 col-lg-2">
                <img src="{{ $product[0]->image }}" />
            </div>
            <div class="col-xs-12 col-sm-9 col-lg-10">
                {{ $product[0]->description }}
            </div>
        </div>
    </div>
@endsection
