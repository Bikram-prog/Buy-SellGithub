@include('header')

<style>
    .category-horizontal li {
      line-height: 30px;
      
    }
  
    .category-horizontal {
      padding-left: 0rem !important;
    }
  
    /*-- testimonial Section CSS --*/
  #testimonial {
      margin-top: 30px;
      padding: 30px 0px 20px;
      color: #fff;
      background-color: #283270;
  }
  #testimonial h2 {
      font-style: italic;
      color: #fff;
      font-size: 26px;
      text-align: center;
  }
  #testimonial .client-img {
      width: 80px;
      height: 80px;
      overflow: hidden;
      border: 3px solid #fff;
      margin: 0px auto;
      border-radius: 100%;
      position: absolute;
      left: 0px;
  }
  #testimonial .carousel-content {
      padding: 20px 0px 20px 100px;
      width: 70%;
      margin: 0 auto;
      position: relative;
  }
  #testimonial h3 {
      font-size: 17px;
      color: #fff;
      margin-bottom: 30px;
      font-style: italic;
      text-align: right;
  }
  #testimonial p {
      font-size: 15px;
  }
  #testimonial .client-img img {
      width: 100%;
  }
  #testimonial .carousel-control-prev,
  #testimonial .carousel-control-next {
      font-size: 36px;
  }
  
  @media (max-width: 576px) {
  #testimonial .carousel-content {
      padding: 20px 0px 20px 0px;
      width: 100%;
  }
  #testimonial .client-img {
      margin: 20px auto;
      position: static;
  }
  #testimonial h3, #testimonial p {
      text-align: center;
  }
  }
  /*-- End Testimonial Section CSS --*/
  
  
  .highlight {
    font-weight: bold !important;
    color: #E50F00 !important;
    font-size: 1.3rem;
  }
  
  .default-light {
    font-weight: 400 !important;
  }
  
  
    </style>

<div class="container">
    <div class="row mt-4">
      
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <a href="/website-review" target="_blank"><div class="card"  style="padding: 30px; border: 1px solid #5352ed;height: 80px;">
          <h4 style="font-size: 20px !important;
          text-align: center !important;
          color: #000000;
          font-weight: 700; font-family: Roboto;margin-top: 30px;" class="card-title2">Write A Review About <br>Buy & Sell?</h4>
        </a>
      </div>
        <div class="col-md-3"></div>
      </div>
    </div>


  <!-- Testimonials Section -->
  <section id="testimonial">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Customers Reviews</h2>
                </div>
            </div>
            <div class="col-12">
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                  {{-- <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                  
                    <div class="carousel-inner">
                        @php 
                        $i = 1;
                        @endphp
                        @foreach($webreview as $web)
                        <div class="carousel-item <?php echo ($i == 1 ? 'active' : ''); ?>">
                            <div class="carousel-content">
                                {{-- <div class="client-img"><img src="images/user-img-2.jpg" alt="Testimonial Slider" /></div> --}}
                                <p style="font-weight: 500;"><span class="badge bg-success">{{ $web->review_ratings }} <i class="fas fa-star"></i></span> <small></small></p>
                                <p><i>{{ $web->review_comments }}</i></p>
                                <!-- <h3><span>-</span> {{ $web->name }} <span>-</span></h3> -->
                            </div>
                        </div>
                        @php 
                        $i++;
                        @endphp
                        @endforeach
                        
              
                        
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End testimonials Section -->

<!-- Testimonials Section -->
<div style="height: 20px;">&nbsp;</div>
<section id="testimonial">
  <div class="container">
      <div class="row">
          <div class="col-12">
              <div class="section-title">
                  <h2>Testimonial</h2>
              </div>
          </div>
          <div class="col-12">
            @php 
              $tstmnl = DB::connection('mysql2')->table('testimonials')->where('status', '=', '1')->get();
            @endphp
              <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                
                
                  <div class="carousel-inner">
                    @php 
                    $i = 1;
                    @endphp
                    @foreach($tstmnl as $tst)
                    <div class="carousel-item <?php echo ($i == 1 ? 'active' : ''); ?>">
                        <div class="carousel-content">
                            <p style="font-weight: 500;"><span>{{ $tst->category }}</span> <small></small></p>
                            <p><i>{{ $tst->remarks }}</i></p>
                            
                            
                        </div>
                    </div>
                    @php 
                    $i++;
                    @endphp
                    @endforeach
                                                                          
                                                                          
                                                                          
                                                                          
            
                      
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
          </div>
      </div>
  </div>
</section>
<!-- End testimonials Section -->

@include('footer')