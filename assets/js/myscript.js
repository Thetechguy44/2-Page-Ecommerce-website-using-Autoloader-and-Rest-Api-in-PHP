
//type switcher
document.addEventListener('DOMContentLoaded', function() {
    const typeSwitcher = document.getElementById('type-switcher');
    const contentItems = document.querySelectorAll('.data-category');
    
    typeSwitcher.addEventListener('change', () => {
        const selectedValue = typeSwitcher.value;
    
        contentItems.forEach((item) => {
        item.style.display = item.id === selectedValue ? 'block' : 'none';
        });
    });
    
    // Hide all content items initially
    contentItems.forEach((item) => {
        item.style.display = 'none';
    });  
});

//savving product...
document.addEventListener('DOMContentLoaded', function() {
    const saveButton = document.getElementById('saveButton');
    saveButton.addEventListener('click', saveProduct); 
    
    function saveProduct() {
        const sku = document.querySelector('input[name="sku"]').value;
        const name = document.querySelector('input[name="name"]').value;
        const priceInput = document.querySelector('input[name="price"]');
        const productType = document.getElementById('type-switcher').value;

        let weight = null;
        let height = null;
        let width = null;
        let length = null;
        let size = null;

        if (productType === 'book') {
            weight = parseFloat(document.querySelector('input[name="weight"]').value);
        } else if (productType === 'furniture') {
            height = parseFloat(document.querySelector('input[name="height"]').value);
            width = parseFloat(document.querySelector('input[name="width"]').value);
            length = parseFloat(document.querySelector('input[name="length"]').value);
        } else if (productType === 'dvd') {
            size = parseFloat(document.querySelector('input[name="size"]').value);
        }

        const displayError = (input, message) => {
            const errorSpan = input.nextElementSibling; // Get the adjacent <span> element
            errorSpan.textContent = message;
        };

        const validateNumber = (input) => {
            const value = parseFloat(input.value);
            if (isNaN(value)) {
                displayError(input, `Please, provide the data of indicated type`);
                return null;
            }
            return value;
        };


        if (!sku || !name || !priceInput.value.trim()) {
            if (!sku) {
                document.querySelector('input[name="sku"]').classList.add('error');
                displayError(document.querySelector('input[name="sku"]'), 'Please, submit required data');
            }
            if (!name) {
                document.querySelector('input[name="name"]').classList.add('error');
                displayError(document.querySelector('input[name="name"]'), 'Please, submit required data');
            }
            if (!priceInput.value.trim()) {
                priceInput.classList.add('error');
                displayError(priceInput, 'Please, submit required data');
            }
            return; // Prevent form submission
        }

        const price = validateNumber(priceInput);
        if (price === null) {
            return; // Prevent form submission
        }

        let isValid = true;

        if (productType === 'book') {
            weight = validateNumber(document.querySelector('input[name="weight"]'));
            isValid = isValid && weight !== null;
        } else if (productType === 'furniture') {
            height = validateNumber(document.querySelector('input[name="height"]'));
            width = validateNumber(document.querySelector('input[name="width"]'));
            length = validateNumber(document.querySelector('input[name="length"]'));
            isValid = isValid && height !== null && width !== null && length !== null;
        } else if (productType === 'dvd') {
            size = validateNumber(document.querySelector('input[name="size"]'));
            isValid = isValid && size !== null;
        }

        if (!isValid) {
            return; // Prevent form submission
        }

        const productData = {
            sku,
            name,
            price,
            productType,
            weight,
            height,
            width,
            length,
            size,
        };

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

//code to handle cancle request
document.addEventListener('DOMContentLoaded', function() {
    const cancelButton = document.getElementById('cancelButton');

    cancelButton.addEventListener('click', cancelProduct);

    function cancelProduct() {
        fetch('product/saveApi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'cancel'
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Product canceled successfully') {
                window.location.href = data.redirect;
            } else {
                console.error(data.error);
            }
        })
        .catch(error => {
            console.error(error);
        });
    }
});
//end for cancel request


//display product from the getApi to the index page
var productContainer = document.getElementById('product');
// Fetch product data from the API
fetch('product/getApi.php')
    .then(response => response.json())
    .then(data => {
        // Loop through each product and create a box
        data.forEach(products => {
            var productBox = document.createElement('div');
            productBox.className = 'col-lg-3 col-md-6 col-sm-12 pb-1';

            // Display product based on type
            if (products.productType === 'dvd') {
                productBox.innerHTML = `
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
            } else if (products.productType === 'book') {
                productBox.innerHTML = `
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
            } else if (products.productType === 'furniture') {
                productBox.innerHTML = `
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

            productContainer.appendChild(productBox);
        });
    })
    .catch(error => console.error('Error fetching product data:', error));
//end for index desplay


// code snippet for mass deletion request.
document.addEventListener('DOMContentLoaded', function () {
    const selectButton = document.getElementById('selectButton');
    const deleteButton = document.getElementById('deleteButton');

    selectButton.addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.delete-checkbox');
        checkboxes.forEach(function (checkbox) {
            checkbox.removeAttribute('disabled');
        });
        this.disabled = true;
        deleteButton.removeAttribute('disabled');
    });

    deleteButton.addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.delete-checkbox:checked');
        const productIds = Array.from(checkboxes).map(checkbox => checkbox.id);

        fetch('product/saveApi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ productIds: productIds }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Products deleted successfully') {
                // Reload the page after successful deletion
                location.reload();
            } else {
                // Handle error case
                console.error(data.error);
            }
        })
        .catch(error => {
            // Handle errors
            console.error(error);
        });
    });
});
//end for mass deletion
