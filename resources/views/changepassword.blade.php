@include('header')



    <!-- orders page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Change Password</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8 form-box">
              <form action="/changepasswordaction" method="POST">
                {{ csrf_field() }}
                @if (Session::has('updatepas'))
                      <div class="alert alert-success">{{Session::get('updatepas')}}</div>
                @elseif (Session::has('errpas'))
                      <div class="alert alert-danger">{{Session::get('errpas')}}</div>
                @endif
                <div class="form-group">
                    <label>Enter Current Password</label>
                    <input type="password" name="pass" class="form-control" placeholder="Enter current password" required>
                </div>
                <div class="form-group">
                    <label>Enter New Password</label>
                    <input type="password" name="nwpass" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="form-group">
                    <label>Re-Enter New Password</label>
                    <input type="password" name="renwpass" class="form-control" placeholder="Re-enter new password" required>
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












  