@extends('layouts.app')

@section('content')

<h1>Import user accounts</h1>
	<div class="card">
		<div class="card-body">
			

			<form method="POST" action="/import_customer" enctype="multipart/form-data">
				{{csrf_field()}}			 

				<input type="file" name="excel_file">

				<br><br>
				<button class="btn btn-success">Save</button>
			</form>

			 			
		</div>
	</div> 
@endsection
 