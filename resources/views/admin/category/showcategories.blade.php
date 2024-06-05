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
                            <td>{{ $category->image }}</td>
                            <td><a href="{{ route('showEditPage', $category->id ) }}">Edit</a></td>
                            <td>
                                <a href="{{ route('category.destroy', $category->id) }}">Delete</a>
                            <!-- <form method="POST" action="{{ route('category.destroy', $category->id) }}">
                            @csrf

                            <x-dropdown-link :href="route('category.destroy', $category->id)"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </form> -->
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