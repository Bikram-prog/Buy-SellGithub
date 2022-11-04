@include('header')

<style type="text/css"> 
     label {
          font-weight: bold;
     }
</style>

<div class="container" style="margin-top: 20px;">
     <div class="row">
          
          <div class="col-md-6">
               <h4>Add Variation</h4>
               <form action="/variationpost" method="post">
                    {{ csrf_field() }}

               @foreach($attributes as $var)
               <select style="margin-bottom: 10px;" class="form-control var_cls" name="var[]">
               <option>{{$var->att_key}}</option>
               <?php 
               $exp = explode("|", $var->att_value);
               ?>   
               @foreach($exp as $e)                    
               <option>{{$e}}</option>
               @endforeach
               </select>
               @endforeach
               <label>Quantity</label>
               <input type="number" required name="quantity" class="form-control">
               <label>Price</label>
               <input type="text" required name="price" class="form-control"> 
               <input type="hidden" name="prod_id" value="{{ $id }}">
               <p>&nbsp;</p>
               <button type="submit" class="btn btn-danger btn-block" style="border-radius: 25px;">Save</button>
          </form>

          </div>
          <div class="col-md-6">
               <h4>View Variations</h4>
               <table class="table table-bordered table-striped">
                    <thead>
                         <tr>
                              <th>Value</th>
                              <th>Quantity</th>
                              <th>Price</th>
                              <th>Action</th>


                         </tr>
                    </thead>
                    <tbody>
                         @foreach($variation as $vari)
                         <tr>
                              <td>{{ $vari->var_value }}</td>
                              <td>{{ $vari->var_quantity }}</td>
                              <td>{{ $vari->var_price }}</td>
                              <td><a onclick="return confirmbox()" href="{{ url('delvariation/'.$vari->var_id. '/' .$vari->var_prod_id)}}" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;" class="fas fa-trash"></i></a></td>

                         </tr>
                         @endforeach
                    </tbody>
               </table>
               
          </div>
     </div>

     <div class="row">
          <div class="col-md-12">
               <a href="/sellerimgupld/{{ $id }}" class="btn btn-danger" style="border-radius: 25px; float: right;">NEXT UPLOAD IMAGES</a>
          </div>
     </div>
     </div>




<p>&nbsp;</p>

@include('footer')

<script type="text/javascript">
    function confirmbox() {
        var win = window.confirm("Are you sure?");
        if(win) {
            return true;
        } else {
            return false;
        }
    }
</script>

