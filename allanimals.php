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
    <meta name="description" content="View all the animals in the system page. Here admins can view all the animals that are either available or unavailable.">
    <title>Home | Aston Animal Sanctuary</title>
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
        <a href="viewalladoptions.php" class="btn btn-info btn-lg">View all adoptions</a>
        <a href="allanimals.php" class="btn btn-info btn-lg" style="background-color: #afafaf; border-color: grey;">View all animals</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Admin-text"><b style="color: #efdb8c;">Admin Panel: View all the animals</b></h2>
    <p>Here you can view all the animals in the system that are either currently available or unavailable for adoption regardless.</p>

    <div class="wrapper">
      <div class="form-group">
        <select class="form-control" id="mySelect" onchange="myFunction()">
          <option class="form-control" value="sort_all" selected="selected">Sort by: All availability</option>
          <option class="form-control" value="sort_available">Sort by: AVAILABLE</option>
          <option class="form-control" value="sort_unavailable">Sort by: NOT AVAILABLE</option>
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
  $sql    = "SELECT * FROM animal";
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchColumn();
  if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no animals in the system at the moment.</p>";
  } else {
    $q    = "SELECT * FROM animal";
    $rows = $pdo->query($q);

    echo '<div class="displaydata">';
    echo '<h2 class="he2">View all animals</h2>';
    echo '<table class="tabcs">';
    echo '<tbody>';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>NAME</th>';
    echo '<th>TYPE</th>';
    echo '<th>GENDER</th>';
    echo '<th>AVAILABILITY</th>';
    echo '</tr>';
    foreach ($rows as $row) {
        if ($row["gender"] == "m" || $row["gender"] == "male") {
            $gender = "Male";
        } else if ($row["gender"] == "f" || $row["gender"] == "fenale") {
            $gender = "Female";
        } else if ($row["gender"] == "o" || $row["gender"] == "other") {
            $gender = "Unknown";
        }
        if ($row["availability"] == 0) {
            $availability = "Not available";
        } else {
            $availability = "Available";
        }
        //add the animalID to view to the get parameters
        echo '<tr>';
        echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalid"] . "</a> </td>";
        echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["name"] . "</a> </td>";
        echo '<td> ' . $row["type"] . "</td>";
        echo '<td> ' . $gender . "</td>";
        echo '<td> ' . $availability . "</td>";
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
    $sql    = "SELECT * FROM animal";
    $result = $pdo->prepare($sql);
    $result->execute();
    $rows = $result->fetchColumn();
    if ($rows == 0) {
        echo "<p class=\"no_requests\">It seems there are no animals in the system at the moment.</p>";
    } else {
        $q    = "SELECT * FROM animal";
        $rows = $pdo->query($q);

        echo '<div class="displaydata">';
        echo '<h2 class="he2">View all animals</h2>';
        echo '<table class="tabcs">';
        echo '<tbody>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>NAME</th>';
        echo '<th>TYPE</th>';
        echo '<th>GENDER</th>';
        echo '<th>AVAILABILITY</th>';
        echo '</tr>';
        foreach ($rows as $row) {
            if ($row["gender"] == "m" || $row["gender"] == "male") {
                $gender = "Male";
            }else if ($row["gender"] == "f" || $row["gender"] == "fenale") {
                $gender = "Female";
            } else if ($row["gender"] == "o" || $row["gender"] == "other") {
                $gender = "Unknown";
            }
            if ($row["availability"] == 0) {
                $availability = "Not available";
            } else {
                $availability = "Available";
            }
            //add the animalID to view to the get parameters
            echo '<tr>';
            echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalid"] . "</a> </td>";
            echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["name"] . "</a> </td>";
            echo '<td> ' . $row["type"] . "</td>";
            echo '<td> ' . $gender . "</td>";
            echo '<td> ' . $availability . "</td>";
            echo '</tr>';
        }
        echo '</tobdy>';
        echo '</table>';
        echo '</div>';
    }
    ?>';
        }

    // AVAILABLE
else if(x == "sort_available"){
  document.getElementById("selectStatement1").innerHTML = '<?php
  $sql    = "SELECT * FROM animal WHERE availability = 1";
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchColumn();
  if ($rows == 0) {
  echo "<p class=\"no_requests\">It seems there are no available animals in the system at the moment.</p>";
  } else {
  $q    = "SELECT * FROM animal WHERE availability = 1";
  $rows = $pdo->query($q);

  echo '<div class="displaydata">';
  echo '<h2 class="he2">View all animals</h2>';
  echo '<table class="tabcs">';
  echo '<tbody>';
  echo '<tr>';
  echo '<th>ID</th>';
  echo '<th>NAME</th>';
  echo '<th>TYPE</th>';
  echo '<th>GENDER</th>';
  echo '<th>AVAILABILITY</th>';
  echo '</tr>';
  foreach ($rows as $row) {
      if ($row["gender"] == "m" || $row["gender"] == "male") {
          $gender = "Male";
      }else if ($row["gender"] == "f" || $row["gender"] == "fenale") {
          $gender = "Female";
      } else if ($row["gender"] == "o" || $row["gender"] == "other") {
          $gender = "Unknown";
      }
      if ($row["availability"] == 0) {
          $availability = "Not available";
      } else {
          $availability = "Available";
      }
      //add the animalID to view to the get parameters
      echo '<tr>';
      echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalid"] . "</a> </td>";
      echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["name"] . "</a> </td>";
      echo '<td> ' . $row["type"] . "</td>";
      echo '<td> ' . $gender . "</td>";
      echo '<td> ' . $availability . "</td>";
      echo '</tr>';
  }
  echo '</tobdy>';
  echo '</table>';
  echo '</div>';
  }
  ?>';
    }

// NOT AVAILABLE
else if(x == "sort_unavailable"){
  document.getElementById("selectStatement1").innerHTML = '<?php
  $sql    = "SELECT * FROM animal WHERE availability = 0";
  $result = $pdo->prepare($sql);
  $result->execute();
  $rows = $result->fetchColumn();
  if ($rows == 0) {
      echo "<p class=\"no_requests\">It seems there are no unavailable animals in the system at the moment.</p>";
  } else {
  $q    = "SELECT * FROM animal WHERE availability = 0";
  $rows = $pdo->query($q);

  echo '<div class="displaydata">';
  echo '<h2 class="he2">View all animals</h2>';
  echo '<table class="tabcs">';
  echo '<tbody>';
  echo '<tr>';
  echo '<th>ID</th>';
  echo '<th>NAME</th>';
  echo '<th>TYPE</th>';
  echo '<th>GENDER</th>';
  echo '<th>AVAILABILITY</th>';
  echo '</tr>';
  foreach ($rows as $row) {
      if ($row["gender"] == "m" || $row["gender"] == "male") {
          $gender = "Male";
      }else if ($row["gender"] == "f" || $row["gender"] == "fenale") {
          $gender = "Female";
      } else if ($row["gender"] == "o" || $row["gender"] == "other") {
          $gender = "Unknown";
      }
      if ($row["availability"] == 0) {
          $availability = "Not available";
      } else {
          $availability = "Available";
      }
    //add the animalID to view to the get parameters
    echo '<tr>';
    echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalid"] . "</a> </td>";
    echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["name"] . "</a> </td>";
    echo '<td> ' . $row["type"] . "</td>";
    echo '<td> ' . $gender . "</td>";
    echo '<td> ' . $availability . "</td>";
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
