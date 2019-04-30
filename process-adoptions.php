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

$approve_err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $q = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON  ar.animalid = a.animalid WHERE approval = 0 AND availability = 1"; // Get all the adoption requests that are currently being processed.

    $rows = $pdo->query($q);

    foreach ($rows as $row) {
        $animalid   = $row["animalid"]; //get the animal's ID
        $adoptionid = $row["id"]; // get the adoption request id
        $userid     = $row["userid"];

        $q    = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON ar.animalid = a.animalid WHERE userid = " . $userid;
        $rows = $pdo->query($q);

        $result = $pdo->prepare($q);
        $result->execute();
        foreach ($rows as $row) {
            /*
            1) We use this if statement IN-CASE there are multiple users requesting the same animal, the first person that gets approved of the animal will have the APPROVAL set to 1 (Approved).
            2) After that the animal will then have 0 as the availability. However, the user will still have the approval as 0 since it is still processing for them, meaning we have to check the approval and the availability.
            3) We check the approval for 0 and availability for 0 and then have a statement update their adoption request to 2 (DENIED) since someone has already been approved of that animal.
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
        }

        if (isset($_POST[$adoptionid])) { // First check if  the id is in our post
            if ($_POST[$adoptionid] == "APPROVE") {
                $sql = "UPDATE adoption_requests SET approval = 1 WHERE id = :adoptionid";
                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":adoptionid", $param_adoptionid, PDO::PARAM_STR);
                    $param_adoptionid = $adoptionid;
                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        $setOwner = "INSERT INTO animal_owners (animalid, userid) VALUES (:animalid, :userid)";
                        if ($stmt2 = $pdo->prepare($setOwner)) {
                            // Bind variables to the prepared statement as parameters
                            $stmt2->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);
                            $stmt2->bindParam(":userid", $param_userid, PDO::PARAM_STR);

                            $param_animalid = $animalid;
                            $param_userid   = $userid;

                            if ($stmt2->execute()) {
                                $updateAvailability = "UPDATE animal SET availability = 0 WHERE animalid = :animalid";
                                if ($stmt3 = $pdo->prepare($updateAvailability)) {
                                    // Bind variables to the prepared statement as parameters
                                    $stmt3->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);

                                    $param_animalid = $animalid;

                                    if ($stmt3->execute()) {
                                        $updateRequests = "UPDATE adoption_requests SET approval = 2 WHERE approval != 1 AND animalid = :animalid"; // DENY all the other requests where the animal has not already been approved
                                        if ($stmt4 = $pdo->prepare($updateRequests)) {
                                            // Bind variables to the prepared statement as parameters
                                            $stmt4->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);

                                            $param_animalid = $animalid;

                                            if ($stmt4->execute()) {
                                                header("Refresh:0");
                                            } else {
                                                echo "Oops! Something went wrong. Please try again later.";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                $sql = "UPDATE adoption_requests SET approval = 2 WHERE id = :adoptionid"; // DENY adoption request
                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":adoptionid", $param_adoptionid, PDO::PARAM_STR);
                    $param_adoptionid = $adoptionid;
                    // Attempt to execute the prepared statement
                    if ($stmt->execute()) {
                        header("Refresh:0");
                    }
                }
            }
        } else {
            $approve_err = "Please approve or deny requests made by users."; // If they have not chosen to approve or deny anything.
        }
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Process-adoptions page, here a member of staff can approve or deny a request from a user to adopt an animal.">
    <title>Process Adoptions | Aston Animal Sanctuary</title>
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
        <h1><span style="color: red; text-shadow: -1px -1px 0 #f5b0b0, 1px -1px 0 #0e0e0e, -1px 1px 0 #1b1b1b, 1px 1px 0 #755353;">[Admin]</style><span> <b><?php echo htmlspecialchars($_SESSION["username"]);?></b>. Welcome to Aston Animal Sanctuary.</h1>
    </div>
  </br>
    <p>
        <a href="adminhome.php" class="btn btn-primary btn-lg">Home</a>
        <a href="addanimal.php" class="btn btn-success btn-lg">Add an animal</a>
        <a href="process-adoptions.php" class="btn btn-success btn-lg" style="background-color: #afafaf; border-color: grey;">Process Adoptions</a>
        <a href="viewalladoptions.php" class="btn btn-info btn-lg">View all adoptions</a>
        <a href="allanimals.php" class="btn btn-info btn-lg">View all animals</a>
        <a href="reset-password.php" class="btn btn-warning btn-lg">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger btn-lg">Sign Out of Your Account</a>
    </p>
    <h2 class="Admin-text"><b style="color: #efdb8c;">Admin Panel: Process all the adoptions</b></h2>
    <p>Here you can view all the users that have requested to adopt an animal.</p>
    <p>You can either choose to approve or deny their request, once you have filled out the form, please submit.</p>


    <form action="process-adoptions.php" method="POST">
    <!-- List all animals that are available. Availability is checked in the database where the column number is 1 -->
    <?php
$sql    = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON  ar.animalid = a.animalid WHERE approval = 0 AND availability = 1";
$result = $pdo->prepare($sql);
$result->execute();
$rows = $result->fetchColumn();
if ($rows == 0) {
    echo "<p class=\"no_requests\">It seems there are no adoption requests to process at the moment.</p>";

} else {
    $q    = "SELECT * FROM adoption_requests ar LEFT JOIN animal a ON  ar.animalid = a.animalid WHERE approval = 0 AND availability = 1";
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
    echo '<th>APPROVE</th>';
    echo '<th>DENY</th>';
    echo '</tr>';
    foreach ($rows as $row) {
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
        echo "<td> <input type=\"radio\" name=\"" . $row["id"] . "\" value=\"APPROVE\"> </td>";
        echo "<td> <input type=\"radio\" name=\"" . $row["id"] . "\" value=\"DENY\"> </td>";
        echo '</tr>';
    }
    echo '</tobdy>';
    echo '</table>';
    echo '</br></br></br></br>';
    $error = (!empty($approve_err)) ? 'has-error' : '';
    echo '<div class="form-group "' . $error . '>';
    echo '<input type="submit" class="btn btn-primary btn-lg" value="Submit">';
    echo '<input type="hidden" name="submitted" value="TRUE" />';
    echo '<span class="help-block">' . $approve_err . '</span>';
    echo '</div>';
    echo '</div>';
}
?>
 </form>
</body>
</html>
