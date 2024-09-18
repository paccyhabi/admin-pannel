<?php
include "./includes/conn.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL statement
    $role = "admin";
    $stmt = $pdo->prepare("SELECT id, password FROM Users WHERE username = :username AND role = :role");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->execute();

    // Fetch the user
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
        session_start();
        $_SESSION['user_id'] = $user['id'];
        header("Location:/dashboard");
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
            margin-top: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Login</h2>
        <form id="loginForm" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
    <!-- jQuery and Bootstrap JS CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- SweetAlert2 JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        <?php if (isset($error_message)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $error_message; ?>',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
</body>
</html>
