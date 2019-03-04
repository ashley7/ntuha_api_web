@extends('layouts.master')

@section('content')
 <div class="card-box">
    <h4>{{$title}}</h4>

    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="transactions">
                <thead>
                    <th>Date</th>
                    <th>Emount</th>
                    <th>Status</th>
                    <th>Phone number</th>
                    <th>Customer name</th>
                    <th>Transaction id</th>
                    <th>Action</th>                    
                </thead>

                <tbody>

                  @foreach($transactions as $transaction)

                    <tr>
                      <td>{{$transaction->created_at}}</td>
                      <td>{{$transaction->amount}}</td>
                      <td>{{$transaction->status}}</td>
                      <td>{{$transaction->phone_number}}</td>
                      <td>{{$transaction->customer_name}}</td>
                      <td>{{$transaction->transaction_id}}</td>
                      <td></td>
                    </tr>

                  @endforeach
                    
                </tbody>
            </table>
          </div>
        </div>
      </div>        
@endsection