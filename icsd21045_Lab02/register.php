<?php
    session_start();
    require 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $id_role = $_POST['id_role'];
        
        $query = "INSERT INTO users (fname, lname, email, password, id_role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $fname, $lname, $email, $password, $id_role);
        $stmt->execute();
        
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['user_fname'] = $fname;
        $_SESSION['user_role'] = $id_role;

        header("Location: login.php");
        exit();
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
        </video>
        <div class="container mt-5 text-center">
        <img src="https://myria.math.aegean.gr/~atsol/newpage/software/aegeanlogo/svg/logo_sfiga-bold_horizontal_el.svg" alt="Aegean Logo" class="logo">
        <h1 class="text-center">Εγγραφή</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="fname" class="form-label">Όνομα</label>
                <input type="text" class="form-control" id="fname" name="fname" required>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Επώνυμο</label>
                <input type="text" class="form-control" id="lname" name="lname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Κωδικός</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="id_role" class="form-label">Επιλέξτε ρόλο:</label>
                <select class="form-select" id="id_role" name="id_role" required>
                    <option value="1">Διαχειριστής</option>
                    <option value="2">Ιδιοκτήτης</option>
                    <option value="3">Διαχειριστής</option>
                    <option value="4">Παίκτης</option>
                    <option value="5">Προπονητής</option>
                    <option value="6">Φροντιστής</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Εγγραφή</button>
            <a href="login.php" class="btn btn-link">Σύνδεση</a>
        </form>
    </div>
</body>
</html>
