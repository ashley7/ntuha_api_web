@extends('layouts.master')

@section('content')
<div class="card-box"> 
  <h4>Set price</h4>

    <div class="card-body">
      <div class="row">
        <div class="col-md-6">

         <form method="POST" action="{{route('price.update',$read_price->id)}}"> 

          {{csrf_field()}}
          {{method_field("PATCH")}}

           <label>Service ({{$read_price->type}})</label>
            <select class="form-control" name="type">
              <option></option>
              <option value="Ntuha Boda">Ntuha Boda</option>
              <option value="Ntuha Taxi">Ntuha Taxi</option>
              <option value="Ntuha Truck">Ntuha Truck</option>
            </select>

            <label>Price par KM</label>
            <input type="number" name="price" value="{{$read_price->price}}" class="form-control">

            <label>Ntuha Commission (UGX)</label>
            <input type="number" step="any" name="rate" value="{{$read_price->rate}}" class="form-control">

            <label>Ride Type ({{$read_price->ratetype}})</label>
            <select class="form-control" name="ratetype">
              <option></option>
              <option value="Paid">Paid</option>
              <option value="Free">Free</option>
            </select>

            <br>
            <button id="save_price" type="submit" class="btn btn-primary">Save</button>
         

          </form>
          
        </div>
      </div>  
                        
    </div>
  </div>            
@endsection

@push('scripts')
   <script>
       $("#save_price").click(function() {
        $("#save_price").text("Processing...");  
    });
  </script>
@endpush