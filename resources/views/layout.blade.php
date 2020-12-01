<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STA</title><!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    
    <style>
      .alert-message {
        color: red;
      }
      
      .requiredField{
          border: 2px solid red;
      }
    </style>
    
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/transactions') }}">STA-Home</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                @if($usertype != 'staff')
                <li id="nav navItem" role="presentation"><a href="{{ url('/items') }}">Item</a></li>
                <li id="nav navWH" role="presentation"><a href="{{ url('/warehouses') }}">Warehouse</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container-fluid" style="margin-top: 20px; margin-bottom: 20px;">
        @yield('content')
    </div>
   
</body>
</html>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>

<script>
    // $(document).on('click', '#nav' function(){
    //     console.log("asd");
    //     $(".active").removeClass("active");
    // });
    // $(document).on('click', 'a#slidingMenuButton.BtextToLeft', function () {
    //     $("i.fa-bars").removeClass("textToLeft").addClass("textToRight");
    //     $("a#slidingMenuButton").removeClass("BtextToLeft").addClass("noState");
    //     alert("lol2");
    // });
    
  
</script>
