@extends('layouts.master')

@section('content')
   <div class="card-box">
      <h4>{{$title}}</h4>
 

      <div class="card-body">
        <form method="POST" action="{{url('delete_my_account')}}">
          @csrf

            <div class="row">
              <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" class="form-control">

                <label>Email</label>
                <input type="email" name="email" class="form-control">

                <label for="message">Message</label>
                <textarea name="message" id="message" cols="10" rows="5" class="form-control"></textarea>

                <hr>

                <button type="submit" class="btn btn-danger">Save</button>

              </div>
            </div>
          </form>
        </div>
      </div>
@endsection
 