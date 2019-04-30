<?php
// Include config file
require_once "config.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}

// Alternatively, check if user is logged in and trying to access admin page, if they are, redirect them to userhome
else if (!isset($_SESSION["loggedin"]) || $_SESSION["admin"] !== true) {
    header("Location: userhome.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <title>All Adoptions | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 300px; }
        .no_requests{
          color: red;
          text-shadow: -1px -1px 0 #f5b0b0, 1px -1px 0 #0e0e0e, -1px 1px 0 #1b1b1b, 1px 1px 0 #755353;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1><span style="color: red; text-shadow: -1px -1px 0 #f5b0b0, 1px -1px 0 #0e0e0e, -1px 1px 0 #1b1b1b, 1px 1px 0 #755353;">[Admin]</style><span> <b><?php
echo htmlspecialchars($_SESSION["username"]);
?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="adminhome.php" class="btn btn-primary btn-lg">Home</a>
        <a href="addanimal.php" class="btn btn-success btn-lg">Add an animal</a>
        <a href="process-adoptions.php" class="btn btn-success btn-lg">Process Adoptions</a>
        <a href="viewalladoptions.php" class="btn btn-info btn-lg" style="background-color: #afafaf; border-color: grey;">View all adoptions</a>
        <a href="allanimals.php" class="btn btn-info btn-lg">View all animals</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Admin-text"><b style="color: #efdb8c;">Admin Panel: Available animals</b></h2>
    <p>Here you can view all the adoption requests made by all users (after they have been processed) and whether they were approved or denied</p>

    <div class="wrapper">
      <div class="form-group">
        <select class="form-control" id="mySelect" onchange="myFunction()">
          <option class="form-control" value="sort_all" selected="selected">Sort by: All requests</option>
          <option class="form-control" value="sort_approved">Sort by: APPROVED</option>
          <option class="form-control" value="sort_denied">Sort by: DENIED</option>
        </select>
      </div>
    </div>

<p id="selectStatement1"></p>
<p id="selectStatement2"></p>

<script>
document.getElementById("selectStatement1").innerHTML = "";
var x = document.getElementById("mySelect").value;
if(x == "sort_all"){
  document.getElementById("selectStatement1").innerHTML = '<?php
$sql    = "SELECT * FROM adoption_requests WHERE approval !=0";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchColumn();
if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no approved or denied adoption requests at the moment.</p>";
} else {
    $q    = "SELECT * FROM adoption_requests WHERE approval !=0";
    $rows = $pdo->query($q);

    echo '<div class="displaydata">';
    echo '<h2 class="he2">Process all adoptions</h2>';
    echo '<table class="tabcs">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th>USER ID</th>';
    echo '<th>USERNAME</th>';
    echo '<th>ANIMAL ID</th>';
    echo '<th>ANIMAL NAME</th>';
    echo '<th>REQUEST</th>';
    echo '</tr>';
    foreach ($rows as $row) {

        if ($row['approval'] == 1) {
            $request = "APPROVED";
        } else if ($row['approval'] == 2) {
            $request = "DENIED";
        }

        $user_query = "SELECT * FROM users WHERE id = " . $row['userid'];
        $user       = $pdo->query($user_query)->fetch();

        $animal_query = "SELECT * FROM animal WHERE animalid = " . $row['animalid'];
        $animal       = $pdo->query($animal_query)->fetch();

        //add the animalID to view to the get parameters
        echo '<tr>';
        echo "<td>" . $user["id"] . "</td>";
        //echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $animal['animalid'] . '</td>';
        echo '<td>' . $animal['name'] . '</td>';
        echo '<td>' . $request . '</td>';
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</div>';
}
?>';
}
</script>

<script>
function myFunction(){
document.getElementById("selectStatement1").innerHTML = "";
var x = document.getElementById("mySelect").value;
if(x == "sort_all"){
  document.getElementById("selectStatement1").innerHTML = '<?php
$sql    = "SELECT * FROM adoption_requests WHERE approval !=0";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchColumn();
if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no approved or denied adoption requests at the moment.</p>";
} else {
    $q    = "SELECT * FROM adoption_requests WHERE approval !=0";
    $rows = $pdo->query($q);

    echo '<div class="displaydata">';
    echo '<h2 class="he2">Process all adoptions</h2>';
    echo '<table class="tabcs">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th>USER ID</th>';
    echo '<th>USERNAME</th>';
    echo '<th>ANIMAL ID</th>';
    echo '<th>ANIMAL NAME</th>';
    echo '<th>REQUEST</th>';
    echo '</tr>';
    foreach ($rows as $row) {

        if ($row['approval'] == 1) {
            $request = "APPROVED";
        } else if ($row['approval'] == 2) {
            $request = "DENIED";
        }

        $user_query = "SELECT * FROM users WHERE id = " . $row['userid'];
        $user       = $pdo->query($user_query)->fetch();

        $animal_query = "SELECT * FROM animal WHERE animalid = " . $row['animalid'];
        $animal       = $pdo->query($animal_query)->fetch();

        //add the animalID to view to the get parameters
        echo '<tr>';
        echo "<td>" . $user["id"] . "</td>";
        //echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $animal['animalid'] . '</td>';
        echo '<td>' . $animal['name'] . '</td>';
        echo '<td>' . $request . '</td>';
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</div>';
}
?>';
}

// APPROVED
else if(x == "sort_approved"){
  document.getElementById("selectStatement1").innerHTML = '<?php
$sql    = "SELECT * FROM adoption_requests WHERE approval =1";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchColumn();
if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no approved requests at the moment.</p>";
} else {
    $q    = "SELECT * FROM adoption_requests WHERE approval =1";
    $rows = $pdo->query($q);

    echo '<div class="displaydata">';
    echo '<h2 class="he2">Process all adoptions</h2>';
    echo '<table class="tabcs">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th>USER ID</th>';
    echo '<th>USERNAME</th>';
    echo '<th>ANIMAL ID</th>';
    echo '<th>ANIMAL NAME</th>';
    echo '<th>REQUEST</th>';
    echo '</tr>';
    foreach ($rows as $row) {

        if ($row['approval'] == 1) {
            $request = "APPROVED";
        } else if ($row['approval'] == 2) {
            $request = "DENIED";
        }

        $user_query = "SELECT * FROM users WHERE id = " . $row['userid'];
        $user       = $pdo->query($user_query)->fetch();

        $animal_query = "SELECT * FROM animal WHERE animalid = " . $row['animalid'];
        $animal       = $pdo->query($animal_query)->fetch();

        //add the animalID to view to the get parameters
        echo '<tr>';
        echo "<td>" . $user["id"] . "</td>";
        //echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $animal['animalid'] . '</td>';
        echo '<td>' . $animal['name'] . '</td>';
        echo '<td>' . $request . '</td>';
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</div>';
}
?>';
}

// APPROVED
else if(x == "sort_denied"){
  document.getElementById("selectStatement1").innerHTML = '<?php
$sql    = "SELECT * FROM adoption_requests WHERE approval =2";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchColumn();
if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no denied requests at the moment.</p>";
} else {
    $q    = "SELECT * FROM adoption_requests WHERE approval =2";
    $rows = $pdo->query($q);

    echo '<div class="displaydata">';
    echo '<h2 class="he2">Process all adoptions</h2>';
    echo '<table class="tabcs">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th>USER ID</th>';
    echo '<th>USERNAME</th>';
    echo '<th>ANIMAL ID</th>';
    echo '<th>ANIMAL NAME</th>';
    echo '<th>REQUEST</th>';
    echo '</tr>';
    foreach ($rows as $row) {

        if ($row['approval'] == 1) {
            $request = "APPROVED";
        } else if ($row['approval'] == 2) {
            $request = "DENIED";
        }

        $user_query = "SELECT * FROM users WHERE id = " . $row['userid'];
        $user       = $pdo->query($user_query)->fetch();

        $animal_query = "SELECT * FROM animal WHERE animalid = " . $row['animalid'];
        $animal       = $pdo->query($animal_query)->fetch();

        //add the animalID to view to the get parameters
        echo '<tr>';
        echo "<td>" . $user["id"] . "</td>";
        //echo '<td>' . $user['id'] . '</td>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $animal['animalid'] . '</td>';
        echo '<td>' . $animal['name'] . '</td>';
        echo '<td>' . $request . '</td>';
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</div>';
}
?>';
}
}
</script>

</body>
</html>
