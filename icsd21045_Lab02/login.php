<?php
    session_start();
    require 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $query = "SELECT id, fname, lname, password, id_role FROM users WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_fname'] = $row['fname'];
                $_SESSION['user_role'] = $row['id_role'];
                if ($row['id_role'] == 1) {
                    header("Location: admin.php");
                } elseif ($row['id_role'] == 2) {
                    header("Location: owner.php");
                } elseif ($row['id_role'] == 3) {
                    header("Location: manager.php");
                } elseif ($row['id_role'] == 4) {
                    header("Location: player.php");
                } elseif ($row['id_role'] == 5) {
                    header("Location: trainer.php");
                } elseif ($row['id_role'] == 6) {
                    header("Location: caregiver.php");
                } else {
                    header("Location: 404.html");
                }
                exit();
            } else {
                $error = "Άκυρο email ή κωδικός πρόσβασης";
            }
        } else {
            $error = "Άκυρο email ή κωδικός πρόσβασης";
        }
    }
?>

<!DOCTYPE html>
<html lang="el">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
        <style>
            video {
                position: fixed;
                right: 0;
                bottom: 0;
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                z-index: -100;
                background-size: cover;
            }
            .container {
                position: relative;
                z-index: 1;
                background-color: rgba(255, 255, 255, 0.7); 
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            }
            .logo {
            position: absolute; 
            top: 20px; 
            right: 20px; 
            width: 150px; 
            }
        </style>
    </head>
    <body>
        <video autoplay loop muted>
            <source src="video.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="container mt-5 text-center">
        <img src="https://myria.math.aegean.gr/~atsol/newpage/software/aegeanlogo/svg/logo_sfiga-bold_horizontal_el.svg" alt="Aegean Logo" class="logo">
            <h1>Login</h1>
            <?php if(isset($error)) echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="register.php" class="btn btn-link">Register</a>
            </form>
        </div>
    </body>
</html>

</html>
