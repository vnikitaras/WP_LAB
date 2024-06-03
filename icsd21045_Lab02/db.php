<?php
    // Ορισμός παραμέτρων σύνδεσης στη βάση δεδομένων
    $servername = "localhost"; // Τοπικός διακομιστής MySQL
    $username = "root"; // Όνομα χρήστη MySQL
    $password = ""; // Κωδικός πρόσβασης στο MySQL
    $dbname = "Football_Club"; // Όνομα της βάσης δεδομένων που θα χρησιμοποιηθεί
	
    // Σύνδεση στη βάση δεδομένων χρησιμοποιώντας την κλάση mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Έλεγχος επιτυχίας σύνδεσης
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error); // Εκτύπωση μηνύματος λάθους αν η σύνδεση αποτύχει
	}
?>
