<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập - Quản Lý Tiền Điện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2>Đăng Nhập</h2>
            </div>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/') }}">
                @csrf
                <div class="form-group">
                    <label for="tk">Tài khoản</label>
                    <input type="text" class="form-control" id="tk" name="tk" value="{{ old('tk') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="mk">Mật khẩu</label>
                    <input type="password" class="form-control" id="mk" name="mk" required>
                </div>

                <button type="submit" class="btn btn-primary btn-login">Đăng Nhập</button>
            </form>
        </div>
    </div>
</body>
</html>