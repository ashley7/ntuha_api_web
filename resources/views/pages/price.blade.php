@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Set price</div>

                <div class="card-body">
                  <label>Service</label>
                  <select class="form-control" id="service">
                    <option value="Ntuha Boda">Ntuha Boda</option>
                    <option value="Ntuha Taxi">Ntuha Taxi</option>
                    <option value="Ntuha Truck">Ntuha Truck</option>
                  </select>

                  <label>Price par KM</label>
                  <input type="number" id="price" class="form-control">

                  <br>
                  <button id="save_price" class="btn btn-primary">Save</button>
                  <a href="">Refresh</a>
                  <br><br>


                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="working_drivers">
                            <thead>
                                <th>Date</th>
                                <th>Service</th>
                                <th>Price par KM</th>                                 
                            </thead>

                            <tbody>
                               @foreach($prices as $price)
                                  <tr>
                                      <td>{{$price->created_at}}</td>
                                      <td>{{$price->type}}</td>                                     
                                      <td>{{$price->price}}</td>                                     
                                  </tr>                          
                               @endforeach
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>
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
               type: $("#service").val(),                              
                 _token: "{{Session::token()}}"
            },
                success: function(result){
                    $('#name').val(" ")
                    $("#save_price").text(result);
                  }
        })
    });
  </script>
@endpush