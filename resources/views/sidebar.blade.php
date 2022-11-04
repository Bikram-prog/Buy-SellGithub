<style type="text/css">
    .sidebar_a li {
        list-style: none;
        /*background: rgba(48, 51, 107,.1);*/
        margin-bottom: 10px;
        color: #222;
        padding: 5px;
        margin-top: 10px;
    }
    .sidebar_a li a {
        color: #fff;
        font-size: 15px;

    }
    .sidebar_a li a:hover {
        text-decoration: none;
    }
    .leftsidebar {
        background: #130f40; 
        padding: 0px; 
        color: #eee;
        min-height: 550px;
        
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



    
</style>

<div class=" leftsidebar">
  <a class="active" href="#home">All Products</a>
  <a href="/category/<?php echo $users[0]->prod_cate_id; ?>">Mobiles & Tablets</a>
  <a href="#news">Laptops</a>
  <a href="#contact">Clothing</a>
  <a href="#about">Gadgets</a>
  <a href="#about">Cameras</a>
</div>



<div class="col-md-2 leftsidebar">

        <div style="padding: 20px; border-bottom: 2px solid #fff;">
            <p style="color: #fff; font-size: 16px;"><i class="fas fa-user"></i> {{Session::get('UserFullName')}} (Seller)</p>

           @foreach($totalearning as $total)
            <p style="color: #fff; font-size: 14px;"><i class="fas fa-wallet"></i> Balance: ₱{{ $total->TotalIEarning  }}</p>
             
    @endforeach
            
            
            <p><a style="color: #fff; " href="#" class="btn btn-success btn-block"> Withdraw</a></p>
        </div>

            <ul class="sidebar_a">
                 <!-- <li class="active"><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li> -->
                <li><a href="/addproduct"><i class="fas fa-plus"></i> Add Product</a></li>
                <li class="active"><a href="/sellerdashboard"><i class="fab fa-product-hunt"></i> View Product</a></li>
                <li><a href="/orderhistory"><i class="fas fa-shopping-cart"></i> Orders History</a></li>
                <li><a href="/sellerpaymenthistory"><i class="far fa-money-bill-alt"></i> Payment History</a></li>
                <li><a href="/sellerlogout" style="color: rgba(235, 77, 75,1.0);">Logout</a></li>
              </ul>

        </div>
