@include('header')



    <!-- orders page-->

    <div class="container mt-2">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>My Orders</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                        <?php $j = 0; ?>
                            @foreach($orders as $orddtls) 
                            <div class="card border-primary mb-4">
                                <div class="card-header">
                                    Placed on: {{ $orddtls->order_date_time  }} <span>Payment: ${{ ($orddtls->ord_quantity  * $orddtls->ord_amount)  }}</span> <span>Price: ${{ $orddtls->ord_amount }}</span>
                                </div>
                                <div class="card-body">
                                    <p style="font-weight: 700;"><a href="{{ url('p/'.$orddtls->prod_id )}}" style="color:#000;"> {{ $orddtls->prod_title  }}</a></p>
                                    <!-- <p><a href="/track/{{ $orddtls->ord_tracking_id }}/{{ $orddtls->ord_tracking_no }}" class="btn btn-primary float-right" style="border-radius: 5px !important; margin-top: -40px;"><i class="fas fa-map-marker-alt"></i> Track</a></p> -->
                                    <p style="font-weight: 400;">Quantity: {{ $orddtls->ord_quantity }} @if( $orddtls->ord_variation != '') <span>Variation: {{ $orddtls->ord_variation  }}</span> @endif <br />
                                        <p style="margin-top:-15px; font-weight: 500;">Order ID: <span class="badge badge-info"></span>{{ $orddtls->ord_uniq_id }}</span></p>
                                    <p style="margin-top:-15px;">Seller Name: <span style="font-weight: 700;">Bescrow</span> </p>
                                    <p style="margin-top:-15px;">Product condition: <span class="badge bg-info">{{ $orddtls->prod_cndtn }}</span></p>
                                    
                                    
                                    <p style="font-weight: 500;">Delivery address: {{ $orddtls->ord_delivery_add }}</p>
                                    
                                </div>
                            </div>
                            <?php $j++; ?>
                            @endforeach


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
            </div>
        </div>
    </div>






    @include('footer')


