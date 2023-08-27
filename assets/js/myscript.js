
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

    const saveButton = document.getElementById('saveButton');
    const cancelButton = document.getElementById('cancelButton');

    saveButton.addEventListener('click', () => saveProduct('save')); 
    cancelButton.addEventListener('click', () => saveProduct('cancel')); 
});

function saveProduct(action) { // Accept action parameter
    const sku = document.querySelector('input[name="sku"]').value;
    const name = document.querySelector('input[name="name"]').value;
    const price = parseFloat(document.querySelector('input[name="price"]').value);
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

    const productData = {
	    action: action,
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


// code snippet for mass deletion.
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

