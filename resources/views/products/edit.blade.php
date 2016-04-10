@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Product
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Product Form -->
                    <form action="/products/{{ $product[0]->id }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="product-name" class="col-sm-3 control-label">Product</label>

                            <div class="col-sm-9">
                                <input type="text" name="name" id="product-name" class="form-control" value="{{ $product[0]->name }}">
                            </div>

                            <label for="product-description" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-9">
                                <input type="text" name="description" id="product-description" class="form-control" value="{{ $product[0]->description }}">
                            </div>

                            <label for="product-quantity" class="col-sm-3 control-label">Quantity</label>

                            <div class="col-sm-9">
                                <input type="text" name="quantity" id="product-quantity" class="form-control" value="{{ $product[0]->quantity }}">
                            </div>

                            <label for="product-available" class="col-sm-3 control-label">Available</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $product[0]->available }}" disabled="disabled">
                            </div>

                            <label for="product-image" class="col-sm-3 control-label">Product Image</label>

                            <div class="col-sm-9">
                                <input type="text" name="image" id="product-image" class="form-control" value="{{ $product[0]->image }}">
                            </div>
                        </div>

                        <!-- Add Product Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Update Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
