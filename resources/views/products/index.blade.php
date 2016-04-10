@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Session::has('message'))
            <p class="alert alert-info">{{ Session::get('message') }}</p>
        @endif
        <div class="row">
            @if (count($products) > 0)
                @foreach ($products as $product)
                    <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                {{ $product->name }}
                            </div>

                            <div class="panel-body" style="text-align: center;">
                                <div>
                                    <img
                                        src="{{ $product->image }}"
                                        alt="{{ $product->name }}"
                                        data-src="holder.js/160x212"
                                        data-holder-rendered="true"
                                        style="width: 160px; height: 212px;"
                                        />
                                </div>
                                <div style="height: 100px">
                                    {{ $product->description }}
                                </div>
                                <form action="/enroll/{{ $product->id }}" method="POST">
                                    {{ csrf_field() }}
                                    <button
                                        type="submit"
                                        id="put-product-{{ $product->id }}"
                                        class="btn btn-primary"
                                        >
                                        <i class="fa fa-btn fa-plus"></i>
                                        Enroll
                                        &nbsp;&nbsp;<span class="badge">{{ $product->available }}</span>
                                    </button>
                                </form>
                                <div style="font-size: 0.78em;color: #666;">
                                    ( {{ $product->available }} units available )
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
