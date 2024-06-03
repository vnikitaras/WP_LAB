<?php      
    require 'check.php';
    
    checkLoginAndRole(1);

    require 'db.php';
    
    if(isset($_GET['id'])) {
        $user_id = $_GET['id'];
        
        $query = "SELECT * FROM users WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $fname = $row['fname'];
            $lname = $row['lname'];
            $email = $row['email'];
            $id_role = $row['id_role'];
        } else {
            header("Location: users.php");
            exit();
        }
    } else {
        header("Location: users.php");
        exit();
    }

    if(isset($_POST['save'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $id_role = $_POST['id_role'];

        $query = "UPDATE users SET fname=?, lname=?, email=?, id_role=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $fname, $lname, $email, $id_role, $user_id);
        $stmt->execute();

        header("Location: admin.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Χρήστη</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
    <style>
    video{
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
    .container{
                position: relative;
                z-index: 1;
                background-color: rgba(255, 255, 255, 0.7); 
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .logο{
            position: absolute;
            right: 20px; 
            width: 150px; 
    }        
    </style>
<body>
    <video autoplay loop muted>
            <source src="video.mp4" type="video/mp4">
        </video>
    <div class="container mt-5">
        <h1>Επεξεργασία Χρήστη</h1>
        <form action="" method="post">
            <input type            <input type="hidden" name="update_id" value="<?php echo $user_id; ?>">
            <div class="mb-3">
                <label for="fname" class="form-label">Όνομα</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname; ?>" required>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Επώνυμο</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $lname; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_role" class="form-label">Ρόλος</label>
                <select class="form-select" id="id_role" name="id_role" required>
                    <option value="1" <?php if($id_role == 1) echo 'selected'; ?>>Διαχειριστής</option>
                    <option value="2" <?php if($id_role == 2) echo 'selected'; ?>>Ιδιοκτήτης</option>
                    <option value="3" <?php if($id_role == 3) echo 'selected'; ?>>Διαχειριστής</option>
                    <option value="4" <?php if($id_role == 4) echo 'selected'; ?>>Παίκτης</option>
                    <option value="5" <?php if($id_role == 5) echo 'selected'; ?>>Προπονητής</option>
                    <option value="6" <?php if($id_role == 6) echo 'selected'; ?>>Φροντιστής</option>
                </select>
            </div>
            <button type="submit" name="save" class="btn btn-primary">Αποθήκευση</button>
        </form>
    </div>
</body>
</html>

