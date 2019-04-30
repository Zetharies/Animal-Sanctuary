<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
require_once "config.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="adopt">
    <title>Adopt an animal | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 300px; }

        .column {
          float: left;
          width: 33.33%;
          padding: 5px;
        }

        /* Clearfix (clear floats) */
        .row::after {
          content: "";
          clear: both;
          display: table;
        }

      @media screen and (max-width: 500px) {
        .column {
          width: 100%;
        }
      }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hey, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="userhome.php" class="btn btn-primary btn-lg">Home</a>
        <a href="adopt.php" class="btn btn-info btn-lg" style="background-color: #afafaf; border-color: grey;">Available for adoption</a>
        <a href="myrequests.php" class="btn btn-info btn-lg">View my requests</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Available-text"><b style="color: #efdb8c;">Animals available for adoption</b></h2>

    <div class="wrapper">
      <div class="form-group">
        <select class="form-control" id="mySelect" onchange="myFunction()">
          <option class="form-control" value="sort_id" selected="selected">Sort by: Animal ID</option>
          <option class="form-control" value="sort_asc">Sort by: Name ASCENDING</option>
          <option class="form-control" value="sort_desc">Sort by: Name DESCENDING</option>
          <option class="form-control" value="sort_type">Sort by: Animal Type</option>
          <option class="form-control" value="sort_gender">Sort by: Animal Gender</option>
        </select>
      </div>
    </div>

<p id="selectStatement1"></p>
<p id="selectStatement2"></p>

<!--
First we have our default animal images for sorting by ID, we have to do this first because te onchange "myFunction" will not display
the animal images UNTIL a user has selected an option, but we do not want this, we want them to see the animals available first.
-->
<script>
document.getElementById("selectStatement1").innerHTML = "";
var x = document.getElementById("mySelect").value;
if(x == "sort_id"){
  document.getElementById("selectStatement1").innerHTML = '<?php
// Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal

$q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE a.availability = 1 GROUP BY a.animalid ORDER BY a.animalid";
$rows = $pdo->query($q);

echo "<div class=\"animal_row\">";
foreach ($rows as $row) {
    echo "<div class=\"column\">";
    echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
    echo "</div>";
}
echo "</div>";
?>';

}
</script>

<script>
function myFunction() {
  document.getElementById("selectStatement1").innerHTML = "";
  var x = document.getElementById("mySelect").value;
  if(x == "sort_id"){
    document.getElementById("selectStatement2").innerHTML = ""; // Have to clear statement 2 just in-case they still have it open

    document.getElementById("selectStatement1").innerHTML = '<?php
$q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE a.availability = 1 GROUP BY a.animalid ORDER BY a.animalid";
$rows = $pdo->query($q);
echo "<div class=\"animal_row\">";
foreach ($rows as $row) {
    echo "<div class=\"column\">";
    echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
    echo "</div>";
}
echo "</div>";
?>';
  } else if(x == "sort_asc"){
    document.getElementById("selectStatement2").innerHTML = ""; // Have to clear statement 2 just in-case they still have it open

    document.getElementById("selectStatement1").innerHTML = '<?php
$q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE a.availability = 1 GROUP BY a.animalid ORDER BY animalName";
$rows = $pdo->query($q);
echo "<div class=\"animal_row\">";
foreach ($rows as $row) {
    echo "<div class=\"column\">";
    echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
    echo "</div>";
}
echo "</div>";
?>';
  } else if(x == "sort_desc"){
    document.getElementById("selectStatement2").innerHTML = ""; // Have to clear statement 2 just in-case they still have it open

    document.getElementById("selectStatement1").innerHTML = '<?php
$q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE a.availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
$rows = $pdo->query($q);
echo "<div class=\"animal_row\">";
foreach ($rows as $row) {
    echo "<div class=\"column\">";
    echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
    echo "</div>";
}
echo "</div>";
?>';
  } else if(x == "sort_type"){
    document.getElementById('selectStatement1').innerHTML =
    '<div class="wrapper">' +
      '<div class="form-group">' +
        '<select name="Type" class="form-control" id="mySelectType" onchange="selectType()">' +
          '<option class="form-control" value="null">Please select the type of animal</option>' +
          '<option class="form-control" value="type_cats">Cats</option>' +
          '<option class="form-control" value="type_dogs">Dogs</option>' +
          '<option class="form-control" value="type_hamsters">Hamsters</option>' +
          '<option class="form-control" value="type_fishes">Fishes</option>' +
          '<option class="form-control" value="type_other">Other</option>' +
        '</select>' +
      '</div>' +
    '</div>';
  } else if(x == "sort_gender"){
    document.getElementById('selectStatement1').innerHTML =
    '<div class="wrapper">' +
      '<div class="form-group">' +
        '<select name="Type" class="form-control" id="mySelectType" onchange="selectType()">' +
          '<option class="form-control" value="null">Please select the type of gender</option>' +
          '<option class="form-control" value="type_gender_male">Male</option>' +
          '<option class="form-control" value="type_gender_female">Female</option>' +
          '<option class="form-control" value="type_gender_other">Other</option>' +
        '</select>' +
      '</div>' +
    '</div>';
  }
}
</script>

<script>
function selectType(){
  document.getElementById("selectStatement2").innerHTML = "";
  var x = document.getElementById("mySelectType").value;
  if(x == "type_cats"){
    document.getElementById("selectStatement2").innerHTML = '<?php
    // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
    $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE type ='Cat' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
    $rows = $pdo->query($q);
    echo "<div class=\"animal_row\">";
    foreach ($rows as $row) {
      echo "<div class=\"column\">";
      echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
      echo "</div>";
    }
    echo "</div>";
    ?>';
  } else if(x == "type_dogs"){
      document.getElementById("selectStatement2").innerHTML = '<?php
      // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
      $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE type ='Dog' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
      $rows = $pdo->query($q);
      echo "<div class=\"animal_row\">";
      foreach ($rows as $row) {
        echo "<div class=\"column\">";
        echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
        echo "</div>";
      }
      echo "</div>";
      ?>';
    } else if(x == "type_hamsters"){
        document.getElementById("selectStatement2").innerHTML = '<?php
        // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
        $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE type ='Hamster' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
        $rows = $pdo->query($q);
        echo "<div class=\"animal_row\">";
        foreach ($rows as $row) {
          echo "<div class=\"column\">";
          echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
          echo "</div>";
        }
    echo "</div>";
    ?>';
      } else if(x == "type_fishes"){
          document.getElementById("selectStatement2").innerHTML = '<?php
          // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
          $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE type ='Fish' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
          $rows = $pdo->query($q);
          echo "<div class=\"animal_row\">";
          foreach ($rows as $row) {
            echo "<div class=\"column\">";
            echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
            echo "</div>";
          }
          echo "</div>";
          ?>';
        } else if(x == "type_other"){
            document.getElementById("selectStatement2").innerHTML = '<?php
            // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
            $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE type ='Other' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
            $rows = $pdo->query($q);
            echo "<div class=\"animal_row\">";
            foreach ($rows as $row) {
                echo "<div class=\"column\">";
                echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
                echo "</div>";
            }
            echo "</div>";
            ?>';
        }

          // ANIMAL GENDERS
          else if(x == "type_gender_male"){
              document.getElementById("selectStatement2").innerHTML = '<?php
              // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
              $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE gender ='m' AND availability = 1 OR gender ='male' AND availability = 1  GROUP BY a.animalid ORDER BY animalName DESC";
              $rows = $pdo->query($q);
              echo "<div class=\"animal_row\">";
              foreach ($rows as $row) {
                  echo "<div class=\"column\">";
                  echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
                  echo "</div>";
              }
              echo "</div>";
              ?>';
            } else if(x == "type_gender_female"){
                document.getElementById("selectStatement2").innerHTML = '<?php
                // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
                $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE gender ='f' AND availability = 1 OR gender ='female' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
                $rows = $pdo->query($q);
                echo "<div class=\"animal_row\">";
                foreach ($rows as $row) {
                    echo "<div class=\"column\">";
                    echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
                    echo "</div>";
                }
                echo "</div>";
                ?>';
              } else if (x == "type_gender_other"){
                  document.getElementById("selectStatement2").innerHTML = '<?php
                  // Our sql statement joins the animal_images table to our animal table, from here we can get all the images and their associated animal
                  $q    = "SELECT * FROM animal a LEFT JOIN animal_images i ON a.animalid = i.animalid WHERE gender ='o' AND availability = 1 OR gender ='other' AND availability = 1 GROUP BY a.animalid ORDER BY animalName DESC";
                  $rows = $pdo->query($q);
                  echo "<div class=\"animal_row\">";
                  foreach ($rows as $row) {
                      echo "<div class=\"column\">";
                      echo "<a href=\"viewanimal.php?id=" . $row["animalid"] . "\">" . "<img src=\"includes/animals/" . $row["image"] . "\" style=\"min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\"></a>";
                      echo "</div>";
                  }
                  echo "</div>";
                  ?>';
                }
}
</script>
</body>
</html>
