@extends('main')

@section('content')

<!-- ##### Breadcrumb Area Start ##### -->

<div class="breadcrumb-area">
    <!-- Top Breadcrumb Area -->
    <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center"
        style="background-image: url(img/bg-img/24.jpg);">

    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

@if(session('message'))
<div class="container">
    <div class="alert alert-success" id="success-message">
        {{ session('message' )}}
    </div>
</div>
@endif
<!-- ##### Breadcrumb Area End ##### -->

<!-- ##### Cart Area Start ##### -->
<div class="cart-area section-padding-0-100 clearfix">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cart-table clearfix">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Products</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Remove</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Coupon Discount -->
            <div class="col-12 col-lg-6">
                <div class="coupon-discount mt-70">
                    <h5>COUPON DISCOUNT</h5>
                    <p>Coupons can be applied in the cart prior to checkout. Add an eligible item from the booth of the
                        seller that created the coupon code to your cart. Click the green "Apply code" button to add the
                        coupon to your order. The order total will update to indicate the savings specific to the coupon
                        code entered.</p>
                    <form action="#" method="post">
                        <input type="text" name="coupon-code" placeholder="Enter your coupon code">
                        <button type="submit">APPLY COUPON</button>
                    </form>
                </div>
            </div>

            <!-- Cart Totals -->
            <div class="col-12 col-lg-6">
                <div class="cart-totals-area mt-70">
                    <h5 class="title--">Cart Total</h5>
                    <div class="subtotal d-flex justify-content-between">
                        <h5 id="totalItems">Subtotal(2 items)</h5>
                        <h5 id="totalPrice">$99.9</h5>
                    </div>
                    <div class="shipping d-flex justify-content-between">
                        <h5>Shipping</h5>
                        <div class="shipping-address">
                            <form action="#" method="post">
                                <select class="custom-select">
                                    <option selected>Country</option>
                                    <option value="1">USA</option>
                                    <option value="2">Latvia</option>
                                    <option value="3">Japan</option>
                                    <option value="4">Bangladesh</option>
                                </select>
                                <input type="text" name="shipping-text" id="shipping-text" placeholder="State">
                                <input type="text" name="shipping-zip" id="shipping-zip" placeholder="ZIP">
                                <button type="submit">Update Total</button>
                            </form>
                        </div>
                    </div>
                    <div class="total d-flex justify-content-between">
                        <h5>Total</h5>
                        <h5>$9.99</h5>
                    </div>
                    <div class="checkout-btn">
                        <a href="{{ route('checkout') }}" class="btn alazea-btn w-100">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection('content')