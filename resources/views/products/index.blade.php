@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">

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

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold text-danger">PRODUCTS</span>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#addProduct">
                            Add Product
                        </button>
                        <a href="#" class="btn btn-danger float-right mr-2" id="deleteAllSelected">Delete Selected</a>
                    </div>

                    <div class="card-body">

                        <table id="productTable" class="display" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="chkCheckAll" />
                                    </th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>UPC</th>
                                    <th>Change Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $product)
                                    <tr id="pid{{ $product->id }}">
                                        <td>
                                            <input type="checkbox" name="ids" class="checkBoxClass"
                                                value="{{ $product->id }}" />
                                        </td>
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->price }}</td>
                                        <td>{{ $product->upc }}</td>
                                        <td>
                                            <input data-id="{{ $product->id }}" class="toggle-class" type="checkbox"
                                                data-onstyle="success" data-offstyle="danger" data-toggle="toggle"
                                                data-on="Active" data-off="InActive"
                                                {{ $product->status ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">
                                                View
                                            </a>
                                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                                                Edit
                                            </a>
                                            <form class="btn" action="{{ route('products.destroy', $product->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="return confirm('Are you sure?')" type="submit"
                                                    class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Product Modal --}}
    @include('products.create')

@endsection
@push('custom_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endpush
@push('custom_js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
        $(function() {
            $('.toggle-class').change(function() {
                var status = $(this).prop('checked') == true ? 1 : 0;
                var product_id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: "{{ route('product.changeStatus') }}",
                    data: {
                        'status': status,
                        'product_id': product_id
                    },
                    success: function(data) {
                        console.log(data.success)
                    }
                });
            })
        });

        $(function(e) {
            $("#chkCheckAll").click(function() {
                $(".checkBoxClass").prop('checked', $(this).prop('checked'));
            })

            $("#deleteAllSelected").click(function(e) {
                e.preventDefault();
                var allIds = [];

                $("input:checkbox[name=ids]:checked").each(function() {
                    allIds.push($(this).val());
                });

                $.ajax({
                    url: "{{ route('products.deleteSelected') }}",
                    type: "DELETE",
                    data: {
                        _token: $("input[name=_token]").val(),
                        ids: allIds
                    },
                    success: function(response) {
                        $.each(allIds, function(key, val) {
                            $("#pid" + val).remove();
                        })
                        location.reload(true);
                    }
                })
            });

        });
    </script>
@endpush
