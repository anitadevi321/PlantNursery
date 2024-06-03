<!DOCTYPE html>
<html lang="en">

<head>
   
@include('frontend.include.header_scripts')

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div>
    <!-- ##### Header Area Start ##### -->
    @include('frontend.include.header')
        <!-- ##### Header Area End ##### -->


    @yield('content')



   <!-- ##### Contact Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    @include('frontend.include.footer')
    <!-- ##### Footer Area End ##### -->

    <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    @include('frontend.include.footer_scripts')
</body>

</html>