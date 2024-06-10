@extends('admin.main')

@section('content')

<div class="container-fluid py-4">
    <!---div class="col-xl-3 col-sm-6 mb-xl-0 mb-4"-->
        <div class="card z-index-2 ">
            <div class="card-body">
                <div class="row">
                    <form action="{{ route('categories.store') }}" id="category_form" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name"
                                placeholder="category name" name="name">
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name">Upload image</label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="status" id="status" value="1">
                            <label class="form-check-label" for="status">status</label>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary mt-4 ">Create Category</button>
                    </form>
                </div>
            </div>
        </div>
    <!--/div-->
</div>
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        $('#category_form').submit(function(){
            var form = $('#category_form')[0];
            var data= new FormData(form);
            
            $.ajax({
                type: "Post",
                url: "{{ route('categories.store') }}",
                data: data,
                success: function(data){
                    alert('error');
                },
                error: function(response){
                    alert('error');
                    //document.write(response);
                }
            });
        });
    });
</script> -->
@endsection('content')