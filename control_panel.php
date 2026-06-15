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

    <title>Αρχική σελίδα</title>
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
    
    <h1 align="center">Πίνακας Ελέγχου</h1>
    <?php echo $welcomeMessage; ?>
    <?php echo $controlP; ?>
</div>

<ul>

<li><a href="index.php"><b>Αρχική σελίδα</b></a></li>
<br><li><a href="announcements.php"><b>Ανακοινώσεις</b></a></li>
<br><li><a href="communication.php"><b>Επικοινωνία</b></a></li>
<br><li><a href="documents.php"><b>Έγγραφα μαθήματος</b></a></li>
<br><li><a href="homework.php"><b>Εργασίες</b></a></li>

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

<div style="margin-left:20%;padding:1px 16px;height:1000px;">
    <h2>Πίνακας ελέγχου για διδάσκοντες</h2>
    <p>Εδώ θα βρείτε λειτουργίες επεξεργασίας για χρήστες με το ρόλο του μαθητή.</p>

    <?php
    $servername = "webpagesdb.it.auth.gr:3306";
    $Loginame = "kerasidis";
    $Password = "kerasidis";
    $dbname = "student3655partb";

    $conn = new mysqli($servername, $Loginame, $Password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Name, Loginame, Surname, Role FROM verifieduser WHERE Role = 'Student'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table><tr><th>Όνομα</th><th>Επώνυμο</th><th>Email</th><th>Ρόλος</th><th>Διαγραφή</th><th>Επεξεργασία</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Name"] . "</td><td>" . $row["Surname"] . "</td><td>" . $row["Loginame"] . "</td><td>" . $row["Role"] . "</td><td><form action='control_panel.php' method='post'><input type='hidden' name='id' value='" . $row["Loginame"] . "'><input type='submit' name='delete' value='Διαγραφή'></td><td><input type='submit' name='edit' value='Επεξεργασία'></form></td></tr>";

            if (isset($_POST['delete'])) {
                $sql = "DELETE FROM verifieduser WHERE Loginame = '" . $_POST['id'] . "'";
                $conn->query($sql);
                header("Refresh:0");
            }               
        }
        echo "<hr>";
        echo "</table>";
    } else {
        echo "0 results";
    }

    if (isset($_POST['edit'])) {
        $sql = "SELECT Name, Surname, Loginame, Password, Role FROM verifieduser WHERE Loginame = '" . $_POST['id'] . "'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo "<h2>Επεξεργασία Χρήστη</h2>";
        echo "<form action='control_panel.php' method='post'>

        <input type='text' name='name' value='" . $row['Name'] . "'>
        <input type='text' name='surname' value='" . $row['Surname'] . "'>
        <input type='text' name='loginame' value='" . $row['Loginame'] . "'>
        <input type='text' name='password' value='" . $row['Password'] . "'>
        <select name='role'>
            <option value='Student'>Μαθητής</option>
            <option value='Tutor'>Διδάσκων</option>
        </select>
        <input type='submit' name='save' value='Ενημέρωση'>
        </form>";
    }

    if (isset($_POST['save'])) {
        $sql = "UPDATE verifieduser SET Name = '" . $_POST['name'] . "', Surname = '" . $_POST['surname'] . "', Loginame = '" . $_POST['loginame'] . "', Password = '" . $_POST['password'] . "', Role = '" . $_POST['role'] . "' WHERE Loginame = '" . $_POST['loginame'] . "'";
        $conn->query($sql);

        echo "<span style='color:green'>  <b>Η χρήστης ενημερώθηκε επιτυχώς."  . "</span></b>";
        echo "<script>setTimeout(\"location.href = 'control_panel.php';\",1000);</script>";
    }

    echo "<h2>Προσθήκη Χρήστη</h2>";
    echo "<form action='control_panel.php' method='post'>
    <input type='text' name='name' placeholder='Όνομα'>
    <input type='text' name='surname' placeholder='Επώνυμο'>
    <input type='text' name='loginame' placeholder='Όνομα Χρήστη'>
    <input type='text' name='password' placeholder='Κωδικός'>
    <select name='role'>
        <option value='Student'>Μαθητής</option>
        <option value='Tutor'>Διδάσκων</option>
    </select>
    <input type='submit' name='add' value='Προσθήκη'>
    </form>";

    if (isset($_POST['add'])) {
        $sql = "INSERT INTO verifieduser (Name, Surname, Loginame, Password, Role) VALUES ('" . $_POST['name'] . "', '" . $_POST['surname'] . "', '" . $_POST['loginame'] . "', '" . $_POST['password'] . "', '" . $_POST['role'] . "')";
        $conn->query($sql);
        echo "<span style='color:green'>  <b>Η χρήστης προσθέθηκε επιτυχώς."  . "</span></b>";
        echo "<script>setTimeout(\"location.href = 'control_panel.php';\",1500);</script>";
    }

    $sql = "SELECT Name, Loginame, Surname, Role FROM verifieduser WHERE Role = 'Tutor'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<br>";
        echo "<h2>Μέλη που είναι διδάσκοντες</h2>";
        echo "<table><tr><th>Όνομα</th><th>Επώνυμο</th><th>Όνομα Χρήστη</th><th>Ρόλος</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["Name"] . "</td><td>" . $row["Surname"] . "</td><td>" . $row["Loginame"] . "</td><td>" . $row["Role"] . "</td></tr>";
        }
        echo "</table>";
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

    html {
        overflow: hidden;
    }

    tr {
        background-color: #443bec;
        color: white;
        padding: 15px;
    }
    
    td {
        background-color: #ffffff;
        color: black;
        padding: 15px;
    }
</style>

</body>

</html>
