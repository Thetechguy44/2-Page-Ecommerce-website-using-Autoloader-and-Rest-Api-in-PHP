//saving product...
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', saveProduct);

    function validateNumber(input) {
        const value = parseFloat(input.value);
        if (isNaN(value)) {
            displayError(input, `Please, provide the data of indicated type`);
            return null;
        }
        return value;
    }

    function displayError(input, message) {
        const errorSpan = input.nextElementSibling;
        errorSpan.textContent = message;
    }

    const validationFunctions = {
        'book': (productData) => {
            productData.weight = validateNumber(document.querySelector('input[name="weight"]'), 'Weight');
        },
        'furniture': (productData) => {
            productData.height = validateNumber(document.querySelector('input[name="height"]'), 'Height');
            productData.width = validateNumber(document.querySelector('input[name="width"]'), 'Width');
            productData.length = validateNumber(document.querySelector('input[name="length"]'), 'Length');
        },
        'dvd': (productData) => {
            productData.size = validateNumber(document.querySelector('input[name="size"]'), 'Size');
        },
    };

    function saveProduct() {
        const productType = document.getElementById('productType').value;
        const skuInput = document.querySelector('input[name="sku"]');
        const nameInput = document.querySelector('input[name="name"]');
        const priceInput = document.querySelector('input[name="price"]');
        const productData = {
            sku: skuInput.value,
            name: nameInput.value,
            price: validateNumber(priceInput, 'Price'),
            productType,
        };

        if (!productData.sku || !productData.name || productData.price === null) {
            if (!productData.sku) {
                skuInput.classList.add('error');
                displayError(skuInput, 'Please, submit required data');
            }
            if (!productData.name) {
                nameInput.classList.add('error');
                displayError(nameInput, 'Please, submit required data');
            }
            if (productData.price === null) {
                priceInput.classList.add('error');
            }
            return;
        }

        if (validationFunctions[productType]) {
            validationFunctions[productType](productData);
        }

        fetch('product/saveApi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product saved successfully' || data.message === 'Product canceled successfully') {
                // Redirect to the specified URL
                window.location.href = data.redirect;
            } else {
                // Handle error case
                console.error(data.error);
            }
        })
        .catch(error => {
            // Handle errors
            console.error(error);
        });
    }
});
//end for saving product...


//display product from the getApi to the index page
document.addEventListener('DOMContentLoaded', function() {
    var productContainer = document.getElementById('product');
    
    // Create a map of product types to rendering functions
    var renderFunctions = {
        'dvd': function(products) {
            return `
                <div class="card"> 
                <div class="border-left border-right  p-0 pb-3">
                    <input type="checkbox" class="delete-checkbox" id="${products.id}">
                    <div class="text-center">
                    <h6>${products.sku}</h6>
                    <p> ${products.name}</p>
                    <p> ${products.price} $</p>
                    <p>Size: ${products.size} MB</p>
                    </div>
                </div>
                </div>
            `;
        },
        'book': function(products) {
            return `
                <div class="card"> 
                <div class="border-left border-right  p-0 pb-3">
                    <input type="checkbox" class="delete-checkbox" id="${products.id}">
                    <div class="text-center">
                    <h6>${products.sku}</h6>
                    <p> ${products.name}</p>
                    <p> ${products.price} $</p>
                    <p>Weight: ${products.weight} KG</p>
                    </div>
                </div>
                </div>
            `;
        },
        'furniture': function(products) {
            return `
                <div class="card"> 
                <div class="border-left border-right  p-0 pb-3">
                    <input type="checkbox" class="delete-checkbox" id="${products.id}">
                    <div class="text-center">
                    <h6>${products.sku}</h6>
                    <p> ${products.name}</p>
                    <p> ${products.price} $</p>
                    <p>Dimensions: ${products.height} x ${products.width} x ${products.length}</p>
                    </div>
                </div>
                </div>
            `;
        }
    };

    // Fetch product data from the API
    fetch('product/getApi.php')
        .then(response => response.json())
        .then(data => {
            // Loop through each product and create a box
            data.forEach(products => {
                var productBox = document.createElement('div');
                productBox.className = 'col-lg-3 col-md-6 col-sm-12 pb-1';
                
                // Use the render function based on the product type
                if (renderFunctions[products.productType]) {
                    productBox.innerHTML = renderFunctions[products.productType](products);
                } else {
                    console.error('Invalid product type:', products.productType);
                }
                
                productContainer.appendChild(productBox);
            });
        })
        .catch(error => console.error('Error fetching product data:', error));
});

//end for index desplay