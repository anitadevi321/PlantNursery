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
                            <th>Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        $sr= 1;
                        @endphp
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $sr }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                @if($category->image != '')
                                    <img src="{{ asset('upload_images/category/'.$category->image)}}" with="100px" height="100px">
                                @endif
                            </td>
                            @php
                            if($category->status == 1){
                            @endphp
                            <td class="text-success">Active</td>
                            @php
                            }else{
                            @endphp
                            <td class="text-danger">Inactive</td>
                            @php
                            }
                            @endphp

                            <td><a href="{{ route('showEditPage', $category->id ) }}">Edit</a></td>
                            <td>
                                <a href="{{ route('category.destroy', $category->id) }}">Delete</a>
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