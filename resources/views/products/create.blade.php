@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create New Product
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->
                    @include('common.errors')

                    <!-- New Product Form -->
                    <form action="/products" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="product-name" class="col-sm-3 control-label">Product</label>

                            <div class="col-sm-9">
                                <input type="text" name="name" id="product-name" class="form-control" value="{{ old('name') }}">
                            </div>

                            <label for="product-description" class="col-sm-3 control-label">Description</label>

                            <div class="col-sm-9">
                                <input type="text" name="description" id="product-description" class="form-control" value="{{ old('description') }}">
                            </div>

                            <label for="product-quantity" class="col-sm-3 control-label">Quantity</label>

                            <div class="col-sm-9">
                                <input type="text" name="quantity" id="product-quantity" class="form-control" value="{{ old('quantity') }}">
                            </div>

                            <label for="product-image" class="col-sm-3 control-label">Product Image</label>

                            <div class="col-sm-9">
                                <input type="text" name="image" id="product-image" class="form-control" value="{{ old('image') }}">
                            </div>
                        </div>

                        <!-- Add Product Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Add Product
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
