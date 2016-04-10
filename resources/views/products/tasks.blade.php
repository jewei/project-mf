@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="col-sm-offset-2 col-sm-8">
            <h1>Moderation</h1>

            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            <!-- Current Products -->
            @if (count($products) > 0)
                <div class="panel panel-default">

                    <div class="panel-body">
                        <table class="table table-striped product-table">
                            <thead>
                                <th>Username</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="table-text"><div>{{ $product->user_name }}</div></td>
                                        <td class="table-text"><div>{{ $product->product_name }}</div></td>
                                        <td class="table-text"><div>{{ $product->status }}</div></td>
                                        <td>
                                            <form action="/moderate/approved/{{ $product->user_id }}/{{ $product->product_id }}" method="POST">
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fa fa-btn fa-check-square"></i>Approve
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <form action="/moderate/rejected/{{ $product->user_id }}/{{ $product->product_id }}" method="POST">
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Reject
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
