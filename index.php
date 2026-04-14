<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- AdminLTE -->
     <link rel="stylesheet" href="https://cdn.jsdeliver.net/npm/admin-lte@3.2/dist/css/admin.lte.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- AdminLTE -->
    <script src="https://cdn.jsdeliver.net/npm/admin-lte@3.2/dist/js/admin.lte.min.js"></script>
</head>
<body class="hold-transition login-page">
   
    <div class="login-box">
        <div class="login-logo">
            <b> Toko Buku</b>
        </div>

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silahkan Login</p>

                <form method="POST" action"proses_login.php">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" name="username">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </div>
                </div>

                </form>

            </div>
        </div>
    </div>
    
</body>
</html>