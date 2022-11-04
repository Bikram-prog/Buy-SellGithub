@include('member_header')



    <!-- orders page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Add new address</h4>
                {{-- <hr /> --}}
            </div>
        </div>
        <div class="row">
            {{-- @include('buyeraccsidebar') --}}
            <div class="col-md-3"></div>
            <div class="col-md-6 form-box">
              <form action="/editmemberaddressaction" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Phone No</label>
                    <input type="text" name="phn_no" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_phn_no; ?>" placeholder="Enter your phone no" required>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="text" name="email" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_email; ?>" placeholder="Enter your e-mail" required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_address; ?>" placeholder="Enter your adrress" required>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_city; ?>" placeholder="Enter city name" required>
                </div>
                  
                <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" name="postcode" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_postcode; ?>" placeholder="Enter your postcode" required> 
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" value="<?php echo $Editaddress[0]->buyer_del_state; ?>" placeholder="Enter state name" required>
                </div>
                <div class="form-group">
                  <label>Country</label>
                  <input type="text" name="country" class="form-control" value="Australia" readonly>
              </div>
              <div class="form-group">
              <input type="hidden" value="<?php echo Crypt::decryptString($_COOKIE['MemberUserIds']); ?>" name="buyer_id">
              <input type="hidden" value="<?php echo $Editaddress[0]->buyer_del_id; ?>" name="buyer_delvry_add_id">
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" style="border-radius: 8px !important;">Save</button>
              </div>
            </form>
                
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>






    @include('member_footer')