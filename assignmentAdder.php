<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">
    <?php 
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
    }
    ?>

    <title>Διαχείρηση Εργασιών</title>

</head>

<div style="background-color:#443bec; color:white; padding: 20px; border: 2px solid rgb(0, 0, 0); border-right: transparent;">
    <?php
    $servername = "webpagesdb.it.auth.gr:3306";
    $Loginame = "kerasidis";
    $Password = "kerasidis";
    $dbname = "student3655partb";

    $conn = new mysqli($servername, $Loginame, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Name, Role FROM verifieduser WHERE Loginame = '" . $_SESSION["username"] . "'";

    $result = $conn->query($sql);
    $controlP = "";

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $welcomeMessage = "<div style='background-color:#443bec; color:white; padding: 15px; border: 2px solid rgb(0, 0, 0); position: absolute; top: 40px; right: 20px;'>" . "Συνδεδεμένος χρήστης: " . $row["Name"] . "<br>" . "Ιδιότητα: " . $row["Role"] . "</div>";

            if ($row["Role"] == "Tutor") {
                $controlP = "<div style='background-color:#ffffff; color:white; padding: 15px; border: 2px solid rgb(0, 0, 0); position: absolute; top: 40px; left: 20px;'>" . "<a href='control_panel.php'>Πίνακας ελέγχου</a>" . "</div>";
            }
        }
    }
    
    $conn->close();
    ?>
    
    <h1 align="center">Διαχείρηση Εργασιών</h1>
    <?php echo $welcomeMessage; ?>
    <?php echo $controlP; ?>
</div>

<ul>
    <li><a href="index.php"><b>Αρχική σελίδα</b></a></li>
    <br>
    <li><a href="announcements.php"><b>Ανακοινώσεις</b></a></li>
    <br>
    <li><a href="communication.php"><b>Επικοινωνία</b></a></li>
    <br>
    <li><a href="documents.php"><b>Έγγραφα μαθήματος</b></a></li>
    <br>
    <li><a href="homework.php"><b>Εργασίες</b></a></li>
</ul>

    <img src="images/pic_mainpage.png" alt="MainPage" style="width: 40px;height: 40px; position: absolute; top: 12px; right: 2px;">
    <img src="images/pic_announcement.png" alt="announcement" style="width: 40px;height: 40px; position: absolute; top: 102px; right: 2px;">
    <img src="images/pic_email.png" alt="email" style="width: 40px;height: 40px; position: absolute; top: 188px; right: 2px;">
    <img src="images/pic_documents.png" alt="email" style="width: 40px;height: 40px; position: absolute; top: 270px; right: 2px;">
    <img src="images/pic_assignment.png" alt="email" style="width: 40px;height: 40px; position: absolute; top: 360px; right: 2px;">


<style>
    
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            width: 220px;
            background-color: #443bec;
            position: absolute;
            height: 100%;
            overflow: auto;
            border: 2px solid rgb(0, 0, 0);
            border-top: transparent;
        }
    
        li a {
            display: block;
            color: #000;
            padding: 25px 25px;
            text-decoration: blueviolet;
        }
    
        li a.active {
            background-color: #74ddbe;
            color: white;
        }
    
        li a:hover:not(.active) {
            background-color: #bac09f;
            color: white;
        }
        
</style>

</ul>

<div style="margin-left:15%;padding:1px 16px;height:1000px;">

    <?php
    $servername = "webpagesdb.it.auth.gr:3306";
    $Loginame = "kerasidis";
    $Password = "kerasidis2001Paok";
    $dbname = "student3655partb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Name, Role FROM verifieduser WHERE Loginame = '" . $_SESSION["username"] . "'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
            if ($row["Role"] == "Tutor") {
                echo "<form action='assignmentAdder.php' method='post'>
                <label for='introduction'>Εκφώνηση Εργασίας:</label><br>
                <textarea id='introduction' name='introduction' rows='8' cols='80'></textarea><br>
                <label for='targets'>Στόχοι Εργασίας:</label><br>
                <textarea id='targets' name='targets' rows='8' cols='80'></textarea><br>
                <label for='deliveries'>Παραδοτέα:</label><br>
                <textarea id='deliveries' name='deliveries' rows='8' cols='80'></textarea><br>
                <label for='endDate'>Ημερομηνία λήξης:</label><br>
                <input type='date' id='endDate' name='endDate'><br><br>
                <input type='submit' value='Υποβολή'>
                </form>";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $introduction = $_POST["introduction"];
            $targets = $_POST["targets"];
            $deliveries = $_POST["deliveries"];
            $endDate = $_POST["endDate"];
            $sql = "INSERT INTO assignment_handler (Introduction, Targets, Deliveries, EndDate) VALUES ('" . $introduction . "', '" . $targets . "', '" . $deliveries . "', '" . $endDate . "')";
            if ($conn->query($sql) === TRUE) {
                echo "Η εργασία προστέθηκε επιτυχώς!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "0 results";
    }
    ?>

    
</div>

<style>
    body {
        background-color: #ffffff;
        border-right: #000000 2px solid;
        border-bottom: #000000 2px solid;
    }

</style>

</body>

</html>
