@extends('layouts.master')

@section('content')
<div class="card-box"> 
  <h4>Set price</h4>

    <div class="card-body">
      <div class="row">
        <div class="col-md-12">

           <label>Service</label>
            <select class="form-control" id="service">
              <option></option>
              <option value="Ntuha Boda">Ntuha Boda</option>
              <option value="Ntuha Taxi">Ntuha Taxi</option>
              <option value="Ntuha Truck">Ntuha Truck</option>
            </select>

            <label>Price par KM</label>
            <input type="number" id="price" class="form-control">

            <label>Ntuha Commission (UGX)</label>
            <input type="number" step="any" id="rate" class="form-control">

            <label>Ride Type</label>
            <select class="form-control" id="ratetype">
              <option></option>
              <option value="Paid">Paid</option>
              <option value="Free">Free</option>
            </select>

            <br>
            <button id="save_price" class="btn btn-primary">Save</button>
   
          
        </div>
      </div>
     
      <br><br>


        <div class="table-responsive">
            <table class="table table-hover table-striped" id="working_drivers">
                <thead>
                    <th>Date</th>
                    <th>Service</th>
                    <th>Price par KM</th>                          
                    <th>Ntuha rate</th>                          
                    <th>Type</th> 
                    <th>Action</th>                         
                </thead>

                <tbody>
                   @foreach($prices as $price)
                      <tr>
                          <td>{{$price->created_at}}</td>
                          <td>{{$price->type}}</td>                                     
                          <td>{{$price->price}}</td>                                    
                          <td>{{$price->rate}}</td>                                     
                          <td>{{$price->ratetype}}</td>
                          <td><a href="{{route('price.edit',$price->id)}}">Edit</a></td>                                    
                      </tr>                          
                   @endforeach
                </tbody>
            </table>
        </div>                
    </div>
  </div>            
@endsection

@push('scripts')
   <script>
       $("#save_price").click(function() {
        $("#save_price").text("Processing...");
         $.ajax({
                type: "POST",
                url: "{{ route('price.store') }}",
            data: {
               price: $("#price").val(),                              
               type:  $("#service").val(),                           
               rate:  $("#rate").val(),                         
               ratetype:  $("#ratetype").val(),                         
                 _token: "{{Session::token()}}"
            },
                success: function(result){                    
                    $("#save_price").text(result);
                    location.reload();
                  }
        })
    });
  </script>
@endpush