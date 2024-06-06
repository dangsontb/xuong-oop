<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Welcome {{ $name }} to my website!</h1>

            <nav>
            
                @if (isset($_SESSION['user']))
                    <form action="{{ url('auth/logout')}}" method="POST">
                        <button class="btn btn-warning" type="submit"  name="submit">Logout</button>
                    </form>
                @else
                    <a class="btn btn-primary" href="{{ url('auth/login')}}">Login</a>
                @endif
            </nav>
        </div>
    </div>
</body>
</html>