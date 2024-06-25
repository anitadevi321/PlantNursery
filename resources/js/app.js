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

    // check quantity
    async function check_qty(productId, qty) {
        try {
            const response = await axios.post('/check_qty', {
                productId: productId,
                qty: qty
            });
            return response.data; // Returning the response data directly
        } catch (error) {
            console.error(error);
            return null; // Return null in case of an error
        }
    }

    // update cart
    async function update_cart(productId, qty) {
        try {
            const response = await axios.post('/update_cart', {
                productId: productId,
                qty: qty
            });
            return response.data; // Return the response data directly
        } catch (error) {
            console.error(error);
            return null; // Return null in case of an error
        }
    }

    // increase product qty in cart
    if (elementExistsByClass('add')) {
        var addButtons = document.querySelectorAll('.add');
        addButtons.forEach(function (button) {
            button.addEventListener('click', async function () {
                var parentDiv = this.parentElement;
                var qtyInput = parentDiv.querySelector('.qty-text');
                var productId = qtyInput.getAttribute('product_id');
                var qty = parseInt(qtyInput.value) + 1;
                var errorElement = parentDiv.querySelector('.error');
    
                var result = await check_qty(productId, qty); // Wait for the result
                console.log(result.status);
                
                if (result && result.status === true && qty <= result.total) {
                    qtyInput.value = qty;
                    errorElement.innerHTML = ""; // Clear any previous error messages
    
                    try {
                        var updateResult = await update_cart(productId, qty);
                        //console.log(updateResult.totalItems) // Await the cart update response
                        if (updateResult && updateResult.status === true) {
                            document.getElementById('total_price').innerHTML = qty * updateResult.price;
                           document.getElementById('totalItems').innerHTML = 'Subtotal('+ updateResult.totalItems + 'items)';
                        } else {
                            console.error('Failed to update cart');
                        }
                    } catch (error){
                        console.error('Error updating cart', error);
                    }
                } else {
                    console.log("not available");
                    errorElement.innerHTML = `Only ${result.total} unit(s) allowed`;
                    errorElement.style.display = 'block';
                }
            });
        });
    }
    

    // decrease product quantity in cart
    if (elementExistsByClass('sub')) {
        var subButtons = document.querySelectorAll('.sub');
        subButtons.forEach(function (button) {
            button.addEventListener('click', async function () { // Make the event listener function async
                var parentDiv = this.closest('td');
                var qtyInput = parentDiv.querySelector('.qty-text');
                var productId = qtyInput.getAttribute('product_id');
                var qty = parseInt(qtyInput.value);
                var errorElement = parentDiv.querySelector('.error');

                if (qty > 1) {
                    var newQty = qty - 1;
                    qtyInput.value = newQty;
                    errorElement.style.display = 'none';
                    
                    var updateResult = await update_cart(productId, newQty); // Await the cart update response
                    if (updateResult && updateResult.status === true) {
                        document.getElementById('total_price').innerHTML = newQty * updateResult.price;
                        errorElement.innerHTML = ""; // Clear any previous error messages
                    } else {
                        errorElement.innerHTML = "Failed to update cart";
                    }
                }
            });
        });
    }

    // remove product from cart
    function removeProductFromCart(productId) {
        axios.post('/remove_product', {
            productId: productId
        })
            .then(function (response) {
                // Handle success
                console.log('Product removed successfully');
                window.location.href = '/cart';
                // Optionally, update the UI to reflect the removal
            })
            .catch(function (error) {
                // Handle error
                console.error('Failed to remove product', error);
            });
    }

    if (elementExistsByClass('remove_product')) {
        var removeButton = document.querySelectorAll('.remove_product');
        removeButton.forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                var productId = this.getAttribute('value');
                console.log(productId);
                removeProductFromCart(productId)
            });
        });
    }


    if (elementExistsById('addToCart')) {
        // Get the form element
        var form = document.getElementById('addToCart');

        // Attach event listener to the form
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var productId = parseInt(document.getElementById('product_id').getAttribute('value')); // id 
        
            axios.post('/add_to_cart', {
                productId: productId
            })
                .then(function (response) {
                    // Handle success
                    console.log(response);
                 
                    // Optionally, update the UI to reflect the removal
                })
                .catch(function (error) {
                    // Handle error
                    console.error('Failed to add product', error);
                });

        });
    }
});


