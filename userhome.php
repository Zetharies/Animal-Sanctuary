<?php
// Initialize the session
session_start();

// Check if an admin is logged in, if they are, redirect them to admin home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true &&  $_SESSION["admin"] === true){
    header("Location: adminhome.php");
    exit;
}

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: index.php");
    exit;
}
// Include config file
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="User-homepage for Aston Animal Sanctuary, here you can view animals available for adoption, make adoption requests and view adoption requests.">
    <title>Home | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper {
            width: 50%;
            padding: 20px;
        }
        .col-md-7 {
            width: 100%;
            font-size: 18px;
        }
        .reasons {
            color: #acf3ff;
        }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hey, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="userhome.php" class="btn btn-primary btn-lg" style="background-color: #afafaf; border-color: grey;">Home</a>
        <a href="adopt.php" class="btn btn-info btn-lg">Available for adoption</a>
        <a href="myrequests.php" class="btn btn-info btn-lg">View my requests</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Home-text"><b style="color: #efdb8c;">Home</b></h2>
    <?php
    $sql = "SELECT count(*) FROM adoption_requests, animal WHERE adoption_requests.animalid = animal.animalid AND approval = 0 AND userid = " . $_SESSION['id'];
		$result = $pdo->prepare($sql);
		$result->execute();
		$interested = $result->fetchColumn();
    if($interested == 0){
      echo "<p>Hey there " .  htmlspecialchars($_SESSION["username"]) . ", it seems you don't have any adoption requests. Here are some reasons why we think you should adopt a pet today!
      </br>If you haven't already, we really recommend that you read up on our <a href=\"terms.php\" style=\"color: #acf3ff\">terms and services</a> before adopting.</p>";
      echo "<div class=\"wrapper\">";
        echo "<div class=\"col-md-7 about-right\">";
          echo "<h3 class=\"Services-Text\"><b class=\"reasons\">1. Saving a life</b></h3>";
          echo "<p class=\"First-par\">Every year, around 5 million pets are euthanized around the world. This is because too many pets come into shelters and too few people consider adoption when looking for a pet.
          <p>However, the number of euthanized animals could drastically be reduced if more people adopted pets instead of buying them. When you adopt with Aston Animal Sanctuary, you save a loving animal by making them part of your family and open up shelter space for another animal who might actually need it.</p></p>";

          echo "<h3 class=\"Services-Text\"><b class=\"reasons\">2. It would cost less!</b></h3>";
          echo "<p class=\"Second-par\">Usually when adopting a pet, the cost of first vaccinations, vet checks and deworming is included in the adoption. This can save you some of the costs of adding a new member to your family. You may also save on housebreaking and training expenses.</p>";

          echo "<h3 class=\"Services-Text\"><b class=\"reasons\">3. Receiving an amazing animal</b></h3>";
          echo "<p class=\"Third-par\">Aston animal sanctuary is packed with healthy, loving pets waiting for someone to take them to their new home. Most of our pets ended up here because of a human factors such as moving or divorces, not because the animals did anything wrong. Many are already house-trained and used to living with families,
          i'm sure they would be happy if you welcomed them into your home</p>";

        echo "<h3 class=\"Services-Text\"><b class=\"reasons\">4. It goes towards a great cause!</b></h3>";
        echo "<p class=\"Fourth-par\">By adopting an animal through Aston Animal Sanctuary, you are welcoming a new member of a family into your life, giving someone a new home, in return giving you joy and happiness for the long run. As well as increasing Zeth's chances of getting a high coursework grade.</p>";
        echo "</div>";
      echo "</div>";
    } else {
      echo "<p>Thanks for choosing Aston Animal Sanctuary as your adoption agency. </br>
      Here you can view all of the animals you have currently chosen to adopt.</br>
      If you wish for more information about your requested adoptions, please visit the 'View my requests' tab.
      </br>Here is a list of all the animals you have as pending adoptions:</p>";
      $q = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON ar.animalid = a.animalid WHERE approval = 0 AND availability = 1 AND userid = " . $_SESSION['id'];
      $rows = $pdo->query($q);
      echo '<div class="displaydata">';
      echo '<h2 class="he2">Current adoption requests</h2>';
      echo '<table class="tabcs">';
        echo '<tbody>';
        echo '<tr>';
        echo '<th>ANIMAL ID</th>';
        echo '<th>ANIMAL NAME</th>';
        echo '<th>ANIMAL TYPE</th>';
        echo '</tr>';
      foreach ($rows as $row) {
        //add the animalID to view to the get parameters
        echo '<tr>';
          echo '<td> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["animalid"] . "</a> </td>" ;
          echo '<td> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["animalName"] . "</a> </td>" ;
          echo '<td> <a href = "viewanimal.php?id=' .$row["animalid"] . '">' . $row["type"] . "</a> </td>" ;
        echo '</tr>';
      }
        echo '</tobdy>';
      echo '</table>';
      echo '</div>';
    }

     ?>
</body>
</html>
