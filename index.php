<?php 
    include 'templates/header.php';
?>
<body>    
    <!-- Topbar Start -->
 <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light pt-5">
            <div class=" navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto py-0">
                    <h1 class="m-0 display-5 font-weight-semi-bold">Product List</h1>
                </div> 
                <div class="d-grid gap-2 d-md-block pt-3">
                    <a href="add-product.php" class="btn btn-primary">ADD PRODUCT</a>
                    <button class="btn btn-danger" id="selectButton">MASS DELETE</button>
                    <button type="button" class="btn btn-success" id="deleteButton" disabled>Apply</button>
                </div>
            </div>
        </nav>
        <hr>
    <!-- Topbar End -->

    <!-- Products Start -->
    
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2 display-5">Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3" id="product">
            
        </div>
    </div>
    <!-- Products End -->
    <?php 
    include 'templates/footer.php';
    ?>