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
      #nav a{
        background-color: #275e69;
      }
      .active{
        background-color: #275e69;
      }
      
      .card {
        transition: 0.3s;
        width: 100%;
        border-radius: 10px;
      }

      .pendingCard {
        box-shadow: 0 4px 8px 0 rgba(255, 0, 0, 0.2);
      }

      .upcomingCard {
        box-shadow: 0 4px 8px 0 rgba(0, 158, 71, 0.2);
      }
      .pendingTransA:hover div{
        background-color: rgba(255, 0, 0, 0.2);
        color: black;
      }
      .confirmedTrans:hover div{
        background-color: rgba(0, 158, 71, 0.2);
        color: black;
      }
      
      .pendingTransA:link{
        text-decoration: none;
      }
      .confirmedTrans:link{
        text-decoration: none;
      }
      .pendingTransA{
        color: black;
      }
      .confirmedTrans{
        color: black;
      }
      .pendingTransA h5{
        margin: 0;
      }
      .confirmedTrans h5{
        margin: 0;
      }
      #transactionTable thead{
        position: sticky; top: 0;
      }
    </style>
    
</head>
<body>
    <nav class="navbar navbar-default">
        <div style="background-color: #54b9cd;" class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a style="color: white" class="navbar-brand" href="{{ url('/home') }}">STA-Home</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                @if($usertype != 'staff')
                <li role="presentation"><a id="navItem" class="navi" style="color: white" href="{{ url('/items') }}">Item</a></li>
                <li role="presentation"><a id="navWH" class="navi" style="color: white" href="{{ url('/warehouses') }}">Warehouse</a></li>
                @else
                <li role="presentation"><a id="navItem" class="navi" style="color: white" href="{{ url('/transactions') }}">Transactions</a></li>
                @endif
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a style="color: white" href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
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
    // $(document).ready(function(){
    //   $(".navi").click(function(){
    //     var current_page = $("#page-name").data("page");
    //     $('.active').removeClass('active');
    //     $(this).addClass('active');
    //   });
    // });
    // $(document).on('click', 'li#nav a', function () {
    //   alert('asdasd')
    //   $('#navWH a').addClass('active');
    // });
    
  
</script>
