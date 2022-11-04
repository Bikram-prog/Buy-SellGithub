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
{{-- <script async src="https://www.googletagmanager.com/gtag/js?id=G-97T74E674K"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-97T74E674K');
</script> --}}
  </head>
  <body>

   

    {{-- <div class="container mt-4">
      <div class="row">
          <div class="col-md-12 text-center">
              <h2 style="font-weight: bold; font-size: 22px; margin-bottom: 20px;">Member's Area &nbsp;&nbsp; <a href="/memberlogout" class="btn btn-danger">Logout</a></h2>
              
              <h4>Minimum of 3</h4> --}}


              <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #fff !important; ">
                <div class="container-xl">
                  {{-- <a class="navbar-brand" href="/home"><img src="https://www.bescrow.world/images/logo.png"></a> --}}
                  <a class="navbar-brand" href="/home"><img style="width: 100px;height: 100px;border-radius: 100px;" src="/images/bescrow.png"></a>
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    
                    <h2 style="margin: 0 auto;" class="text-center">Members Area</h2>
        
                     
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    
                    
                        
                      
                        
                        
                        <li class="nav-item">
                          <a class="nav-link active" href="/membercheckout" tabindex="-1"><i class="fas fa-shopping-cart"></i> {{ \Cart::getTotalQuantity()}} </a>
                        </li>

                        <li class="nav-item">
                          <a class="btn btn-danger" href="/memberlogout" style="color: #fff !important;">Logout</a>
                        </li>
        
                       
        
                      </ul>
                  </div>
                </div>
              </nav>

