@include('header')

<style>
    .table{
        background-color: #fff;
        padding: 10px;
        border-radius: 10px;
    }
    .table tr td{
        padding: 20px;
        font-size: 14px;
    }
    .btn-link{
        text-decoration: none;
        font-size: 14px;
        color: #273683;
    }
</style>

    <!-- orders page-->

    <div class="container mt-2">
        
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8">
              
                    <div class="row">
                        <div class="col-md-12">
                        
                            <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <td style="font-weight: 700;font-size: 18px;">Personal info</td>
                                    <td></td>
                                </tr>

                                <tr>
                                    <td style="font-weight: 700;">Name</td>
                                    <td><?php echo $users[0]->name; ?></td>
                                </tr>

                                <tr>
                                    <td style="font-weight: 700;">Account type</td>
                                    @if($users[0]->seller_comp_name != '')
                                    <td>Buyer & Seller</td>
                                    @else
                                    <td>Buyer</td>
                                    @endif
                                </tr>

                                
                                <tr>
                                    <td style="font-weight: 700;">Contact info</td>
                                    <td><span style="color: rgb(155, 155, 155); font-size: 13px;">E-mail address</span><br>
                                        <strong><?php echo $users[0]->email; ?></strong>
                                    </td>
                                
                               
                                </tr>

                                @if($users[0]->seller_comp_name != '')
                                <tr>
                                    <td></td>
                                    <td><span style="color: rgb(155, 155, 155); font-size: 13px;">Contact number</span><br>
                                        <strong><?php echo $users[0]->seller_contct_no; ?></strong>
                                    </td>
                                </tr>
                                @endif

                                @php
                                    $address= DB::Select("Select * From buyer_addresses Where buyer_del_add_buy_id = '".$users[0]->s_id."' AND make_primary = '1'");
                                @endphp

                                <tr>
                                    <td style="font-weight: 700;">Personal info</td>
                                    @if($users[0]->seller_comp_name != '')

                                    <td><span style="color: rgb(155, 155, 155); font-size: 13px;">Seller address</span><br>
                                        <strong>{{ $users[0]->seller_address }},{{ $users[0]->seller_city }},{{ $users[0]->seller_state }},{{ $users[0]->seller_postcode }},{{ $users[0]->seller_country }}</strong>
                                    </td>

                                    @else

                                    <td></td>
                                   
                                    @endif
                                </tr>

                                

                                <tr>
                                    <td></td>
                                    <td><span style="color: rgb(155, 155, 155); font-size: 13px;">Buying address</span><br>
                                        @if(count($address) > 0)
                                        <strong>{{ $address[0]->buyer_del_address }},{{ $address[0]->buyer_del_city }},{{ $address[0]->buyer_del_state }},{{ $address[0]->buyer_del_postcode }},{{ $address[0]->buyer_del_country }}</strong>
                                    @else
                                    <strong><p><a class="btn btn-link" href="/addbuyeraddress">Add a new address</a></p></strong>
                                    @endif
                                    </td> 
                                </tr>

                                
                            </table>

                        </div>
                            
                            


                           
            
                            
                            
                        </div>
                        
                    </div>
                
            </div>
        </div>
    </div>






    @include('footer')


