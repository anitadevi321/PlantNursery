import axios from 'axios';
import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Define the function globally
function elementExistsById(id) {
    return document.getElementById(id) !== null;
}

function elementExistsByClass(className) {
    return document.querySelectorAll(`.${className}`).length > 0;
}

function displaydata(products, paginationHtml = null) {
    var products = products;
    var productContainer = document.getElementById('allproduct');
    productContainer.innerHTML = '';
    // Iterate through fetched products and update DOM
    for (var i = 0; i < products.length; i++) {
        var product = products[i];
        var imageUrl = `/upload_images/products/${product.image}`;
        var productHtml = `
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="single-product-area mb-50">
                    <div class="product-img">
                        <a href="#">
                            <img src="${imageUrl}" alt="${product.name}">
                        </a>
                    </div>
                    <div class="product-info mt-15 text-center">
                        <a href="/shopDetail/${product.id}">
                            <p>${product.name}</p>
                        </a>
                        <h6>$${product.price}</h6>
                    </div>
                </div>
            </div>
        `;
        productContainer.innerHTML += productHtml; // Append product HTML to container
    }
    if (paginationHtml !== null) {
        var paginationContainer = document.getElementById('paginationLinks');
        paginationContainer.innerHTML = paginationHtml;
        var paginationLinks = paginationContainer.querySelectorAll('a.page-link');

        paginationLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                fetchProducts(link.href);
            });
        });
    }
}
function fetchProducts(url) {
    axios.get(url)
        .then(function (response) {
            // console.log('Response data:', response.data.products.data);
            var products = response.data.products.data;
            var paginationHtml = response.data.paginationLinks;
            displaydata(products, paginationHtml);
        })
        .catch(function (error) {
            console.error('Error fetching data:', error);
        });
}

document.addEventListener('DOMContentLoaded', function () {

    // fetch all products
    if (elementExistsById('fetchAllProducts')) {
        document.getElementById('fetchAllProducts').addEventListener('click', function (event) {
            event.preventDefault();
            axios.get('/getproduct')
                .then(function (response) {
                    var products = response.data.AllProducts.data;
                    displaydata(products);
                })
                .catch(function (error) {
                    // Handle error
                    console.error('Error fetching data:', error);
                });
        });
    } else {
        console.log('Element with ID "fetchAllProducts" does not exist.');
    }

    // show session message for only 5 seconds
    if (elementExistsById('success-message')) {
        setTimeout(function () {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000); // 5000 milliseconds = 5 seconds
    }

    // if (elementExistsById('error')) {
    //     setTimeout(function () {
    //         var successMessage = document.getElementById('error');
    //         if (successMessage) {
    //             successMessage.style.display = 'none';
    //         }
    //     }, 5000); // 5000 milliseconds = 5 seconds
    // }

    //fetch product with filter
    if (elementExistsByClass('FetchProductWithFilter')) {
        var elements = document.getElementsByClassName('FetchProductWithFilter');
        Array.from(elements).forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                var value = element.getAttribute('value');

                axios.get(`/fetchProductWithFilter/${value}`)
                    .then(function (response) {
                        var products = response.data.products.data;
                        var paginationHtml = response.data.paginationLinks;
                        // console.log(products);
                        displaydata(products, paginationHtml);
                    })
                    .catch(function (error) {
                        console.log('Error fetching data:', error);
                    });
            });
        });
    }

    function check_qty(productId, qty){
        if(qty <= 8)
            {
                return true;
            }
            else{
                return false;
            }
    }


    if (elementExistsByClass('add')) {
        var addButtons = document.querySelectorAll('.add');
        addButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var parentDiv = this.parentElement;
                var qtyInput = parentDiv.querySelector('.qty-text');
                var productId = qtyInput.getAttribute('product_id');
                var qty = qtyInput.value;
                if(qty < 10)
                    {
                        var qty= parseInt(qty) + 1;
                        qtyInput.value = qty;

                        var result= check_qty(productId, qty);
                        if(result == false)
                            {
                                document.getElementById('error').innerHTML= "product out of stock";
                            }
                        console.log(result);
                    }
                    else{
                        document.getElementById('error').innerHTML= "product out of stock";
                    }
            });
        });
    }

    if (elementExistsByClass('sub')) {
        var addButtons = document.querySelectorAll('.sub');
        addButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var parentDiv = this.parentElement;
                var qtyInput = parentDiv.querySelector('.qty-text');
                var qty = qtyInput.value;
                if(qty > 1)
                    {
                        qtyInput.value = parseInt(qty) - 1;
                    }
            });
        });
    }
});


