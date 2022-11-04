<style type="text/css">
	.sidebar_a {
		padding: 10px;
	}
    .sidebar_a li {
        list-style: none;
        /*background: rgba(48, 51, 107,.1);*/
        margin-bottom: 10px;
        color: #222;
        padding: 5px;
        margin-top: 10px;
    }
    .sidebar_a li a {
        color: #000;
        font-size: 15px;

    }
    .sidebar_a li a:hover {
        text-decoration: none;
    }
    .leftsidebar {
        background: #fff; 
        padding: 0px; 
        color: #000;
        min-height: 550px;
        margin-top: 2px;
        
    }

    .btn-mb-full {
        width: 100%;
        font-size: 14px;
        font-weight: bold;
        letter-spacing: 1.4px;
        padding: 5px;
        height: 40px;
    }

    

    input,select,a {
        height: inherit !important;
        border-radius: 1px !important;
    }

    button:hover {
        color: inherit !important;
    }

    .btn-success {
    	border-radius: 25px !important;
    	color: #fff !important;
    }



    
</style>

<div class="col-md-2 leftsidebar">

        <div style="padding: 20px; border-bottom: 2px solid #eee;">
            <p style="color: #000; font-size: 16px;"><i class="fas fa-user"></i> {{Session::get('UserFullName')}} (Seller)</p>

           @foreach($totalearning as $total)
            <p style="color: #000; font-size: 14px;"><i class="fas fa-wallet"></i> Balance: ${{ $total->TotalIEarning  }}</p>
             
    @endforeach
            
            
            
        </div>

            <ul class="sidebar_a">
                 <!-- <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li> -->
                <li><a class="btn btn-success btn-block" href="/addproduct"><i class="fas fa-plus"></i> Add Product</a></li>
                <li class="active"><a href="/sellerdashboard"><i class="fab fa-product-hunt"></i> View Product</a></li>
                <!-- <li><a href="/sellerprofile"><i class="fas fa-plus"></i> Seller Profile</a></li> -->
                <li><a href="/orderhistory"><i class="fas fa-shopping-cart"></i> Orders History</a></li>
                <!-- <li><a href="/sellerpaymenthistory"><i class="far fa-money-bill-alt"></i> Pending Product Payment</a></li> -->
                <li><a href="/pendingdelivery"><i class="fas fa-shopping-cart"></i> Pending Delivery Orders</a></li>
                <li><a href="/sellercomission"><i class="fas fa-percentage"></i> Product Comissions</a></li>
                <li><a href="/selleraddbankdtls"><i class="fas fa-wallet"></i> Bank Details</a></li>
                <li><a href="/sellerwithdraw"><i class="fas fa-wallet"></i> Withdraw Funds</a></li>

                <li><a href="/sellerlogout" style="color: #eb4d4b; font-weight: 700;">Logout</a></li>
              </ul>

        </div>