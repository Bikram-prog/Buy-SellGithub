@include('header')


<div class="container-fluid">
    <div class="row">

@include('sellersidebar')

<div class="col-md-9" style="margin-top: 30px;">
<div class="row" style="margin-bottom: 20px; margin-left: 30px;">

<div class="col-md-12" >
  <h2>Pending product payment</h2>
</div>

<div class="col-md-12">
  <form action="/pendingpayment" method="POST">
    @csrf
  <table class="table table-border table-striped">
  <thead class="thead-light">
    <tr>
      <th scope="col"><input type="checkbox" id="all" ></th>
      <th scope="col">Product Title</th>
      
      <th scope="col">Date & time</th>
    </tr>
  </thead>
  <tbody>
    @foreach($pendingproduct as $payment)
            <tr>
              <td><input type="checkbox" name="chk[]" value="{{ $payment->prod_id }}"></td>
             <td>{{ $payment->prod_title }}</td>
             <td>{{ $payment->prod_date_time }}</td>
            </tr>
    @endforeach
   </tbody>
 </table>
 <button onclick="pricechange();" type="submit" class="btn btn-danger btn-lg">Payment</button>
 </form>
</div>





 </div>
</div>
</div>
</div>



@include('footer')

<script type="text/javascript">
  function pricechange() {
    //var pricetxt = document.getElementById("hd_price").value;
    var a = $(":checkbox:checked").length;
    document.getElementById("hd_price").value = a;
    document.getElementById("price").innerHTML = a;

  }


</script>