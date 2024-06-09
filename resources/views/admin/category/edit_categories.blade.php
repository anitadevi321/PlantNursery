@extends('admin.main')

@section('content')

<div class="container-fluid py-4">
    <!---div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"-->
    <div class="card z-index-2 ">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('categories.update') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                            placeholder="category name" name="name" value="{{ $category->name}}">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name">Upload image</label>
                        <input type="file" name="image" id="image" value="{{ $category->image}}"
                            class="form-control @error('image') is-invalid @enderror"><img src="{{ asset('upload_images/category/'.$category->image)}}" with="100px" height="100px">
                        @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        @php
                        $status = isset($category) && $category->status == 1 ? $category->status : 0;
                        @endphp
                        <input type="checkbox" class="form-check-input" name="status" id="status" value="1"
                            @if($status==1) checked @endif>
                        <label class="form-check-label" for="status">Status</label>
                    </div>
                    <input type="hidden" name="cid" value="{{ $category->id}}">
                    <button type="submit" class="btn btn-primary">Edit Category</button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
@endsection('content')