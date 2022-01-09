<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>

<div class="container">
    <div class="row" style="margin-top:45px">
        <div class="col-md-4 col-md-offset-4">
            <h4>Register |</h4><hr>
            <form action="{{ route('auth.register') }}" method="post">
                @csrf

                @if(Session::has('isRegistered'))
                    @if(Session::get('isRegistered'))
                        <div class="alert alert-success">
                            User added successfully !
                        </div>
                    @else
                        <div class="alert alert-danger">
                            Something went wrong. Please try again
                        </div>
                    @endif
                @endif

                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ old('name') }}">
                    <span class="text-danger">@error('name'){{ $message }} @enderror</span>
                </div>
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
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="btn btn-block btn-primary">Sign Up</button>
                <br>
                <a href="{{ route('auth.view.login') }}">I already have an account, sign in</a>
            </form>
        </div>
    </div>
</div>

</body>
</html>
