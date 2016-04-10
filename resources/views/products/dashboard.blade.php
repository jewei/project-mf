@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="col-sm-offset-2 col-sm-8">
            <h1>Manage Products</h1>
            [<a href="/products/create">create new product</a>]

            @if(Session::has('message'))
                <p class="alert alert-info">{{ Session::get('message') }}</p>
            @endif

            <!-- Current Products -->
            @if (count($products) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Products
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped product-table">
                            <thead>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Available</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="table-text"><div>{{ $product->name }}</div></td>
                                        <td class="table-text"><div>{{ $product->quantity }}</div></td>
                                        <td class="table-text"><div>{{ $product->available }}</div></td>
                                        <td>
                                            <a href="/products/{{ $product->id }}/edit">Edit</a>
                                        </td>
                                        <td>
                                            <form action="/products/{{ $product->id }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}

                                                <button type="submit" id="delete-product-{{ $product->id }}" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
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
