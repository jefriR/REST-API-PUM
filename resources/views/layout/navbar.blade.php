<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">

    <!-- Create New CSS -->
    {{----}}

    <title>Hello, world!</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
   <div class="container">
       <a class="navbar-brand" href="#">Navbar</a>
       <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
       </button>
       <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
           <div class="navbar-nav">
               <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
               <a class="nav-item nav-link" href="#">Features</a>
               <a class="nav-item nav-link" href="#">Pricing</a>
               <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
           </div>
       </div>
   </div>
</nav>


<main class="py-4">
    @yield('content')
</main>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script  type="text/javascript" src="{{ asset('/js/jquery-3.3.1.min.js')}} "></script>
<script  type="text/javascript" src="{{ asset('/js/popper.min.jss')}} "></script>
<script  type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>

<!-- Create New CSS -->
{{----}}
</body>
</html>


