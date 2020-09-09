@extends('layouts.master')

@section('content')

<h1>Import user accounts</h1>
	<div class="card">
		<div class="card-body">
			<div class="row">
            	<div class="col-md-6">		
					<form method="POST" action="/import_customer" enctype="multipart/form-data">
						{{csrf_field()}}			 

						<input type="file" name="excel_file">

						<br><br>
						<button class="btn btn-success">Save</button>
					</form>
			    </div>
			</div>			 			
		</div>
	</div> 
@endsection
 