<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Log-in.css">
    <title>Log in</title>
    <style>
    /* Bordered form */
.formLG {
  border: 3px solid #FFFFFF;
}

/* Full-width inputs */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for in button */
.Loginbutton{
  background-color: #000000;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}


/* Add padding to containers */
.containerLG {
  padding: 16px;
  padding-left: 100px;
  padding-right: 100px;
}
    
.centered {
    text-align: center;
}

.center-img {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 300px; 
}
    </style>
</head>
<body>

<?php
        include("Navbar-login.php");
    ?>
    <div class="centered">
    <img class="center-img" src="..\Images\AssestManagerWhiteBackground.png" alt="Autodesk logo">
    <h1>Log in</h1>
    </div>

    <form class="formLG" action="" method="post">
    <div class="containerLG">
        <label for="Email"><b>Email</b></label>
        <input type="text" id="Email" placeholder="Enter Email" name="Email" required>

        <label for="password"><b>Password</b></label>
        <input type="password" id="password" placeholder="Enter Password" name="Password" required>

        <button type="submit" value="Log In" class="Loginbutton">Login</button>
    </div>
    </form>



 <?php /*
session_start(); // Start session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputEmail = $_POST['Email'];
    $inputPassword = $_POST['Password'];

    $db = new SQLite3('Autodesk_database_2.db');

    if (!$db) {
        die("Database connection failed");
    }

    // Fetch user details based on the provided username
    $query = "SELECT * FROM User WHERE Email = :Email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':Email', $inputEmail, SQLITE3_TEXT);
    $result = $stmt->execute();

    if ($result && $row = $result->fetchArray(SQLITE3_ASSOC)) {
        // Directly compare plain text password
        if ($inputPassword === $row['Password']) {
            // Store User ID in session for authentication
            $_SESSION['Userid'] = $row['UserID'];
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['AccessLevel'] = $row['AccessLevel'];
            

            // Redirect user based on clearance level
            switch ($row['ClearanceLevel']) {
                case 'Doctor':
                    header("Location: DocHomepage.php");
                    exit;
                case 'Receptionist':
                    header("Location: ReceptHomepage.php");
                    exit;
                case 'Patient':
                    header("Location: PatHomepage.php");
                    exit;
                case 'Admin':
                    header("Location: AdminHomepage.php");
                    exit;
                default:
                    echo "<p style='color:red; text-align:center;'>Access Denied: Invalid Clearance.</p>";
            }
        } else {
            echo "<p style='color:red; text-align:center;'>Invalid Email or password. Please try again.</p>";
        }
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid Email or password. Please try again.</p>";
    }
    $db->close();
}*/
?> 

</body>
</html>
