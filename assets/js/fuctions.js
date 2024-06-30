//type switcher
document.addEventListener('DOMContentLoaded', function () {
    const typeSwitcher = document.getElementById('productType');
    const contentItems = document.querySelectorAll('.data-category');
    
    // Function to add hidden text to the DOM
    function addHiddenText(text) {
        const existingHiddenText = document.getElementById('hiddenText');
        
        if (existingHiddenText) {
            existingHiddenText.remove();
        }

        const hiddenText = document.createElement('p');
        hiddenText.textContent = text;
        hiddenText.style.display = 'none';
        hiddenText.id = 'hiddenText';
        document.body.appendChild(hiddenText);
    }

    function updateContentVisibility(selectedValue) {
        contentItems.forEach((item) => {
            item.style.display = item.id === selectedValue ? 'block' : 'none';
        });
    }

    // Initial setup
    updateContentVisibility(typeSwitcher.value);

    // Event listener for product type change
    typeSwitcher.addEventListener('change', function () {
        const selectedProductType = this.value;

        // Update content visibility
        updateContentVisibility(selectedProductType);

        // Add hidden text based on the selected product type
        if (selectedProductType === 'book') {
            addHiddenText('NameTest000');
        } else if (selectedProductType === 'furniture') {
            addHiddenText('NameTest001');
        } else if (selectedProductType === 'dvd') {
            addHiddenText('NameTest002');
        }
    });
});

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