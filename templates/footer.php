
    <!-- Template Javascript -->
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/myscript.js"></script>

    <!-- script for type switcher -->
    <!-- <script>
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
    </script> -->
    
    <!-- script for mass deletion -->
    <script>
        document.getElementById("selectButton").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('.delete-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.removeAttribute('disabled');
        });
        this.disabled = true; // Disable the select button
        document.getElementById("deleteButton").removeAttribute('disabled'); // Enable the delete button
        });

        document.getElementById("deleteButton").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('.delete-checkbox:checked');

        checkboxes.forEach(function(checkbox) {
            const listItem = checkbox.parentNode;
            listItem.parentNode.removeChild(listItem);
        });
        });
    </script>
</body>

</html>