@include('header')



    <!-- orders page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Add new address</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8 form-box">
              <form action="/edituserloginaction" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Phone No</label>
                    <input type="text" name="phn_no" class="form-control" placeholder="Enter your phone no" required>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter your e-mail" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Enter your adrress" required>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="Enter city name" required>
                </div>
                  
                <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" name="postcode" class="form-control" placeholder="Enter your postcode" required> 
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" placeholder="Enter state name" required>
                </div>
                <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" class="form-control" value="Australia" readonly>
              </div>
              <div class="form-group">
                <input type="hidden" value="<?php echo Crypt::decryptString($_COOKIE['UserIds']); ?>" name="buyer_id">
              </div>
                <button type="submit" class="btn btn-primary" style="border-radius: 8px !important;">Save</button>
            </form>
                
            </div>
        </div>
    </div>






    @include('footer')












    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
        crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>