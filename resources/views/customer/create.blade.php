@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>           
    <div class="card-body">                 
          <div class="row">
            <div class="col-md-6">
              <label>First name</label>
              <input type="text" id="first_name" class="form-control">

              <label>Last name</label>
              <input type="text" id="last_name" class="form-control">

              <label>Phone Number</label>
              <input type="text" id="phone_number" class="form-control">

              <label>Year of Birth</label>
              <input type="text" id="year_of_birth" class="form-control">                        
              <label>Sex</label>
              <select class="form-control" id="sex">
                <option value="male">Male</option>
                <option value="female">Female</option>
              </select>                          
            </div>
          <div class="col-md-6">
              <label>Disability status</label>
              <select class="form-control" id="disability_status">
                <option value="disabled">Disabled</option>
                <option value="not disabled">Not disabled</option>
              </select>

              <label>Occupation</label>
              <input type="text" id="occupation" class="form-control">

              <label>Customer sign up date</label>
              <input type="text" id="sign_up_date" class="form-control">

              <label>Agent name</label>
              <input type="text" id="agent_name" class="form-control">

              <label>Other information</label>
              <textarea id="description" class="form-control"></textarea>

              <p id="display"></p>

              <br>
              <button id="save_customer" class="btn btn-primary">Save customer</button>
            
              </div>
        </div>   
      </div>
    </div>  
@endsection

@push('scripts')
   <script>
       $("#save_customer").click(function() {
        $("#display").text("Processing...");
         $.ajax({
                type: "POST",
                url: "/customer",
            data: {
               first_name: $("#first_name").val(),                              
               last_name:  $("#last_name").val(),                           
               sex:  $("#sex").val(),                         
               year_of_birth:  $("#year_of_birth").val(),                         
               disability_status:  $("#disability_status").val(),                         
               location:  $("#location").val(),                         
               occupation:  $("#occupation").val(),                         
               sign_up_date:  $("#sign_up_date").val(),                         
               description:  $("#description").val(),                         
               phone_number:  $("#phone_number").val(),                         
               agent_name:  $("#agent_name").val(),                         
                 _token: "{{Session::token()}}"
            },
                success: function(result){                    
                    $("#display").text(result);                 
                }
        })
    });
  </script>
@endpush
 