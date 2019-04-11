@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>List of users</h4>

    <div class="card-body">

    <a style="float: right;" href="{{route('user.create')}}" class="btn btn-success">Add new user</a>
    <br><br>

      <div class="table-responsive">
          <table class="table table-hover table-striped" id="working_drivers">
              <thead>         
                  <th>Name</th>
                  <th>Email</th>
                                              
              </thead>

              <tbody>
                 @foreach($users as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>     
                    </tr>                    
                 @endforeach
               </tbody>
             </table>
           </div>
         </div>
       </div>                
@endsection