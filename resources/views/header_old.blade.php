<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Easyasthat Shop - Online shopping experienceeee</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta name="_token" content="{{csrf_token()}}" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('frontend')}}/img/favicon.png">

    <!-- all css here -->
    <link rel="stylesheet" href="{{asset('frontend')}}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/animate.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/themify-icons.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/meanmenu.min.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/bundle.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/style.css">
    <link rel="stylesheet" href="{{asset('frontend')}}/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <script src="{{asset('frontend')}}/js/vendor/modernizr-2.8.3.min.js"></script>

    <link rel="stylesheet" href="{{asset('frontend')}}/css/jquery-ui.css">  
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">
        <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>

    <style type="text/css">
        .card-title {
            font-size: 14px !important;
        }
        .card-header {
            background: #fff;
            color: #000;
            font-weight: 700;
            font-size: 18px;

        }
        .carousel-inner {
            height: 300px !important;
        }
        .custom-col-5 {
            max-width: 20% !important;
        }
        .bg-light{
            background-color: #fff !important;
        }
        nav{
            height: 80px !important;
        }
    </style>
</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- header start -->
    
    <header>
  <nav class="navbar navbar-expand-md navbar-light fixed-top bg-light">
    <a class="navbar-brand" href="/"><img src="{{asset('frontend')}}/img/logo/logo.jpeg" style="width: 80px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav">
        

        
        <!-- Example single danger button -->
<div class="btn-group" style="margin-left: 30px;">
  <button style="cursor: pointer;" type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Categories
  </button>
  
  <div class="dropdown-menu">
    @foreach($category as $cat)
    <a class="dropdown-item" href="/category/{{ $cat->cate_id }}/{{ $cat->cate_title }}">{{$cat->cate_title}}</a>
     @endforeach
    
  </div>
</div>

      </ul>
      <form action="/searchaction" method="GET" class="form-inline mt-2 mt-md-0" style="margin-left: 30px;">
        <input style="width: 400px; border-radius: 2px;" name="search" class="form-control" type="text" placeholder="Search products..." aria-label="Search">
        <button style="height: 45px; border-radius: 2px;" class="btn btn-dark" type="submit"><i class="fas fa-search"></i></button>
      </form>
<ul class="navbar-nav mr-auto nav navbar-nav navbar-right" style="margin-left: 30px;">
    <li class="nav-item">
         @if (!Session::has('BuyerIds') && !Session::has('UserIds'))
        <a style="font-weight: 700;" href="/buyerlogin">Hello, Sign in</a>
         <li class="nav-item" style="margin-left: 20px;">
        <a class="btn btn-dark" style="font-weight: 700;" href="/buyersignup">Create free account</a>
        </li>

        <li class="nav-item" style="margin-left: 20px;">

        <a style="font-weight: 700;" href="/checkout"><i style="font-size: 22px; color: #000;" class="fas fa-shopping-cart"></i> </a>
        <span class="badge badge-danger">{{ \Cart::getTotalQuantity()}}</span>
        </li>
        @elseif (Session::has('BuyerIds'))
        <a style="font-weight: 700;" href="/buyerorders">Hello,{{Session::get('BuyerFullName')}}</a>
        <li class="nav-item" style="margin-left: 20px;">

        <a style="font-weight: 700;" href="/checkout"><i style="font-size: 22px; color: #000;" class="fas fa-shopping-cart"></i> </a>
        <span class="badge badge-danger">{{ \Cart::getTotalQuantity()}}</span>
        </li>
        
        @endif
    </li>
    
    
    
</ul>


    </div>
  </nav>
</header>

<main role="main" style="margin-top: 80px;">