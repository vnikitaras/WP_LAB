<?php
	session_start();
	if (!isset($_SESSION['user_id'])) {
		header("Location: /icsd21045_Lab02/index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Home</title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container mt-5">
			<h1>Welcome <?php echo $_SESSION['user_fname']; ?></h1>
			<a href="logout.php" class="btn btn-danger">Logout</a>
		</div>
	</body>
</html>
