<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>

<div class="container">
    <div class="row" style="margin-top:45px">
        <div class="col-md-4 col-md-offset-4">
            <h4>Login |</h4><hr>
            <form action="{{ route('auth.login') }}" method="post">
                @csrf
                @if(Session::has('loginFailed'))
                    <div class="alert alert-danger">
                        User does not exist or password is invalid
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Enter email address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password">
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Sign In</button>
                <br>
                <a href="{{ route('auth.view.register') }}">I don't have an account, create new</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
