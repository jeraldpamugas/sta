<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
    
    <style>
        @import url(https://fonts.googleapis.com/css?family=Dosis:300|Lato:300,400,600,700|Roboto+Condensed:300,700|Open+Sans+Condensed:300,600|Open+Sans:400,300,600,700|Maven+Pro:400,700);
        /* @import url("https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css"); */
        html {
          background-image: url(http://www.ultraimg.com/images/2UeGfhZ.jpg);
        }
        
        body {
          padding: 0px;
          margin: 0px;
          font-family: "Open Sans";
          font-size: 14px;
          font-smoothing: antialiased;
        }
        
        .page {
          position: absolute;
          width: 100%;
          height: 100%;
          background-color: rgba(255, 255, 255, 0.7);
          -moz-border-radius: 4px;
          -webkit-border-radius: 4px;
          border-radius: 4px;
          -moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.4);
          -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.4);
          box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.4);
        }
        
        .pageHeader {
          width: 100%;
          height: 50px;
          line-height: 50px;
          background-color: #54b9cd;
          color: White;
          -moz-box-sizing: border-box;
          -webkit-box-sizing: border-box;
          box-sizing: border-box;
          padding: 5px 20px;
          vertical-align: middle;
        }
        .pageHeader .title {
          width: 40%;
          float: left;
          line-height: 40px;
          font-size: 1.5em;
          font-weight: 700;
        }
        .pageHeader .userPanel {
          width: 40%;
          float: right;
        }
        .pageHeader .userPanel i {
          float: right;
          line-height: 40px;
          padding-right: 10px;
        }
        .pageHeader .userPanel .username {
          float: right;
          line-height: 40px;
          padding: 0px 20px;
          font-weight: 600;
          font-size: 1.0em;
        }
        .pageHeader .userPanel img {
          float: right;
          -moz-border-radius: 5px;
          -webkit-border-radius: 5px;
          border-radius: 5px;
        }
        
        .main {
          position: relative;
          width: 100%;
          height: 100%;
          clear: both;
          margin: 0;
          background-color: white;
        }
        .main .nav {
          width: 200px;
          height: 100%;
          float: left;
          background-color: rgba(227, 234, 235, 0.8);
        }
        .main .nav .menu {
          width: 100%;
          margin: 15px 0;
          color: #555;
        }
        .main .nav .menu ul {
          padding-left: 0px;
        }
        .main .nav .menu ul li {
          cursor: pointer;
          list-style: none;
          margin: 5px 0px;
          padding: 5px 0px;
          font-weight: 600;
          padding-left: 10px;
          -moz-border-radius: 4px;
          -webkit-border-radius: 4px;
          border-radius: 4px;
          transition: 0.25s all;
        }
        .main .nav .menu ul li.active {
          color: #79BC46;
        }
        .main .nav .menu ul li:hover {
          background-color: #999;
        }
        .main .nav .menu ul li i {
          font-size: 1.4em;
          margin-right: 10px;
        }
        
        .clear {
          clear: both;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="container-fluid page" style="padding: 0;">
        <div class="pageHeader">
            <div class="title">STA</div>
            <div class="userPanel"><i class="fa fa-chevron-down"></i><span class="username">Logout</span></div>
        </div>
        <div class="row main">
            <div style="padding: 0;" class="col-sm-2 nav">
                <div class="menu">
                    <div class="title"></div>
                    <ul>
                        <li><i class="fa fa-home"></i>Transactions</li>
                        <li><i class="fas fa-edit"></i>Items</li>
                        <li class="active"><i class="fas fa-warehouse"></i>Warehouses</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-10">
                @yield('content')
            </div>
        </div>
    </div>
</body>

<script src='https://kit.fontawesome.com/a076d05399.js'></script>
</html>