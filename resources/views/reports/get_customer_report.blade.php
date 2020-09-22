@extends('layouts.master')

@section('content')
   <div class="card-box">
      <h4>{{$title}}</h4>

       @if ($errors->any())
           @foreach ($errors->all() as $error)
               <div class="text-danger">{{$error}}</div>
           @endforeach
       @endif

      <div class="card-body">
        <form method="POST" action="/customer_report">
          @csrf

            <div class="row">
              <div class="col-md-6">
                <label>From</label>
                <input type="date" name="from" class="form-control">

                <input type="hidden" name="report_name" value="revenue">

                <label>To</label>
                <input type="date" name="to" class="form-control">

                <br><br>

                <button type="submit" class="btn btn-danger" >Save</button>

              </div>
            </div>
          </form>
        </div>
      </div>
@endsection
 