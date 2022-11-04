<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Roboto&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link href="css/style.css">
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" href="{{asset('frontend')}}/css/daterangepicker.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link href="https://unpkg.com/dropzone/dist/dropzone.css" rel="stylesheet"/>
   <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>

   <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2843148547180331"
     crossorigin="anonymous"></script>

    



    <title>Buy & Sell Online Shopping</title>

    <style>
      
        body {
          font-family: 'Roboto', sans-serif;
            background-color: #F3F5F6 !important;
            line-height: 22px;
            letter-spacing: 1.1px;
            margin-bottom: 300px !important;
        }
        .card-img-top {
          height: 250px !important;
          border-radius: 10px !important;
        }
        h1 {
          font-size: 26px;
        }
        #amount {
          width: 100%;
        }
        h1,h2,h3,h4,h5,h6 {
            color: #000000;
            font-family: 'Roboto', sans-serif;
        }
        li a {
            font-weight: 500;
            font-size: 15px;
            color: #000 !important;
        }

        .left-review{
          padding: 20px;
          background-color: #fff;
          border-radius: 5px;
          border: 1px solid #eee;
        }

        .prod-img {
          object-fit: cover;
          width: 100%;
        }

        .price {
            color: #000000;
            font-size: 24px;
            font-weight: bold;
        }

        .price_main {
          color: #000000;
            font-size: 32px;
            font-weight: bold;
            margin-top: 10px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 500;
        }

        .card-subtitle {
            font-size: 16px;
            color: rgb(168, 168, 168);
        }

        .card-group {
            box-shadow: 0px -1px 4px 1px #a9b4cc4d !important;
            border-radius: 10px 0px 0px 10px !important;
        }

        .card img {
            /* padding: 20px; */
        }

        .card-footer {
            background-color: #fff;
            border: none !important;
        }

        footer {
            background-color: #EBECED;
            
        }

        ul li {
            list-style: none;
        }

        ul li a {
            text-decoration: none;
            color: #000;
        }

        .btn-danger {
            background-color: #E50F00;
            border-color: #E50F00;
        }

        .btn-primary {
            background-color: #1F2C69;
            border-color: #1F2C69;
        }

        .card {
            border-radius: 10px;
            border: 1px solid rgb(233, 233, 233);
        }

        .round {
          border-radius: 10px !important;
        }


        .card {
          /* padding: 20px; */
          min-height: 164px !important;
    
  }

  a {
    text-decoration: none !important;
  }
  .fas-icon {
    color: #293A82;
    font-size: 65px !important;
    text-align: center !important;
  }
  .card-title2 {
    margin-top: 10px;
    text-align: center !important;
    font-size: 16px !important;
    color: #000000;
    font-weight: 700;
  }

  .box {
    height: 460px;
  }

  .csbtn {
    transform: rotate(90deg);
    position: fixed;
    right: -60px;
    top: 180px;
    z-index: 1000;
    background: #5EBA00;
    color: #fff;
    border: none;
}

.csbtn:hover {
    transform: rotate(90deg);
    position: fixed;
    right: -60px;
    top: 180px;
    z-index: 1000;
    background: #5EBA00;
    color: #fff;
    border: none;
}


.addbox {
  padding: 20px;
  background: #fff;
  margin-top: 20px;
  border-radius: 10px;
}
.form-group{
  padding: 10px;
}

.testimonialbtn {
          transform: rotate(90deg);
          position: fixed;
          top: 400px;
          right: -40px;
          z-index: 1000;
          font-weight: bold !important;
      }


        

        
    </style>

    
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-97T74E674K"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-97T74E674K');
</script>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #fff !important; ">
        <div class="container-xl">
          {{-- <a class="navbar-brand" href="/home"><img src="https://www.bescrow.world/images/logo.png"></a> --}}
          <a class="navbar-brand" href="/home"><img style="width: 100px;height: 100px;border-radius: 100px;" src="/images/bescrow.png"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Dropdown
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
              </li>
            </ul> -->
            <form class="d-flex" action="/searchaction" method="get" style="width: 60%; position: relative; margin-left: 10px;">
                <div class="dropdown" style="
                position: absolute;
                right: 40px;
                
                ">
                    <button style="text-decoration: none; color: #000; font-size: 15px;" class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
                      All Categories
                    </button>
                    @php
                        $category= DB::Select('Select * From category'); 
                    @endphp
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" style="height: 400px; overflow: auto;">
                    @foreach($category as $cat)

                    @if($cat->cate_id == '38')

                      <li><a onclick="return confirm('Are you 18+?')" class="dropdown-item" href="/category/{{ $cat->cate_id }}/<?php echo  $cat->cate_title; ?>">{{ $cat->cate_title }}</a></li>

                      @else

                      <li><a class="dropdown-item" href="/category/{{ $cat->cate_id }}/<?php echo  $cat->cate_title; ?>">{{ $cat->cate_title }}</a></li>

                      @endif
                      
                    @endforeach

                    
                    
                    </ul>
                  </div>

              <input class="form-control " type="search" value="<?php echo (isset($_GET['search']) ? $_GET['search'] : ''); ?>" name="search" placeholder="Search for products"  aria-label="Search" style="border: 2px solid #E50F00;
              border-radius: 6px 0px 0px 6px;
">
              <button class="btn btn-danger" type="submit" style="border-radius:  0px 6px 6px 0px; border: 1px solid #E50F00;"><i class="fas fa-search"></i></button>
            </form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            
            @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) =="cs@wwwmedia.world")
            <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="/addproduct">Sell</a>
                </li>
           
            @endif
                {{-- <li class="nav-item">
                  <a class="nav-link active" href="/watchlist">Wishlist</a>
                </li> --}}
            
                @if (!isset($_COOKIE['UserIds']))
                <li class="nav-item dropdown active">
                  <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Sign Up
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <li><a class="dropdown-item" href="/buyerlogin">Sign in</a></li>
                    <li><a class="dropdown-item" href="/buyersignup">Sign up</a></li>
                    <li><a class="dropdown-item" href="/memberlogin">Member's login</a></li>
                    
                  </ul>
                </li>
                @else

                <li class="nav-item dropdown active">
                  <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    My Account
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    <li><a class="dropdown-item" href="/buyerorders">My Orders</a></li>
                    <li><a class="dropdown-item" href="/myaccount">My Account</a></li>
                    @if(isset($_COOKIE['UserEmail']) && Crypt::decryptString($_COOKIE['UserEmail']) == "cs@wwwmedia.world" || Crypt::decryptString($_COOKIE['UserEmail']) == "mariz@bourne.me")
                    <li><a class="dropdown-item" href="/sellerdashboard">Seller Dashboard</a></li>
                    <li><a class="dropdown-item" href="/addproduct">Add New Product</a></li>
                    @endif
                    <li><a class="dropdown-item" href="/logout">Logout</a></li>
                    
                  </ul>
                </li>

                @endif
                
                <li class="nav-item">
                  <a class="nav-link active" href="/checkout" tabindex="-1"><i class="fas fa-shopping-cart"></i> {{ \Cart::getTotalQuantity()}} </a>
                </li>

                <li class="nav-item dropdown" style="background: #212529;
                border-radius: 25px;
                font-weight: bold;">
                  <a style="font-weight: 500; color: #fff !important;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-flag"></i> Australia
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    
                    
                    <li><a class="dropdown-item" href="https://ph.bescrow.world/home">Philippines</a></li>
                    <li><a class="dropdown-item" href="/coming-soon/India">India</a></li>
                    
                    
                  </ul>
                </li>

              </ul>
          </div>
        </div>
      </nav>


<!-------------------------------customer service ------------------------------->
<?php if(isset($_COOKIE['UserEmail'])) { ?>
{{-- <button onclick="loadChat('0', 'Customer support', 'customer@support.globallove', 'offline')" id="idd_0" type="button" class="btn btn-success btn-md csbtn d-none d-sm-block">Customer Support</button> --}}
{{-- Sumanta's CHAT CODE --}}

<?php
$cus_support= DB::connection('mysql2')->Select("SELECT * FROM users_chat_rooms WHERE room_from_id= '".Crypt::decryptString($_COOKIE['UserIds'])."' AND room_to_id= '0' AND room_status='1' AND room_key='bes'");
if(count($cus_support) > 0) {

?>




<div style="
position: fixed;
    background: red;
    border-radius: 25px;
    padding: 0px;
    width: 22px;
    height: 22px;
    right: 25px;
    top: 256px;
    z-index: 10000;
">
  <span style="
    color: #fff;
    font-weight: 700;
    margin-left: 6px;
  ">1</span>
</div>
<?php } ?>
<a href="/customersupport/#/cs-user/{{ Crypt::decryptString($_COOKIE['UserIds']) }}/{{ Crypt::decryptString($_COOKIE['UserEmail']) }}/bes" id="idd_0" class="btn btn-success btn-md csbtn d-none d-sm-block">Customer Support</a>
<?php } else { ?>
<button onclick="alert('You must sign in or signup as a Buy & Sell member before you can use this chat facility');" type="button" class="btn btn-success btn-md csbtn d-none d-sm-block">Customer Support</button>
<?php } ?>


<?php if(isset($_COOKIE['UserEmail'])) { ?>
  <a onclick="add_testimonial()" href="javascript:void(0)" class="btn btn-warning btn-sm testimonialbtn d-none d-sm-block active">Add Testimonial </a>
  <?php } else { ?>
  <button onclick="alert('You must sign in or signup as a Buy & Sell member before you can use this chat facility');" type="button" class="btn btn-warning btn-md testimonialbtn d-none d-sm-block">Testimonial</button>
  <?php } ?>

  