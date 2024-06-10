@extends('admin.main')

@section('content')
@php
    $meta= json_decode($product->meta);
    $status = isset($product) && $product->status == 1 ? $product->status : 0;
@endphp
<div class="container-fluid py-4">
    <!---div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"-->
    <div class="card z-index-2 ">
        <div class="card-body">
            <div class="row">
                <form action="{{ route('EditProduct') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control @error('category') is-invalid @enderror" id="category"
                            name="category">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                            placeholder="category name" name="name" value="{{ $product->name }}">
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="image">Upload image</label>
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" value="{{ $product->price }}"><img src="{{ asset('upload_images/products/'.$product->image)}}" with="100px" height="100px">
                        @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control  @error('price') is-invalid @enderror" id="price"
                            placeholder="product price" name="price" value="{{ $product->price }}">
                        @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="number" class="form-control  @error('stock') is-invalid @enderror" id="stock"
                            placeholder="product stock" name="stock" value="{{ $product->stock }}">
                        @error('stock')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            placeholder="product description" row="3"
                            name="description" value="{{ $product->description }}">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                  
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror"
                            id="meta_description" placeholder="meta description" row="3"
                            name="meta_description" value="{{ $meta->meta_description }}">{{ old('description', $meta->meta_description) }}</textarea>
                        @error('meta_description')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta tile</label>
                        <input type="text" class="form-control  @error('meta_title') is-invalid @enderror"
                            id="meta_title" placeholder="meta title" name="meta_title" value="{{ $meta->meta_title}}">
                        @error('meta_title')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="status"
                        @if($status == 1) checked @endif
                        id="status" value="1">
                        <label class="form-check-label" for="status">status</label>
                    </div>
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-primary">Edit product</button>
                </form>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
@endsection('content')