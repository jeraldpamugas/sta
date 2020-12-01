<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>STA</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <h2 style="text-align: center">STA Login</h2>
                @if ($message = Session::get('failed'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <form action="user" method="POST">
                    @csrf
                    <div class="form-group">
                    <label for="fullname">Fullname:</label>
                    <input type="text" class="form-control" id="fullname" placeholder="Enter Fullname" name="fullname">
                    </div>
                    <div class="form-group">
                    <label for="usercode">User Code:</label>
                    <input type="password" class="form-control" id="usercode" placeholder="Enter Your Code" name="usercode">
                    </div>
                    <div class="checkbox">
                    </div>
                    <button type="submit" class="btn btn-default" style="width: 100%">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>