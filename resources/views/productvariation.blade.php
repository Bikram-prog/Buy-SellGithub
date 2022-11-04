@include('header')


<div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 addbox">
            <h4>Add Variations</h4>
            <form action="/addvariationpost" method="POST">
                {{ @csrf_field() }}

                @foreach($variaton as $var)
                @php
                $explode= explode(',', $var->var_meta_value);
                @endphp
                <div class="form-group">
                    <label>{{ $var->var_meta_key }}</label>
                    <select name="meta_val[]" class="form-control">
                        @foreach($explode as $exp)
                        <option>{{ $exp }}</option>
                        @endforeach
                    </select>
                </div>

                
                
                @endforeach

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantty</label>
                            <input type="number" class="form-control" name="quantity">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="amount" class="form-control" name="price">
                            <input type="hidden" class="form-control" name="prod_id" value="<?php echo $id; ?>">
                            <input type="hidden" class="form-control" name="cate_id" value="<?php echo $catid; ?>">
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-dark">Add</button>
                </div>
                

            </form>

            
            <ol class="list-group list-group-numbered mt-4">
                @foreach($var_all as $all)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                  <div class="ms-2 me-auto">
                    <div class="fw-bold">{{ $all->var_value }}</div>
                     Quantity: {{ $all->var_quantity }} Price: ${{ $all->var_price }}
                  </div>
                  <span class="badge bg-primary rounded-pill"><a href="/delprodvariation/{{ $all->var_id }}" onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt" style="color: #fff;"></i></a></span>
                </li>
                @endforeach
              </ol>

              <div class="d-grid gap-2">
              <a href="/sellerimgupld/{{$id}}" class="btn btn-danger btn-lg">NEXT</a>
            </div>
               
           
            
        </div>
        <div class="col-md-4"></div>

    </div>
</div>



@include('footer')