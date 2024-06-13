import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Define the function globally
function elementExistsById(id) {
    return document.getElementById(id) !== null;
}


document.addEventListener('DOMContentLoaded', function() {
    if (elementExistsById('fetchAllProducts')) {
        document.getElementById('fetchAllProducts').addEventListener('click', function(event) {
            event.preventDefault();
            axios.get('/getproduct')
                .then(function (response) {
                    // Handle successful response
                    console.log(response.data.AllProducts);  
                    var products= response.data.AllProducts;
                    var productall;
                    var productContainer = document.getElementById('allproduct');
                    productContainer.innerHTML='';
                    for(let i=0; i<products.length; i++)
                        {
                          var productHtml= `
                          <div class="col-12 col-sm-6 col-lg-4" >
                            <div class="single-product-area mb-50">
                                <!-- Product Image -->
                                <div class="product-img">
                                    <a href="shop-details.html"><img
                                            src="{ asset('upload_images/products/'.${products[i].image})}" alt="${products[i].name}"></a>
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
                                        <p id="product_name">${products[i].name}</p>
                                    </a>
                                    <h6 id="product_price">$${products[i].price}</h6>
                                </div>
                            </div>
                        </div>
                          `;
                          productContainer.innerHTML += productHtml;
                            //document.getElementById('product_name').innerHTML= products[i]['name'];
                        }
                    // });
                    console.log(productall);
                    //document.getElementById('product_name').innerHTML= productall;
                    
                })
                .catch(function (error) {
                    // Handle error
                    console.error('Error fetching data:', error);
                });
        });
    } else {
        console.log('Element with ID "fetchAllProducts" does not exist.');
    }
});