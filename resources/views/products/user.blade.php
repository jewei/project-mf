@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="col-sm-offset-2 col-sm-8">

            <h1>My Enrollment</h1>

            <!-- Current Products -->
            @if (count($products) > 0)
                <div class="panel panel-default">

                    <div class="panel-body">
                        <table class="table table-striped product-table">
                            <thead>
                                <th>Product</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td class="table-text"><div>{{ $product->product_name }}</div></td>
                                        <td class="table-text"><div>{{ $product->status }}</div></td>
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
