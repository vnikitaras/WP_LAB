<?php
    require 'check.php';

    checkLoginAndRole(3); 

    require 'db.php'; 

    $query_players = "SELECT id, fname, lname FROM users WHERE id_role = 4";
    $result_players = $conn->query($query_players);

    $query_manager = "SELECT id, fname, lname FROM users WHERE id_role = 3";
    $result_manager = $conn->query($query_manager);
    
    $query_owners = "SELECT id, fname, lname FROM users WHERE id_role = 2";
    $result_owners = $conn->query($query_owners);
    
    $query_trainer = "SELECT id, fname, lname FROM users WHERE id_role = 5";
    $result_trainer = $conn->query($query_trainer);

    $query_caregiver = "SELECT id, fname, lname FROM users WHERE id_role = 6";
    $result_caregiver = $conn->query($query_caregiver);
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
            position: -webkit-sticky; 
            position: sticky;
            top: 0;
            z-index: 1000; 
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
        h2, td {
            color: #002366;
        }
        th{
            color: #f2f2f2; 
        }
        .logout-button {
            position: fixed;
            bottom: 10px;
            right: 10px;
        }
        .team-info, .team-stats {
        opacity: 0;
        animation: fadeIn 1s ease forwards;        
        }
        .team-info p {
        font-size: 24px; 
        font-weight: bold;
        color: #002366;
        margin-top: 20px;
        }
        .team-info p2 {
        font-size: 22px; 
        color: #002366;
        margin-top: 15px;
        }
        .history-box {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
            color: #002366;
            margin-top: 20px;
        }      
        @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
        }
        .team-info-container {
                    position: sticky;
                    top: 56px; 
                    background-color: #f8f9fa;
                    z-index: 999;
                    padding: 10px 0;
                    margin-bottom: 20px;
        }
        .team-info {
            opacity: 0;
            animation: fadeIn 1s ease forwards;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            
        }
        .team-info img {
            max-width: 100%;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .team-stats {
            margin-top: 40px;
        }
        .team-stats h3 {
            font-size: 24px;
            color: #002366;
            margin-bottom: 20px;
        }
        .team-stats ul {
            list-style-type: none;
            padding: 0;
        }
        .team-stats li {
            font-size: 16px;
            color: #555;
            margin-bottom: 10px;
        }
        .team-stats li:before {
            content: "\2022"; 
            color: #002366; 
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }
    </style>
</head>
<body>
    <video autoplay loop muted>
        <source src="video.mp4" type="video/mp4">
    </video>
    <div class="container">
        <div class="header">
    </div>
        <div class="navbar">        
            <a href="#" onclick="showTab('team')">Η ΟΜΑΔΑ ΜΑΣ</a>
            <a href="#" onclick="showTab('players')">ΠΑΙΚΤΕΣ</a>
            <a href="#" onclick="showTab('manager')">ΠΡΟΠΟΝΗΤΕΣ</a>
            <a href="#" onclick="showTab('owners')">ΙΔΙΟΚΤΗΤΕΣ</a>
            <a href="#" onclick="showTab('trainer')">ΓΥΜΝΑΣΤΕΣ</a>
            <a href="#" onclick="showTab('caregiver')">ΦΥΣΙΚΟΘΕΡΑΠΕΥΤΕΣ</a>
        </div>

        <div id="players" class="tab-content">
            <h2>Παίκτες</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα Παίκτη</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_players->num_rows > 0) {
                            while ($row = $result_players->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td scope='row'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Δεν υπάρχουν διαθέσιμοι παίκτες</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="manager" class="tab-content">
            <h2>Προπονητές</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα Προπονητή</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_manager->num_rows > 0) {
                            while ($row = $result_manager->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td scope='row'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Δεν υπάρχουν διαθέσιμοι προπονητές</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="owners" class="tab-content">
            <h2>Ιδιοκτήτες</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα Ιδιοκτήτη</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_owners->num_rows > 0) {
                            while ($row = $result_owners->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td scope='row'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Δεν υπάρχουν διαθέσιμοι ιδιοκτήτες</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div id="trainer" class="tab-content">
            <h2>Γυμναστές</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα Γυμναστή</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_trainer->num_rows > 0) {
                            while ($row = $result_trainer->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td scope='row'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Δεν υπάρχουν διαθέσιμοι Γυμναστές</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <div id="caregiver" class="tab-content">
            <h2>Φυσικοθεραπευτές</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Όνομα Φυσικοθεραπευτή</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result_caregiver->num_rows > 0) {
                            while ($row = $result_caregiver->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td scope='row'>" . $row['id'] . "</td>";
                                echo "<td>" . $row['fname'] . " " . $row['lname'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Δεν υπάρχουν διαθέσιμοι Φυσικοθεραπευτές</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>        
    
    
        <div id="team" class="tab-content">        
            <div class="team-info">
                <p>Καλώς ήρθατε στην ποδοσφαιρική ομάδα του Πανεπιστημίου Αιγαίου!</p>
            <img src="https://www.horshamsparrows.co.uk/wp-content/uploads/2022/09/image0-1024x599.jpeg" alt="Ποδοσφαιρική Ομάδα"">
            
            <div class="team-stats">
                <h3>Στατιστικά Ομάδας</h3>
                <ul>
                    <li>
                    <p2>
                        Συμμετοχές στο Πανελλήνιο Φοιτητικό Πρωτάθλημα: 23
                    </p2>
                    <p>   
                        <span>Κατακτήσεις: 12</span>
                    </p>
                        <img src="https://t4.ftcdn.net/jpg/07/73/35/65/360_F_773356542_wUbzXOJfrsKUQrCU2w8j63ZFNkvz5pJ3.jpg" alt="Κύπελλο" style="max-width: 60px; margin-left: 20px;">
                    </li>
                    <li>
                        <p2>
                        Συμμετοχές στο Πανελλήνιο Φοιτητικό Κύπελλο: 19
                        </p2>
                        <p>
                        <span>Κατακτήσεις: 8</span>
                        </p>
                        <img src="https://atlas-content-cdn.pixelsquid.com/stock-images/trophies-trophy-cup-ZeaLBD0-600.jpg" alt="Κύπελλο" style="max-width: 60px; margin-left: 20px;">
                    </li>
                    
                    <h3>Ιστορικά Στοιχεία</h3>
                    <div class="history-box">
                        Η ομάδα μας αντιπροσωπεύει το πνεύμα της φοιτητικής κοινότητας και την αγάπη για το ποδόσφαιρο. Ιδρύθηκε από μια ομάδα φοιτητών με πάθος για το άθλημα, που αποφάσισαν να ενώσουν τις δυνάμεις τους και να δημιουργήσουν μια ομάδα που θα ανταγωνίζεται στο υψηλότερο επίπεδο. Με πολλές προσπάθειες και αφοσίωση, η ομάδα μας έχει καταφέρει να διακριθεί σε διάφορους αγώνες και πρωταθλήματα.Μέσα από τη σκληρή δουλειά και το αμέτρητο πάθος, η ομάδα μας έχει διαμορφώσει μια πλούσια ιστορία, γεμάτη με στιγμές αγώνα, νίκες και θριάμβους. Κατά τη διάρκεια των ετών, έχουμε συμμετάσχει σε αμέτρητους αγώνες και διοργανώσεις, ενώ έχουμε κατακτήσει σημαντικά βραβεία και τίτλους.Η ομάδα μας συνεχίζει να αναπτύσσεται και να εξελίσσεται, με νέους παίκτες και προπονητές που ενώνουν τις δυνάμεις τους για να διατηρήσουν το πνεύμα του ανταγωνισμού ζωντανό και να συνεχίσουν την παράδοση της επιτυχίας. Με την υποστήριξη της κοινότητάς μας και των φίλων μας, συνεχίζουμε να προωθούμε το ποδόσφαιρο και να εμπνέουμε τις νέες γενιές να ακολουθήσουν το όνειρό τους στο γήπεδο.
                    </div>                                    
                </ul>
            </div>
        </div>
    
</div>
    <div class="logout-button">
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Αποσύνδεση</button>
        </form>
    </div>
    <script>
    function showTab(tabId) {
        var tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(function(tab) {
            tab.classList.remove('active');
        });
        document.getElementById(tabId).classList.add('active');

        if (tabId === 'team') {
            document.querySelector('.team-info').style.opacity = '1';
        } else {
            document.querySelector('.team-info').style.opacity = '0';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        showTab('team'); 
    });
</script>
</body>
</html>

