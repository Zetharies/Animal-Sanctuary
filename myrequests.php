<!-- Name: Zeth Osharode -->
<!-- Student id: 160050888 -->
<!-- University: Aston University -->

<!--
I see you've stumbled into my code
────────────────────────────────
───────────────██████████───────
──────────────████████████──────
──────────────██────────██──────
──────────────██▄▄▄▄▄▄▄▄▄█──────
──────────────██▀███─███▀█──────
█─────────────▀█────────█▀──────
██──────────────────█───────────
─█──────────────██──────────────
█▄────────────████─██──████
─▄███████████████──██──██████ ──
────█████████████──██──█████████
─────────────████──██─█████──███
──────────────███──██─█████──███
──────────────███─────█████████
──────────────██─────████████▀
────────────────██████████
────────────────██████████
─────────────────████████
──────────────────██████████▄▄
────────────────────█████████▀
─────────────────────████──███
────────────────────▄████▄──██
────────────────────██████───▀
────────────────────▀▄▄▄▄▀
-->
<?php
// Initialize the session
session_start();

// Include config file
require_once "config.php";

$userid = $_SESSION['id'];
// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="User request page, here a user can view all the requests that they have made to adopt an animal.">
    <title>View My Requests | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hey, <b><?php echo htmlspecialchars($_SESSION["username"]);?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="userhome.php" class="btn btn-primary btn-lg">Home</a>
        <a href="adopt.php" class="btn btn-info btn-lg">Available for adoption</a>
        <a href="#" class="btn btn-info btn-lg" style="background-color: #afafaf; border-color: grey;">View my requests</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Requests-text"><b style="color: #efdb8c;">My requests</b></h2>
    <!-- List all animals that are available. Availability is checked in the database where the column number is 1 -->
    <?php
    echo "<p>Here you will be able to view all the animals that you have requested to adopt.
    </br>When you have requested to adopt an animal, your status will be \"Processing\". This means one of our staff will determine whether that animal is suitable for you based on factors such as home life.
    </br>If you are denied an animal, if you believe your circumstances have changed, you can re-request for that animal if it is still available.
    </br>If you have been approved an animal, please get in-touch and <a href=\"contact.php\" style=\"color: #acf3ff\">contact us</a> so we can discuss further details of your addoption process such as viewing days.</p>";

    $q    = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON ar.animalid = a.animalid WHERE userid = " . $userid;
    $rows = $pdo->query($q);

    $result = $pdo->prepare($q);
    $result->execute();
    $interested = $result->fetchColumn();
    if ($interested != 0) {
      echo '<div class="displaydata">';
      echo '<h2 class="he2">All my adoption requests</h2>';
      echo '<table class="tabcs">';
      echo '<tbody>';
      echo '<tr>';
      echo '<th>CUSTOM ID</th>';
      echo '<th>ANIMAL ID</th>';
      echo '<th>ANIMAL NAME</th>';
      echo '<th>APPROVAL STATUS</th>';
      echo '</tr>';
    foreach ($rows as $row) {
        /*
        1) if the animal has 0 for the approval, and availability for that animal is 0, set the user to be denied that animal.
        */
        if ($row["approval"] == 0 && $row["availability"] == 0) {
            $sql = "UPDATE adoption_requests SET approval = 2 WHERE id = " . $row["id"]; // DENY adoption request
            if ($stmt = $pdo->prepare($sql)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bindParam(":adoptionid", $param_adoptionid, PDO::PARAM_STR);
                $param_adoptionid = $row["id"];
                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                }
            }
        }
        /*
        1) if the animal has 0 for the approval, set the status to processing
        */
         else if ($row["approval"] == 0) {
            $approval_status = "Processing";
        }
        /*
        1) Else if the animal has been approved by an admin, set the status to approved
        */
        else if ($row["approval"] == 1) {
            $approval_status = "Approved";
        }
        /*
        1) Else the animal has been denied by an admin, set the status to denied
        */
        else {
            $approval_status = "Denied";
        }
        //add the animalID to view to the get parameters
        echo '<tr>';
        echo '<td> ' . $row["id"] . "</td>";
        echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalid"] . "</a> </td>";
        echo '<td> <a href = "viewanimal.php?id=' . $row["animalid"] . '">' . $row["animalName"] . "</a> </td>";
        echo '<td> ' . $approval_status . "</td>";
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</div>';
} else {
    echo "<p>It seems you haven't requested to adopt any animals yet... Please don't miss out on this opportunity and adopt a pet today!</p>";
}
?>
</body>
</html>
