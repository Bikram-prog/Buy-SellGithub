@include('member_header')

<div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>My Addresses</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            {{-- @include('buyeraccsidebar') --}}
            <div class="col-md-12">
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-12">
                        <p><a class="btn btn-primary btn-lg" href="/memberaddbuyeraddress" style="border-radius: 5px !important;"><i class="fas fa-plus"></i> Add new address</a></p>
                        @foreach($data as $add)
                        <form action="/memberprimaryadd" method="POST">
                        {{ csrf_field() }}
                        
                            <div class="card mb-4">
                                <div class="card-header">
                                    
                                </div>
                                <div class="card-body">
                                    
                                    
                                   
                                    <p style="font-weight: 500;">Delivery address: {{ $add->buyer_del_address  }},{{ $add->buyer_del_city  }},{{ $add->buyer_del_state  }}-{{ $add->buyer_del_postcode  }},{{ $add->buyer_del_country  }}</p>
                                    <p style="font-weight: 500;">Contact no: {{ $add->buyer_del_phn_no  }}</p>
                                    <p style="font-weight: 500;">E-mail: {{ $add->buyer_del_email  }}</p>
                                    @if($add->make_primary == "1")
                                    <p style="font-weight: 500; color:#686de0;">This is your primary address.</p>
                                    @elseif($add->make_primary == "0")
                                    <input type="hidden" name="delbuyadd" value="{{ $add->buyer_del_add_buy_id   }}">
                                    <input type="hidden" name="deladd" value="{{ $add->buyer_del_id   }}">
                                    <button type="submit" class="btn btn-outline-info float-right btn-sm" style="border-radius: 5px !important; margin-top: -5px;">Make This Delelivery Address</button>
                                    @endif

                                    <p>
                                        <a href="{{ url('membereditaddress/'.$add->buyer_del_id)}}" class="btn btn-clear-danger"><i style="color: #f9ca24; font-size: 16px;" class="fas fa-edit"></i></a>
                                        <a onclick="return confirmdelete()" href="{{ url('memberdeladdress/'.$add->buyer_del_id)}}" class="btn btn-clear-primary"><i style="color: #eb4d4b; font-size: 16px;" class="fas fa-trash"></i></a>
                                    </p>
                                </div>
                            </div>
                            
                        </form>
                        @endforeach


                           
            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>






<script type="text/javascript">
    function confirmdelete() {
        var win = window.confirm("Are you sure?");
        if(win) {
            return true;
        } else {
            return false;
        }
    }
</script>


@include('member_footer')