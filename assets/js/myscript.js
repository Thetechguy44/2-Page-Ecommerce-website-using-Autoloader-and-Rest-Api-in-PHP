
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
    const form = document.getElementById('save-form');
    const formData = new FormData(form);

    const jsonData = {
        action: action, // Include the action in the JSON data
    };

    formData.forEach((value, key) => {
        jsonData[key] = value;
    });

    fetch('api/saveApi.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(jsonData),
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

