@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-12">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="{{ old('name', $product->name) }}"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                placeholder="Enter Name">
                            @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" value="{{ old('price', $product->price) }}"
                                class="form-control @error('price') is-invalid @enderror" name="price"
                                placeholder="Enter Price">
                            @error('price')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="upc">UPC</label>
                            <input type="text" value="{{ old('upc', $product->upc) }}"
                                class="form-control @error('upc') is-invalid @enderror" name="upc"
                                placeholder="Enter upc">
                            @error('upc')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label><br>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="" width="250"
                                class="img-thumbnail">
                            <input type="file" class="form-control pt-2 @error('image') is-invalid @enderror"
                                name="image" placeholder="Enter image">
                            @error('image')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <a href="{{ route('products.index') }}" class="btn btn-warning">GoBack</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
