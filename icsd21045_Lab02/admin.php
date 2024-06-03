<?php
    require 'check.php';

    checkLoginAndRole(1); 

    require 'db.php'; 

    if(isset($_POST['submit'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $id_role = $_POST['id_role'];

        $query = "INSERT INTO users (fname, lname, email, password, id_role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $fname, $lname, $email, $password, $id_role);
        $stmt->execute();
    }

    if(isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        
        $query = "DELETE FROM users WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
    }

    if(isset($_POST['update'])) {
        $update_id = $_POST['update_id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $id_role = $_POST['id_role'];

        $query = "UPDATE users SET fname=?, lname=?, email=?, password=?, id_role=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssii", $fname, $lname, $email, $password, $id_role, $update_id);
        $stmt->execute();

        $stmt->close();
    }

    $query = "SELECT * FROM users";
    $result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Χρηστών</title>
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
        body {
            background-color: #f8f9fa;
        }               
        .header {
            background-image: url('https://upload.wikimedia.org/wikipedia/el/thumb/b/b3/%CE%A0%CE%B1%CE%BD%CE%B5%CF%80%CE%B9%CF%83%CF%84%CE%AE%CE%BC%CE%B9%CE%BF_%CE%91%CE%B9%CE%B3%CE%B1%CE%AF%CE%BF%CF%85.svg/1280px-%CE%A0%CE%B1%CE%BD%CE%B5%CF%80%CE%B9%CF%83%CF%84%CE%AE%CE%BC%CE%B9%CE%BF_%CE%91%CE%B9%CE%B3%CE%B1%CE%AF%CE%BF%CF%85.svg.png');
            background-size: cover;
            background-position: center;
            padding: 40px 0;
            text-align: center;
            color: #fff;
        }
        .navbar {            
            background-color: #002366; 
            padding: 10px 0;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1000; 
            justify-content: center; 
            align-items: center; 
        }
        .navbar a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
        }
        .navbar a:hover {
            color: #888;
            font-size: 110%;
        }      
        .tab-content {
            display: none; 
            background-color: #e0e0e0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .tab-content.active {
            display: block; 
        }
        .table {
            background-color: #ffffff; 
        }
        .table thead {
            background-color: #002366; 
            color: #fff;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
        .table tbody tr:nth-child(even) {
            background-color: #ffffff;
        }
        h1, h2, td {
            color: #002366;
        }
        th {
            color: #f2f2f2; 
        }
        .logout-button {
            position: fixed;
            bottom: 10px;
            right: 10px;
        }
        .form-container {
            background-color: #e0e0e0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>    
    <video autoplay loop muted>
            <source src="video.mp4" type="video/mp4">
        </video>
    <div class="header">
    </div>

    <div class="navbar">
        <a href="#users">Πίνακας Χρηστών</a>
        <a href="#insert">Εισαγωγή Χρήστη</a>
    </div>

    <div class="container">
        <div id="users" class="tab-content active">
            <h2>Χρήστες</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Όνομα</th>
                        <th>Επίθετο</th>
                        <th>Email</th>
                        <th>Ρόλος</th>
                        <th>Ενέργειες</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['id_role']; ?></td>
                            <td>
                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Διαγραφή</a>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Επεξεργασία</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="insert" class="tab-content">
            <h2>Εισαγωγή Χρήστη</h2>
            <form method="POST" action="">
                <div class="form-container">
                    <div class="mb-3">
                        <label for="fname" class="form-label">Όνομα</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">Επίθετο</label>
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
                        <label for="id_role" class="form-label">Ρόλος</label>
                        <input type="number" class="form-control" id="id_role" name="id_role" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Εισαγωγή</button>
                </div>
            </form>
        </div>

        <div id="edit" class="tab-content">
            <h2>Επεξεργασία Χρήστη</h2>
            <form method="POST" action="">
                <div class="form-container">
                    <input type="hidden" id="update_id" name="update_id">
                    <div class="mb-3">
                        <label for="edit_fname" class="form-label">Όνομα</label>
                        <input type="text" class="form-control" id="edit_fname" name="fname" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_lname" class="form-label">Επίθετο</label>
                        <input type="text" class="form-control" id="edit_lname" name="lname" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_password" class="form-label">Κωδικός</label>
                        <input type="password" class="form-control" id="edit_password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_id_role" class="form-label">Ρόλος</label>
                        <input type="number" class="form-control" id="edit_id_role" name="id_role" required>
                    </div>
                    <button type="submit" class="btn btn-warning" name="update">Ενημέρωση</button>
                </div>
            </form>
        </div>
    </div>
    <div class="logout-button">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Αποσύνδεση</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('.navbar a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.querySelector(this.getAttribute('href')).classList.add('active');
            });
        });

    </script>
</body>
</html>

