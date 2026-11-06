<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin sign in | 1000 Hills Rugby</title>
    <link rel="icon" type="image/png" href="{{ media_url('images/favicon-32x32.png') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-card-header">
            <img src="{{ site_logo() }}" alt="1000 Hills Rugby">
            <h1>Welcome back</h1>
            <p class="text-muted mb-0">Sign in to manage the 1000 Hills Rugby website.</p>
        </div>
        <div class="auth-card-body">
            @if(session('status'))
                <div class="alert alert-success py-2 small">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger py-2 small">
                    @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
                </div>
            @endif

            <form action="{{ route('admin.login.attempt') }}" method="POST" class="form-admin">
                @csrf
                <div class="mb-3">
                    <label for="identifier" class="form-label">Email or username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-person"></i></span>
                        <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}" class="form-control" autocomplete="username" required autofocus>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                        <label class="form-check-label small" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('home') }}" class="small">Back to website</a>
                </div>
                <button type="submit" class="btn btn-admin-forest w-100 py-2">Sign in <i class="bi bi-arrow-right ms-1"></i></button>
            </form>
        </div>
        <div class="auth-card-footer">
            <i class="bi bi-shield-lock me-1"></i>Restricted access for club staff only
        </div>
    </div>
</div>
<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
