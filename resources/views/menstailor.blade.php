@include('header')
<style>
  .ul li{
    list-style:none;
    margin-left:15px;
    float:left;
    margin-bottom:15px;
  }
  .ul li a{
    color:#4834d4;
    font-weight:700;
    text-decoration:none;
  }
  .cus-img img {
    object-fit: cover;
    width: 100%;
    height: 200px;
  }

  .highlight {
    border: 4px solid #4834D4;
    border-radius: 10px !important;
  }
</style>
        <!-- seller CTA-->
    


    <!-- category page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>{{ $catetitle }}</h4>
                <hr />
            </div>
            <div class="col-md-12">
              <ul class="ul">
                <li>{{ $catetitle }} >> </li>
                @foreach($subcategory as $sub)
                <li><a href="/subcategory/{{ $sub->sub_cate_id }}/{{ $sub->sub_cate_title }}">{{ $sub->sub_cate_title }}</a></li>
                @endforeach
              </ul>
              <br>
              <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 left-sidebar">

                <form action="" method="get">
                    
                   
                      
                      
                      <div class="card mt-2" style="">
                        <div class="card-header">
                          Filter
                        </div>
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'New' ? 'checked' : ''); ?> name="condition[]" type="checkbox" value="New" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  New
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'Used' ? 'checked' : ''); ?>
                                name="condition[]" type="checkbox" value="Used" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Used
                                </label>
                              </div>
                              <hr>
                              <div class="form-price-range-filter">
                                <label for="amount">Price range:</label>
                                <input type="text" id="amount" name="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                              <div id="slider-range"></div>
                              
                              </div>
                              <hr>
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="out" checked value="Out" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                  Exclude Out Of Stock
                                </label>
                              </div>
                              <button style="border-radius: 4px !important;" type="submit" class="mt-2 btn btn-dark btn-block">Filter</button>
                        </div>
                        
                      </div>
                      
                </form>
            </div>
            <div class="col-md-8">
            <div class="row text-center cus-img">
            <div class="col-md-4">
                <img src="{{asset('images')}}/menstailor1.jpeg" class="img-fluid">
            </div>
            <div class="col-md-4">
                <img src="{{asset('images')}}/menstailor3.jpeg" class="img-fluid highlight">
            </div>
            <div class="col-md-4">
                <img src="{{asset('images')}}/menstailor2.jpeg" class="img-fluid">
            </div>
            <div class="col-md-12 mt-4">
                <h2>Welcome to Little John’s Tailor online shop</h2>
                    <p>Specialising in Custom suits and accessories for the man wanting the finer things in life without breaking the bank doing it.<br>
                    These items are made in Thailand from your measurements you supply and shipped to your door by DHL within’ 7 working days of your purchase.<br><br>
                    <strong>You can talk to John direct about special alterations.</strong></p>
            </div>
            
            </div>

                
                
      
 

              <nav aria-label="Page navigation example" class="mt-2">
                <ul class="pagination justify-content-center">
                <?php  
                $links = "";
                for ($i = 1; $i <= $totalPages; $i++) {
                  $links .= ($i != $page ) ? "<li class='page-item'><a class='page-link' href='?page=$i'> $i</a> </li>" : "<li class='page-item active' aria-current='page'><span class='page-link'>$page <span class='sr-only'>(current)</span></span></li>";
                }

                echo $links;
                ?>
                </ul>
              </nav>
            </div>
        </div>
    </div>

    <div class="container card sell mt-4">
      <div class="row card-body">
          <div class="col-md-6">
              <img src="{{asset('frontend')}}/imgs/sell.svg" class="img-fluid">
          </div>
          <div class="col-md-6">
              <div class="ml-6" style="margin-top: 70px;
              margin-left: 70px;">
                  <h2>Sell On Bescrow From Today</h2>
                  <p style="font-weight: 700;">No fees, Only $1 for Selling Product First Time</p>
                  <a href="/seller" class="btn btn-primary btn-lg crow-btn">Start Selling</a>
              </div>
              
          </div>
      </div>
  </div>

    @include('footer')