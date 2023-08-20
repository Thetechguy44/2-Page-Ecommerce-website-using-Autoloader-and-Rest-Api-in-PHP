
// public/assets/script.js

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
    saveButton.addEventListener('click', saveProduct);
});

function saveProduct() {
    const sku = document.querySelector('input[name="sku"]').value;
    const name = document.querySelector('input[name="name"]').value;
    const price = parseFloat(document.querySelector('input[name="price"]').value);
    const productType = document.getElementById('type-switcher').value;

    let specialAttribute = null;

    if (productType === 'book') {
        specialAttribute = parseFloat(document.querySelector('input[name="size"]').value);
    } else if (productType === 'furniture') {
        const height = parseFloat(document.querySelector('input[name="height"]').value);
        const width = parseFloat(document.querySelector('input[name="width"]').value);
        const length = parseFloat(document.querySelector('input[name="length"]').value);
        specialAttribute = `H: ${height}, W: ${width}, L: ${length}`;
    } else if (productType === 'dvd') {
        specialAttribute = parseFloat(document.querySelector('input[name="weight"]').value);
    }

    const productData = {
        sku,
        name,
        price,
        productType,
        specialAttribute
    };

    fetch('api/saveApi.php', {
        method: 'POST',
        body: JSON.stringify(productData),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response (e.g., show success message or redirect)
        console.log(data.message);
    })
    .catch(error => {
        // Handle errors (e.g., show error message)
        console.error('Error:', error);
    });
}






// document.getElementById("selectButton").addEventListener("click", function() {
// const checkboxes = document.querySelectorAll('.delete-checkbox');
// checkboxes.forEach(function(checkbox) {
//     checkbox.removeAttribute('disabled');
// });
// this.disabled = true; // Disable the select button
// document.getElementById("deleteButton").removeAttribute('disabled'); // Enable the delete button
// });

// document.getElementById("deleteButton").addEventListener("click", function() {
// const checkboxes = document.querySelectorAll('.delete-checkbox:checked');

// checkboxes.forEach(function(checkbox) {
//     const listItem = checkbox.parentNode;
//     listItem.parentNode.removeChild(listItem);
// });
// });

