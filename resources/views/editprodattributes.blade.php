@include('header')

<style type="text/css"> 
     label {
          font-weight: bold;
     }
</style>

<div class="container">
     <div class="row">
          
          <div class="col-md-6">
               <form action='/editprodattributesadd' method="post">
                    {{ csrf_field() }}
               <input type="hidden" name="prod_id" value="{{ $id }}">
               <h2 class="text-center">Add Product Attributes</h2>
               <div class="form-group" id="vari" style="margin-top: 20px; margin-bottom: 20px; padding: 20px;"></div>

               <button style="border-radius: 25px;" class="btn btn-primary btn-lg btn-block" type="button" onclick="addInput('vari')">Add new attribute</button>


               <p>&nbsp;</p>
               <button style="border-radius: 25px; float: right;" class="btn btn-danger btn-lg" type="submit" >Next Variations</button>
          </form>

          </div>
          <div class="col-md-6">
               
               <h4>View Attributes</h4>
               <table class="table table-bordered table-striped">
                    <thead>
                         <tr>
                              <th>Key</th>
                              <th>Value</th>
                              <th>Action</th>
                         </tr>
                    </thead>
                    <tbody>
                         @foreach($attributes as $attr)
                         <tr>
                              <td>{{ $attr->att_key }}</td>
                              <td>{{ $attr->att_value }}</td>
                              <td><a onclick="return confirmbox()" href="{{ url('delattributes/'.$attr->att_id. '/' .$attr->att_prod_id)}}" class="btn btn-clear-primary"><i style="color: #ff4757; font-size: 16px;" class="fas fa-trash"></i></a></td>
                         </tr>
                         @endforeach
                    </tbody>
               </table>

          
     </div>
          </div>
          <div class="row">
          <div class="col-md-12">
               @if(count($attributes) == 0)
               <a href="/editimage/{{ $id }}" style="border-radius: 25px; float: right;margin-left: 15px;" class="btn btn-dark">Skip</a>
               @endif

               @if(count($attributes) > 0)
               <a href="/editvariation/{{ $id }}" class="btn btn-danger" style="border-radius: 25px; float: right;">NEXT</a>
               @endif
          </div>
     </div>
     </div>


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


<script type="text/javascript">
var counter = 0;
var limit = 5;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "<br>Attribute " + (counter + 1) + " <br /> <br><div class='card'> <div class='card-body'><label>Key</label> <input name='key[]' class='form-control' type='text' placeholder='Eg. Size'> <br> <label>Value</label> <input name='val[]' class='form-control' type='text' placeholder='Seperate with | '> <p>&nbsp;</p></div></div>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
</script>