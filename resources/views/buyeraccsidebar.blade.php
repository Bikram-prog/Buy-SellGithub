<style>
.left-sidebar {
  /* border: 1px solid #ccc !important; */
  padding-left: 0px !important;
  padding-right: 0px !important;
  border-radius: 10px!important;
}

.active_sell {
  background: #283171;
  
}

.active_sell a {
  color: #fff !important;
}
  </style>

        <div class="col-md-3 left-sidebar">

                <form action="" method="get">
                    
                    <div class="card" style="border-radius: 10px;">
                        <!-- <div class="card-header">
                          Categories
                        </div> -->
                        <ul class="list-group list-group-flush" style="border-radius: 10px !important;">
                          <!-- <li class="list-group-item"><a href="" style="color: #000;">My account</a></li> -->
                          <!-- <li class="list-group-item"><a href="" style="color: #000;">My Wishlist</a></li> -->
                          <!-- <li class="list-group-item"><a href="/buyerorders" style="color: #000;">My orders</a></li>
                          <li class="list-group-item"><a href="/manageaddress" style="color: #000;">My addresses</a></li>
                          <li class="list-group-item"><a href="/changepassword" style="color: #000;">Change password</a></li>
                          <li class="list-group-item"><a href="/buyersettings" style="color: #000;">Settings</a></li>
                          <li class="list-group-item"><a href="/logout" style="color: #000;">Logout</a></li> -->
                          
                          @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world" || Crypt::decryptString($_COOKIE['UserEmail']) == "mariz@bourne.me")
                          <li class="list-group-item"><a href="/sellerdashboard" style="color: #000;"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                          @endif
                          

                          <li class="list-group-item"><a href="/home" style="color: #000;"><i class="fas fa-shopping-cart"></i> Buying</a></li>

                          @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world" || Crypt::decryptString($_COOKIE['UserEmail']) == "mariz@bourne.me")
                          <li class="list-group-item">
                          <a class="" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Selling <i class="fas fa-angle-down"></i>
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            
                            <li><a class="dropdown-item" href="/selleractiveproduct">Active</a></li>
                            {{-- <li><a class="dropdown-item" href="/sellerinactiveproduct"> Inactive</a></li> --}}
                            <li><a class="dropdown-item" href="/selleralldraftproduct"> Draft</a></li>
                            <li><a class="dropdown-item" href="/sellersoldproduct"> Sold</a></li>
                            
                            
                          </ul>
                        </li>
                        @endif

                        @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world" || Crypt::decryptString($_COOKIE['UserEmail']) == "mariz@bourne.me")
                          <li class="list-group-item active_sell"><a href="/addproduct" style="color: #000;font-weight: 700;font-size: 18px;"><i class="fas fa-shopping-basket"></i> Add New Product</a></li>
                          @endif
                          <li class="list-group-item"><a href="/buyerorders" style="color: #000;"><i class="fas fa-shopping-bag"></i> Bought</a></li>
                          @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world" || Crypt::decryptString($_COOKIE['UserEmail']) == "mariz@bourne.me")
                          <li class="list-group-item"><a href="/orderhistory" style="color: #000;"><i class="fas fa-check-circle"></i> Sold</a></li>
                          @endif
                          <li class="list-group-item"><a href="/manageaddress" style="color: #000;"><i class="fas fa-map-marked-alt"></i> Address</a></li>
                          @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world")
                          <li class="list-group-item active_sell"><a href="/sellercomission" style="color: #000;font-weight: 700;font-size: 18px;"><i class="fas fa-hand-holding-usd"></i> Selling Comissions</a></li>
                          @endif
                          <li class="list-group-item"><a href="/myaccount" style="color: #000;"><i class="fas fa-user"></i> My account</a></li>
                          <li class="list-group-item"><a href="/changepassword" style="color: #000;"><i class="fas fa-unlock-alt"></i> Change password</a></li>
                          <li class="list-group-item"><a href="/buyersettings" style="color: #000;"><i class="fas fa-cog"></i> Settings</a></li>
                          <li class="list-group-item"><a href="/logout" style="color: #E50F00 !important; font-weight: 600;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                      </div>
                      
                      
                      
                </form>
            </div>