<!DOCTYPE html>

<head>

<meta charset="UTF-8">

<title>Αρχική σελίδα</title>

</head>

<div style="background-color:#443bec; color:white; padding:20px; border: 2px solid rgb(0, 0, 0); border;">

<h1 align="center">Σελίδα Πιστοποίησης Στοιχείων</h1>

<body>
    <div style="background-color: #ffffff; color:white; padding:300px; border: 2px solid rgb(0, 0, 0); border;">
    <form action="login.php" method="post">
    <div style="background-color: #443bec; color:black; padding:20px; border: 2px solid rgb(0, 0, 0);">
    <h2 align="center">Παρακαλώ συμπληρώστε τα στοιχεία σας</h2>
    <div align= "center" style="background-color: #443bec; color:black; padding:20px;">
    <label for="username">Email:</label>
    <input type="text" id="username" name="username" placeholder="somestudent@gmail.com" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" placeholder="1234ABC" required><br><br>
    <input type="submit" value="Σύνδεση"><br><br>
    <?php

    $servername = "webpagesdb.it.auth.gr:3306";
    $Loginame = "kerasidis";
    $Password = "kerasidis";
    $dbname = "student3655partb";

    $conn = new mysqli($servername, $Loginame, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Loginame, Password FROM verifieduser";
    $result = $conn->query($sql);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["Loginame"] == $_POST["username"] && $row["Password"] == $_POST["password"]) {
                    session_start();
                    $_SESSION["username"] = $_POST["username"];
                    header("Location: index.php");
                    break;
                } 
            }
            echo "Λάθος στοιχεία";
        } else {

            echo "Δεν υπάρχουν εγγεγραμμένοι χρήστες";
        }
    }
    
    $conn->close();
    ?>
    </div>
</body>
<html>
