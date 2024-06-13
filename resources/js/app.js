import axios from 'axios';
import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Define the function globally
function elementExistsById(id) {
    return document.getElementById(id) !== null;
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
});


// fetch product with category
window.FetchProductWithCategory = function (event, categoryId) {
    event.preventDefault();
    //console.log('Category ID:', categoryId);

    axios.get(`/fetchProductWithCategory/${categoryId}`)
        .then(function (response) {
            var products = response.data.ProductsWithCategory;
            displaydata(products);
        })
        .catch(function (error) {
            console.log('Error fetching data:', error);
        });
};


// fetch products with sorting
window.fetchwithsorting = function (event, value) {
    event.preventDefault();

    // for Alphabetically ascending order
    if (value === 'ascWithName') {
        axios.get(`/shop_sorting/${value}`)
            .then(function (response) {
                console.log(response.data);
                var products = response.data.ProductsWithSorting;
                displaydata(products);
            })
            .catch(function (error) {
                console.error('Error fetching data:', error);
            });
    }

    // for Alphabetically descending order
    if (value == 'descWithName') {
        axios.get(`/shop_sorting/${value}`)
            .then(function (response) {
                //console.log(response.data);
                var products = response.data.ProductsWithSorting;
                displaydata(products);
            })
            .catch(function (error) {
                console.error('Error fetching data:', error);
            });
    }

    // for Numarically Ascending order
    if (value == 'ascWithNumarically') {
        axios.get(`/shop_sorting/${value}`)
            .then(function (response) {
                var products = response.data.ProductsWithSorting;
                displaydata(products);
            })
            .catch(function (error) {
                console.log('Error fetching data:', error);
            });
    }

    // for Numarically descending order
    if (value == 'descWithNumarically') {
        axios.get(`/shop_sorting/${value}`)
            .then(function (response) {
                var products = response.data.ProductsWithSorting;
                var productContainer = document.getElementById('allproduct');
                productContainer.innerHTML = '';
                displaydata(products);
            })
            .catch(function (error) {
                console.log('Error fetching data:', error);
            });
    }
};
