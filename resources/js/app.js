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

function displaydata(products) {
    var products = products;
    var productContainer = document.getElementById('allproduct');
    productContainer.innerHTML = '';
    // Iterate through fetched products and update DOM
    products.forEach(function (product) {
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
    });
}


document.addEventListener('DOMContentLoaded', function () {

    // fetch all products
    if (elementExistsById('fetchAllProducts')) {
        document.getElementById('fetchAllProducts').addEventListener('click', function (event) {
            event.preventDefault();
            axios.get('/getproduct')
                .then(function (response) {
                    var products = response.data.AllProducts;
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

    if (elementExistsByClass('FetchProductWithFilter')) {
        var elements = document.getElementsByClassName('FetchProductWithFilter');
        Array.from(elements).forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                var value = element.getAttribute('value');
            
                    axios.get(`/fetchProductWithFilter/${value}`)
                        .then(function (response) {
                            var products = response.data.products;
                            displaydata(products);
                        })
                        .catch(function (error) {
                            console.log('Error fetching data:', error);
                        });
            });
        });
    }
});


