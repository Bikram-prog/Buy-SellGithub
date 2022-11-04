@include('header')

<style>
.loginbox{
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: -1px 1px 20px 2px #eaeaea;
}
</style>

  <div class="container-xl mt-4">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4 text-center loginbox">
                <h6 class="mb-3" style="font-weight: bold; font-size: 2.2rem; letter-spacing: 2.4px;">Member's Login</h6>
                
                @if (Session::has('regsucmsg'))
                <div class="alert alert-success">{{Session::get('regsucmsg')}}</div>
                @endif
                @if (Session::has('errrmessage'))
                        <div class="alert alert-danger">{{Session::get('errrmessage')}}</div>
                @endif

                <form action="/memberloginaction" method="POST">
                {{ csrf_field() }}
                    <div class="form-group mb-2">
                    <input type="text" name="email" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group mb-2">
                    <input type="password" name="psw" id="inputPassword" class="form-control" placeholder="Password" required>
                    </div>
                    
                    <div class="d-grid gap-2 col-6 mx-auto">
                    <button onclick="return validation();" type="submit" class="btn btn-danger mt-4">Log in</button>
                    </div>
                    

                    
                </form>

            </div>
            <div class="col-md-4"></div>
        </div>
      </div>

 @include('footer')