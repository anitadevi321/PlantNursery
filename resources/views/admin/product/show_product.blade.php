@extends('admin.main')

@section('content')

<div class="container-fluid py-4">
    <!---div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"-->
    <div class="card z-index-2 ">
        <div class="card-body">
            <div class="row">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>sr.no</th>
                            <th>Category name</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $sr= 1;
                        @endphp
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $sr }}</td>
                            @if(isset($categoryNames[$product->category_id]))
                            <td>{{ $categoryNames[$product->category_id] }}</td>
                            @endif
                            
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->image }}</td>
                            @php
                            if($product->status == 1){
                            @endphp
                            <td class="text-success">Active</td>
                            @php
                            }else{
                            @endphp
                            <td class="text-danger">Inactive</td>
                            @php
                            }
                            @endphp
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td><a href="{{ route('showProductEdit', $product->id ) }}">Edit</a></td>
                            <td>
                                <a href="{{ route('product.destroy', $product->id) }}">Delete</a>
                            </td>
                        </tr>
                        @php
                        $sr++;
                        @endphp
                        <!-- Display other category properties as needed -->
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <!--/div-->
</div>
@endsection('content')