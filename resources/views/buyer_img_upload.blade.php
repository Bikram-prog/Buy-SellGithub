@include('header')



    <!-- orders page-->

    <div class="container mt-6" style="margin-top: 20px;">
        <div class="row text-center">
            <div class="col-md-12">
                <h4>Upload Profile Picture</h4>
                <hr />
            </div>
        </div>
        <div class="row">
            @include('buyeraccsidebar')
            <div class="col-md-8 form-box">
            <form action="/buyerprofilepic" method="post" enctype='multipart/form-data'>
     {{ csrf_field() }}
    <div class="form-group">
        <input type="file" name="file" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary" style="border-radius: 8px !important;">Upload</button>
   
</form>
<p>&nbsp;</p>

@foreach ($ProImage as $proimg)



    @if($proimg->seller_prfl_pic != '')                                                
    <img src="{{asset('images')}}/{{ $proimg->seller_prfl_pic }}" style="height:120px; width: 120px;" alt="">
    @endif

<hr>
<!-- cover-->

<h4>Upload cover picture</h4> <p style="font-weight: 600;">* Picture should be less than 1MB</p><hr>
<form action="/sellercoverpic" method="post" enctype='multipart/form-data'>
     {{ csrf_field() }}
    <div class="form-group">
        <input type="file" name="file" class="form-control">
    </div>
    
    <button type="submit" class="btn btn-primary" style="border-radius: 8px !important;">Upload</button>
</form>
<p>&nbsp;</p>

@foreach ($ProImage as $proimg)
                                                 
<img src="{{asset('images')}}/{{ $proimg->seller_cover_pic }}" class="img-fluid" style="max-height:312px; max-width: 820px;" alt="">

@endforeach


                
            </div>
           

@endforeach



        </div>

        
    </div>
    <p>&nbsp;</p>








    @include('footer')












  