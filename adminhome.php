<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: index.php");
    exit;
}

// Alternatively, check if user is logged in and trying to access admin page, if they are, redirect them to userhome
else if(!isset($_SESSION["loggedin"]) || $_SESSION["admin"] !== true){
  header("Location: userhome.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Admin-homepage for Aston Animal Sanctuary, here you can see pending adoption requests, process adoption requests, add animals for adoption, see all animals an who owns them, view all adoption requests">
    <title>Home | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .no_requests{
          color: red;
          text-shadow: -1px -1px 0 #f5b0b0, 1px -1px 0 #0e0e0e, -1px 1px 0 #1b1b1b, 1px 1px 0 #755353;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1><span style="color: red; text-shadow: -1px -1px 0 #f5b0b0, 1px -1px 0 #0e0e0e, -1px 1px 0 #1b1b1b, 1px 1px 0 #755353;">[Admin]</style><span> <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="adminhome.php" class="btn btn-primary btn-lg" style="background-color: #afafaf; border-color: grey;">Home</a>
        <a href="addanimal.php" class="btn btn-success btn-lg">Add an animal</a>
        <a href="process-adoptions.php" class="btn btn-success btn-lg">Process Adoptions</a>
        <a href="viewalladoptions.php" class="btn btn-info btn-lg">View all adoptions</a>
        <a href="allanimals.php" class="btn btn-info btn-lg">View all animals</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Admin-text"><b style="color: #efdb8c;">Admin Panel: Available animals</b></h2>
    <p>Here you can view all the animals in the system that are currently available for adoption.</p>

    <!-- List all animals that are available. Availability is checked in the database where the column number is 1 -->
    <?php
    $sql = "SELECT * FROM animal WHERE availability = 1";
    $result = $pdo->prepare($sql);
    $result->execute();
    $rows = $result->fetchColumn();
    if($rows == 0){
          echo "<p class=\"no_requests\">It seems there are no animals that are available at the moment.</p>";
    } else {
    	$q = "SELECT * FROM animal WHERE availability = 1";
    	$rows = $pdo->query($q);

      echo '<div class="displaydata">';
      echo '<h2 class="he2">Animals awaiting adoption</h2>';
      echo '<table class="tabcs">';
        echo '<tbody>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>NAME</th>';
        echo '<th>TYPE</th>';
        echo '<th>GENDER</th>';
        echo '</tr>';
    	foreach ($rows as $row) {
        if($row["gender"] == "m" || $row["gender"] == "male"){
          $gender = "Male";
        }
        if($row["gender"] == "f" || $row["gender"] == "female"){
          $gender = "Female";
        } else if($row["gender"] == "o" || $row["gender"] == "other"){
          $gender = "Unknown";
        }
    		//add the animalID to view to the get parameters
        echo '<tr>';
          echo '<td> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["animalid"] . "</a> </td>" ;
      		echo '<td> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["name"] . "</a> </td>" ;
          echo '<td> ' . $row["type"] . "</td>";
          echo '<td> ' . $gender . "</td>" ;
        echo '</tr>';
    	}
        echo '</tobdy>';
      echo '</table>';
      echo '</div>';
    }
    ?>




</body>
</html>
