@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <span class="form-control">
                            {{ $product->name }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <span class="form-control">
                            {{ $product->price }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="upc">UPC</label>
                        <span class="form-control">
                            {{ $product->upc }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="" width="250"
                            class="img-thumbnail">
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">GoBack</a>
                </div>
            </div>
        </div>
    </div>
@endsection
