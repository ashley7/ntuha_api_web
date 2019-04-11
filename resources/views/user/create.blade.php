@extends('layouts.master')

@section('content')
   <div class="card-box">
      <h4>Add User</h4>

       @if ($errors->any())
           @foreach ($errors->all() as $error)
               <div class="text-danger">{{$error}}</div>
           @endforeach
       @endif

      <div class="card-body">
        <form method="POST" action="{{route('user.store')}}">
          @csrf

            <div class="row">
              <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control">

                <label>Email</label>
                <input type="email" name="email" class="form-control">

                <br><br>

                <button type="submit" >Save</button>

              </div>
            </div>
          </form>
        </div>
      </div>
@endsection
 