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
                    <a href="add-product.php" class="btn btn-primary">Add Product</a>
                    <button class="btn btn-danger" id="selectButton">Mass Delete Action</button>
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
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card"> 
                    <div class="border-left border-right  p-0 pb-3">
                        <input type="checkbox" class="delete-checkbox" name="" id="">
                        <div class="text-center">
                            <h6 class="text-truncate mb-3"><b>SKV:</b>1234567890</h6>
                            <p><b>Model:</b>Olympus E-450</p>
                            <div class="d-flex justify-content-center">
                                <h6>$105.00</h6>
                            </div>
                            <h6><b>Weight:</b>4.5KG</h6>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card"> 
                    <div class="border-left border-right  p-0 pb-3">
                        <input type="checkbox" class="delete-checkbox" name="" id="">
                        <div class="text-center">
                            <h6 class="text-truncate mb-3"><b>SKV:</b>1234567890</h6>
                            <p><b>Model:</b>Merrel</p>
                            <div class="d-flex justify-content-center">
                                <h6>$155.00</h6>
                            </div>
                            <h6><b>Size:</b>35cm</h6>
                        </div>  
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card"> 
                    <div class="border-left border-right  p-0 pb-3">
                        <input type="checkbox" class="delete-checkbox" name="" id="">
                        <div class="text-center">
                            <h6 class="text-truncate mb-3"><b>SKV:</b>1234567890</h6>
                            <p><b>Model:</b>Red Oak Chair</p>
                            <div class="d-flex justify-content-center">
                                <h6>$105.00</h6>
                            </div>
                            <h6><b>Dimension:</b>24*45*15</h6>
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->
    <?php 
    include 'templates/footer.php';
    ?>