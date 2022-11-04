@include('header')
<style type="text/css">
	.btn-danger {
        border-radius: 25px;
        font-size: 18px;
        width: 200px;
    }
</style>
<div class="container-fluid">
    <div class="row">

@include('sellersidebar')

<div class="col-md-10" style="margin-top: 30px;">
<div class="row" style="margin-bottom: 20px;">

<div class="container text-center mt-4">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <h4>Upload cover picture</h4> <p style="font-weight: 600;">* Picture should be less than 1MB</p><hr>
            <form action="/sellercoverpic" method="post" enctype='multipart/form-data'>
                 {{ csrf_field() }}
                <div class="form-group">
                    <input type="file" name="file" class="form-control">
                </div>
                
                <button type="submit" class="btn btn-primary btn-block" style="border-radius: 8px !important;">Upload</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row mt-4">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="row">
            @foreach ($ProImage as $proimg)
                                                 
                <img src="{{asset('images')}}/{{ $proimg->seller_cover_pic }}" class="img-fluid" style="max-height:312px; max-width: 820px;" alt="">
                
            @endforeach
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
</div>
</div></div>



@include('footer')