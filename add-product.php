<?php 
    include 'templates/header.php';
?>
<body>
 <!-- Products Start -->
    <div class="container">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light pt-5">
          <div class=" navbar-collapse justify-content-between" id="navbarCollapse">
              <div class="navbar-nav mr-auto py-0">
                  <h1 class="m-0 display-5 font-weight-semi-bold">Product Add</h1>
              </div> 
              <div class="d-grid gap-2 d-md-block pt-3">
                  <a href="index.php" class="btn btn-primary">Products</a>
                  <button class="btn btn-danger" type="button">Cancel</button>
                  <!-- <button class="btn btn-success" type="submit" onclick="event.preventDefault(); document.getElementById('save-form').submit()">Save</button> -->
                  <button class="btn btn-success" type="submit" id="saveButton">Save</button>
              </div>
          </div>
      </nav>
      <hr>
        <div class="container-fluid pt-5">
             <div class="card pt-3">
             <div class="card-body"> 
               <div class="basic-form">
                <form id="save-form" action="api/saveApi.php" method="Post">
                    <div class="row mb-3">
                      <label for="sku" class="col-sm col-form-label">SKU:</label>
                      <div class="col-sm-11">
                        <input type="text" name="sku" class="form-control" id="sku">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="name" class="col-sm col-form-label">Name:</label>
                      <div class="col-sm-11">
                        <input type="text" name="name" class="form-control" id="name">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="price" class="col-sm col-form-label">Price:</label>
                      <div class="col-sm-11">
                        <input type="number" name="price" class="form-control" id="price">
                      </div>
                    </div>
          
                    <div class="row mb-3">
                        <label for="text" class="col-lg-2 col-form-label">Type Switcher:</label>
                            <select class="form-select form-select-lg mb-3" name="productType" aria-label=".form-select-lg example" value="Switcher" id="type-switcher">
                            <option selected value="Switcher">Type Switcher</option>
                            <option value="book">Books</option>
                            <option value="furniture">Furniture</option>
                            <option value="dvd">DVD</option>
                            </select>        
                    </div>

                        <div class="data-category" id="book" value="book">
                          <div class="row mb-3">
                            <label for="Size" class="col-sm col-form-label">Size: </label>
                            <div class="col-sm-11">
                              <input type="number" name="size" class="form-control" id="size" style="width: auto;">
                            </div>
                            <div class="text">
                              <P>Please provide size in mb.</P>
                            </div>
                          </div>
                        </div>
                        <div class="data-category" id="furniture" value="furniture">
                          <div class="row mb-3">
                            <div class="row mb-3">
                              <label for="height" class="col-sm col-form-label">Height: </label>
                              <div class="col-sm-11">
                                <input type="number" name="height" class="form-control" id="height" style="width: auto;">
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label for="Width" class="col-sm col-form-label">Width: </label>
                              <div class="col-sm-11">
                                <input type="number" name="width" class="form-control" id="width" style="width: auto;">
                              </div>
                            </div>
                            <div class="row mb-3">
                              <label for="length" class="col-sm col-form-label">Length: </label>
                              <div class="col-sm-11">
                                <input type="number" name="length" class="form-control" id="length" style="width: auto;">
                              </div>
                            </div>
                            <div class="text">
                              <P>Please provide dimension in H x W x L.</P>
                            </div>
                          </div>
                        </div>
                        <div class="data-category" id="dvd" value="dvd">
                          <div class="row mb-3">
                            <div class="row mb-3">
                              <label for="weight" class="col-sm col-form-label">Weight: </label>
                              <div class="col-sm-11">
                                <input type="number" name="weight" class="form-control" id="weight" style="width: auto;">
                              </div>
                            </div>
                            <div class="text">
                              <P>Please provide weight in kg.</P>
                            </div>
                           </div>
                      </div>
                 </form>
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