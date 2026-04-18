<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Toko Buku</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 360px;
            background: #fff;
            padding: 35px;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-logo h2 {
            font-size: 28px;
            font-weight: 700;
            color: #222;
            margin-bottom: 5px;
        }

        .login-logo p {
            font-size: 14px;
            color: #777;
            margin: 0;
        }

        .form-control {
            height: 45px;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding-left: 40px;
        }

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            top: 14px;
            left: 14px;
            color: #999;
            z-index: 10;
        }

        .btn-login {
            height: 45px;
            border-radius: 10px;
            background: #111;
            color: white;
            font-weight: 600;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #333;
        }

        .footer-text {
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>

<body>

<div class="login-wrapper">
    <div class="login-box">

        <div class="login-logo">
            <h2>Toko Buku</h2>
            <p>Silakan login ke akun Anda</p>
        </div>

        <form method="POST" action="proses_login.php">

            <div class="form-group input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="form-group input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button type="submit" class="btn btn-login btn-block">
                Login
            </button>

        </form>

        <div class="footer-text">
            © 2026 Toko Buku
        </div>

    </div>
</div>

</body>
</html>