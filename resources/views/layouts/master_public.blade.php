<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content="" />
<meta name="author" content="">

<!-- page title -->
<title>@yield('title')</title>
 <!-- Latest compiled and minified CSS -->
<!--
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
-->
         <link rel="stylesheet" href="/css/bootstrap.css" media="screen">
         
<!-- jquiry UI theme -->    
         <link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
              
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- jquery UI library -->
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>        
<!-- google recaptcha library -->
<script src='https://www.google.com/recaptcha/api.js'></script>
<script>

    $(document).ready(function() {

    });

</script>



@yield('page_specific_jquery')

<!-- / javascript -->


<style>

</style>

</head>

<body>
@include('partials.navbar_main')
@include('partials.page_heading')

        <div class="container-fluid">
        @yield('content')
        </div>

</body>

</html>      
