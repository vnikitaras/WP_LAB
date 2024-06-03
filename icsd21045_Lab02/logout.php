<?php
	// Ξεκινάμε τη συνεδρία PHP
	session_start();
	// Απενεργοποιούμε και διαγράφουμε όλα τα δεδομένα συνεδρίας
	session_unset();
	session_destroy();
	// Ανακατευθύνουμε τον χρήστη στη σελίδα σύνδεσης (login.php)
	header("Location: login.php");
	// Τερματίζουμε την εκτέλεση του κώδικα
	exit();
?>
