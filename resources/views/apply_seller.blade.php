@include('header')



    <!-- orders page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Apply as a seller</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8 form-box">
              <form action="/sellerinfopost" method="POST">
                {{ csrf_field() }}
                @if (Session::has('updatepas'))
                      <div class="alert alert-success">{{Session::get('updatepas')}}</div>
                @elseif (Session::has('errpas'))
                      <div class="alert alert-danger">{{Session::get('errpas')}}</div>
                @endif
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" name="comp_name" class="form-control" placeholder="Enter your company name." required>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" placeholder="Enter your address." required>
                </div>
                <div class="form-group">
                    <label>State</label>
                    <input type="text" name="state" class="form-control" placeholder="Enter your state" required>
                </div>
                <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" class="form-control" placeholder="Enter your city." required>
                </div>
                <div class="form-group">
                    <label>Postcode</label>
                    <input type="text" name="postcode" class="form-control" placeholder="Enter your postcode." required>
                </div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" name="cntct_no" class="form-control" placeholder="Enter your contact number." required>
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="Australia" class="form-control" placeholder="Enter your city." readonly>
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












  