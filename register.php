<?php
require 'function.php';

$registrationSuccess = false;

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek apakah email sudah terdaftar
    $cekEmail = mysqli_query($conn, "SELECT * FROM login WHERE email = '$email'");
    $hitungEmail = mysqli_num_rows($cekEmail);

    if($hitungEmail == 0){
        // Tambahkan pengguna ke database
        $addUser = mysqli_query($conn, "INSERT INTO login (username, email, password) VALUES ('$username', '$email', '$password')");
        
        if($addUser){
            $registrationSuccess = true;
        } else {
            echo "Registrasi gagal.";
        }
    } else {
        echo "Email sudah terdaftar. Silakan gunakan email lain.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    <script>
        // Tambahkan skrip JavaScript untuk menampilkan pesan popup
        window.onload = function() {
            <?php if ($registrationSuccess): ?>
                alert('Registrasi berhasil. Silakan login.');
                window.location.href = 'login.php';
            <?php endif; ?>
        };
    </script>
</head>
<body class="bg-primary">
    <!-- Tambahkan tag div untuk pesan popup -->
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputUsername">Username</label>
                                            <input class="form-control py-4" name="username" id="inputUsername" type="text" placeholder="Enter username" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputEmail">Email</label>
                                            <input class="form-control py-4" name="email" id="inputEmail" type="email" placeholder="Enter email address" required />
                                        </div>
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputPassword">Password</label>
                                            <input class="form-control py-4" name="password" id="inputPassword" type="password" placeholder="Enter password" required />
                                        </div>
                                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" name="register">Register</button>
                                            <a class="small" href="login.php">Sudah punya akun? Login di sini</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>
