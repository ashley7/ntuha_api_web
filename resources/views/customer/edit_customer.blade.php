@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>           
    <div class="card-body">
      <form method="POST" action="{{route('customers.update',$read_customer->id)}}">
        @csrf
        {{method_field('PATCH')}}
                
          <div class="row">
            <div class="col-md-6">
              <label>First name</label>
              <input type="text" name="first_name" value="{{$read_customer->first_name}}" class="form-control">

              <label>Last name</label>
              <input type="text" name="last_name" value="{{$read_customer->last_name}}" class="form-control"> 

              <label>Age</label>
              <input type="number" name="year_of_birth" value="{{$read_customer->year_of_birth}}" class="form-control"> 

              <label>Phone number</label>
              <input type="number" name="phone_number" value="{{str_replace('@gmail.com','',$read_customer->email)}}" class="form-control">          
              <br>
              <button id="save_customer" class="btn btn-primary">Save customer</button>                       
            </div>
          <div class="col-md-6">


              <label>Sex</label>
              <select class="form-control" name="sex">
                @if($read_customer->sex == "male")
                 <option value="male" selected>Male</option>
                 <option value="female">Female</option>
                 @else
                 <option value="male">Male</option>
                 <option value="female" selected>Female</option>
                @endif
              </select>   
              <label>Disability status</label>
              <select class="form-control" name="disability_status">
                @if($read_customer->disability_status == "disabled")
                <option value="disabled" selected>Disabled</option>
                <option value="not disabled">Not disabled</option>
                @else
                <option value="disabled">Disabled</option>
                <option value="not disabled" selected>Not disabled</option>
                @endif
              </select>

              <label>Occupation</label>
              <select class="form-control" name="occupation">
                @if($read_customer->occupation == "Farmer")
                <option value="Farmer" selected>Farmer</option>
                <option value="Commuter">Commuter</option>
                <option value="Farmer and Commuter">Farmer and Commuter</option>
                @elseif($read_customer->occupation == "Commuter")
                <option value="Farmer">Farmer</option>
                <option value="Commuter" selected>Commuter</option>
                <option value="Farmer and Commuter">Farmer and Commuter</option>
                @else
                <option value="Farmer">Farmer</option>
                <option value="Commuter">Commuter</option>
                <option value="Farmer and Commuter" selected>Farmer and Commuter</option>
                @endif
              </select>
 
                       
            
              </div>
            </div> 
        </form>  
      </div>
    </div>  
@endsection

 
 