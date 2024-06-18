@extends('main')

@section('content')

<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
    <!-- Top Breadcrumb Area -->
    <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center"
        style="background-image: url(../img/bg-img/24.jpg);">
        <h2>Shop</h2>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Shop</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ##### Breadcrumb Area End ##### -->

<!-- ##### Shop Area Start ##### -->
<section class="shop-page section-padding-0-100">
    <div class="container">
        <div id="data"></div>
        <div class="row">
            <!-- Sidebar Area -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="shop-sidebar-area">
                    <!-- Shop Widget -->
                    <div class="shop-widget catagory mb-50">
                        <h4 class="widget-title">Categories</h4>
                        <div class="widget-desc">
                            <!-- Single Checkbox -->
                            <div id="data"></div>
                            <div class="custom-control custom-checkbox d-flex align-items-center mb-2"
                                style="padding-left:0px">
                                <!-- <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1"></label> -->
                                <a href="" id="fetchAllProducts">All
                                    plants</a><span class="text-muted">{{ $AllProductCount }}</span>
                            </div>
                            @foreach($category_with_product as $item)
                            @if($item['product_count'] > 0)
                            <div class="custom-control custom-checkbox d-flex align-items-center mb-2"
                                style="padding-left:0px">
                                <!-- Ensure each checkbox has a unique ID by appending the category ID -->
                                <!-- <input type="checkbox" class="custom-control-input" id="cid{{ $item['category']->id }}"
                                    name="cid[]" value="{{ $item['category']->name }}">
                                <label class="custom-control-label" for="cid{{ $item['category']->id }}"> -->
                                <a href="" class="FetchProductWithFilter"
                                    value="{{ $item['category']->id}}">{{ $item['category']->name }}</a>
                                <span class="text-muted">({{ $item['product_count'] }})</span>
                                </label>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Shop Widget -->
                    <div class="shop-widget sort-by mb-50">
                        <h4 class="widget-title">Sort by</h4>
                        <div class="widget-desc">
                            <!-- Single Checkbox -->
                            <!-- <div class="custom-control custom-checkbox d-flex align-items-center mb-2">
                                <input type="checkbox" class="custom-control-input" id="customCheck7">
                                <label class="custom-control-label" for="customCheck7">New arrivals</label>
                            </div> -->
                            <!-- Single Checkbox -->
                            <div class="custom-control custom-checkbox d-flex align-items-center mb-2" style="padding-left:0px">
                                <a href="" class="FetchProductWithFilter" value="ascWithName">Alphabetically, A-Z</a>
                            </div>
                            <!-- Single Checkbox -->
                            <div class="custom-control custom-checkbox d-flex align-items-center mb-2" style="padding-left:0px">
                                <a href="" class="FetchProductWithFilter" value="descWithName">Alphabetically,
                                    Z-A</a>
                            </div>
                            <!-- Single Checkbox -->
                            <div class="custom-control custom-checkbox d-flex align-items-center mb-2" style="padding-left:0px">
                                <a href="" class="FetchProductWithFilter" value="ascWithNumarically">Price: low to
                                    high</a>
                            </div>
                            <!-- Single Checkbox -->
                            <div class="custom-control custom-checkbox d-flex align-items-center" style="padding-left:0px">
                                <a href="" class="FetchProductWithFilter" value="descWithNumarically">Price: high to
                                    low</a>
                            </div>
                        </div>
                    </div>

                    <!-- Shop Widget -->
                    <div class="shop-widget best-seller mb-50">
                        <h4 class="widget-title">Best Seller</h4>
                        <div class="widget-desc">

                            <!-- Single Best Seller Products -->
                            <div class="single-best-seller-product d-flex align-items-center">
                                <div class="product-thumbnail">
                                    <a href="shop-details.html"><img src="img/bg-img/4.jpg" alt=""></a>
                                </div>
                                <div class="product-info">
                                    <a href="shop-details.html">Cactus Flower</a>
                                    <p>$10.99</p>
                                    <div class="ratings">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Best Seller Products -->
                            <div class="single-best-seller-product d-flex align-items-center">
                                <div class="product-thumbnail">
                                    <a href="shop-details.html"><img src="img/bg-img/5.jpg" alt=""></a>
                                </div>
                                <div class="product-info">
                                    <a href="shop-details.html">Tulip Flower</a>
                                    <p>$11.99</p>
                                    <div class="ratings">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Best Seller Products -->
                            <div class="single-best-seller-product d-flex align-items-center">
                                <div class="product-thumbnail">
                                    <a href="shop_details.html"><img src="img/bg-img/34.jpg" alt=""></a>
                                </div>
                                <div class="product-info">
                                    <a href="shop-details.html">Recuerdos Plant</a>
                                    <p>$9.99</p>
                                    <div class="ratings">
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Products Area -->
            <div class="col-12 col-md-8 col-lg-9">
                <div class="shop-products-area">
                    <div class="row" id="allproduct">

                        <!-- Single Product Area -->

                        @foreach($AllProducts as $products)
                        <div class="col-12 col-sm-6 col-lg-4">
                            <div class="single-product-area mb-50">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <a href="shop-details.html"><img
                                            src="{{ asset('upload_images/products/'.$products->image)}}" alt=""></a>
                                    <!-- Product Tag -->
                                    <div class="product-tag">
                                        <a href="#">Hot</a>
                                    </div>
                                    <div class="product-meta d-flex">
                                        <a href="#" class="wishlist-btn"><i class="icon_heart_alt"></i></a>
                                        <a href="cart.html" class="add-to-cart-btn">Add to cart</a>
                                        <a href="#" class="compare-btn"><i class="arrow_left-right_alt"></i></a>
                                    </div>
                                </div>
                                <!-- Product Info -->
                                <div class="product-info mt-15 text-center">
                                    <a href="{{ route('shop_details', $products->id) }}">
                                        <p id="product_name">{{ $products->name }}</p>
                                    </a>
                                    <h6 id="product_price">${{ $products->price}}</h6>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->

                    <div class="d-flex justify-content-center custom-pagination" id="paginationLinks">
                        {{ $AllProducts->links() }}
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection('content')