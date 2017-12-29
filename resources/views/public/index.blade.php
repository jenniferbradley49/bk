@extends('layouts.master_public')

@section('title', 'Welcome page')
@section('page_specific_jquery')
@endsection

@section('content')
<!-- /app/resources/views/public/index.blade.php -->
    
 
<div class="row">
	<div class="col-sm-1"> <br>
	</div>
	<div class="col-sm-4"> 
	<div class="bs-component">
	 {!! Html::link('ch_seven_form+master', 'start chapter 7 process') !!} 
	</div>
	</div>
	<div class="col-sm-2"> &nbsp;
	</div>
	<div class="col-sm-4"> 
	<div class="bs-component">
	Three Step security provides enterprise business level security for your website.  
Three Step security requires that an authorized visitor access a designated email address to obtain access to the resource.
 {!! Html::link('three_step_security', 'Learn about and try three step security') !!} 
	</div>
 	</div>
	<div class="col-sm-1"> 
	</div>
</div><!-- end row -->
     
@endsection

