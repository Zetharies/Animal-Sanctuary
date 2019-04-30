<?php
session_start();
// Check if the user is logged in, if not then redirect them to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: index.php");
    exit;
}
// Include config file
require_once "config.php";

$id     = $pdo->quote($_GET["id"]); //sanitise, just in case someone has messed with the _GET variables
$gender = $type = "";

//Check who owns this animal
//$owns = $pdo->query("select * from owns where animalid = $id")->fetch();

//if they own the animal then continue
//if ($owns['userid'] == $_SESSION['userid'] || $_SESSION['staff'] == 'true' || $staffowned['staff'] == 1){

//get the animal from the database
$animal     = $pdo->query("SELECT * FROM animal WHERE animalid = $id")->fetch();
$animalName = $animal["name"];
$animalid   = $animal["animalid"];
$userid     = $_SESSION['id'];
$approval   = 0; // 0 is for processing

// Get the animalName from the animal table, we will be using this query to loop through all 'n' images for this animal.
$animalImage = $pdo->query("SELECT image FROM animal_images WHERE animalid = $id")->fetchAll();
//$num_rows = mysql_num_rows($animalImage["image"]); // Amount of rows we will have to loop through for images.
$result      = count($animalImage);

//$count = $pdo->query("select count(*) from animal_images where animalName = '$animalName'")->fetch();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['request_button'] == 'REQUEST') {
        $q = "INSERT INTO adoption_requests (animalid, animalName, userid, approval) VALUES (:animalid, :animalName, :userid, :approval)";

        // INSERT IMAGES INTO ANIMAL_IMAGES
        if ($stmt = $pdo->prepare($q)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);
            $stmt->bindParam(":animalName", $param_animalName, PDO::PARAM_STR);
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
            $stmt->bindParam(":approval", $param_approval, PDO::PARAM_STR);


            // Set parameters
            $param_animalid   = $animalid;
            $param_animalName = $animalName;
            $param_userid     = $userid;
            $param_approval   = $approval;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                //header("Location: userhome.php");
                header("Refresh:0"); // Lets just refresh the page instead of taking them to the homepage.
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    } else if ($_POST['request_button'] == 'UNREQUEST') {

        // Prepare a select statement
        $sql = "DELETE FROM adoption_requests WHERE userid = :userid AND animalid = :animalid";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
            $stmt->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);

            $param_userid   = $userid;
            $param_animalid = $animalid;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                header("Refresh:0");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

    }

    // Close connection
    unset($pdo);
}

if (!empty($animal)) {
    echo "<div class=\"animal-Description\" style=\"margin-top: 5vh;\">";
    echo "<h1>" . $animal["name"] . "</h1> \n";
    echo "<h3>Date of Birth: " . $animal["dob"] . "</h3> \n";

		// GENDERS
    if ($animal["gender"] == "m" || $animal["gender"] == "male") {
        $gender = "Male";
    } else if ($animal["gender"] == "f" || $animal["gender"] == "female") {
        $gender = "Female";
    } else {
        $gender = "Unknown";
    }

		// ANIMAL TYPES
    if ($animal["type"] == "Dog") {
        $type = "Dog";
    } else if ($animal["type"] == "Cat") {
        $type = "Cat";
    } else if ($animal["type"] == "Hamster") {
        $type = "Hamster";
    } else if ($animal["type"] == "Rabbit") {
        $type = "Bunny";
    } else if ($animal["type"] == "Fish") {
        $type = "Fish";
    } else if ($animal["type"] == "Other") {
        $type = "Unknown";
    }

    echo "<div id=\"MagicCarousel\" class=\"carousel slide\" data-ride=\"carousel\">";

    /* Okay, stick with me here because it gets a bit complicated.
    We're going to loop through the amount of rows of images an animal have and display them as indicators.
    We're checking if $i is equal to 0 (this would be the first image so we assign the first indicator to active). After that we assign active to anything after that.
    This is because we can only have one active indicator at a time (this way the user knows what image they are on).
    */
    echo "<ol class=\"carousel-indicators\">";
    $endquery = "";
    for ($i = 0; $i < $result; $i++) {
        if ($i != 0) {
            $endquery = "></li>";
        } else {
            $endquery = " class=\"active\"></li>";
        }
        echo "<li data-target=\"#MagicCarousel\" data-slide-to=\"$i\"" . $endquery;
    }
    echo "</ol>";

    echo "</br></br>"; // Just to add some spacing before showing the animal image(s)
    echo "<div class=\"carousel-inner\" role=\"listbox\">";
    $class = 'carousel-item';
    foreach ($animalImage as $row => $imageName) {
        $active = ($row == 0) ? ' active' : ''; // Took me a while to figure out how to do this (only have the first row be set as active), around 7 hours, was so happy when I finally fixed it haha.

        echo "<div class=\"{$class} {$active}\">";
        echo "<img src=\"includes/animals/" . $imageName["image"] . "\" style=\"margin-left: 5%; margin-bottom: 30%; min-height: 300px; max-height: 300px; min-width: 350px; max-width: 350px;\" class=\"d-block w-100\">";
        echo "</div>";
    }

    echo "</div>";

	    echo "<a style=\"filter: invert(100%);\" class=\"carousel-control-prev\" href=\"#MagicCarousel\" role=\"button\" data-slide=\"prev\">";
	    echo "<span class=\"carousel-control-prev-icon\"></span>";
	    echo "<span class=\"sr-only\">Previous</span>";
	    echo "</a>";

	    echo "<a a style=\"filter: invert(100%);\" class=\"carousel-control-next\" href=\"#MagicCarousel\" role=\"button\" data-slide=\"next\">";
	    echo "<span class=\"carousel-control-next-icon\"></span>";
	    echo "<span class=\"sr-only\">Next</span>";
	    echo "</a>";

    echo "</div>";

    echo "Type: " . $type . "<p></p>\n";
    echo "Gender: " . $gender . "<p></p>\n";

    $sql    = "SELECT count(*) FROM adoption_requests WHERE animalid = $animalid";
    $result = $pdo->prepare($sql);
    $result->execute();
    $interested = $result->fetchColumn();

    //$interest_query = $pdo->query("SELECT * FROM adoption_requests")->fetch();
    echo "Users interested: " . $interested . "<p></p>\n";
    echo "<p style= \"width: 370px; padding-top: 5px; padding-bottom: 10px; word-wrap: break-word;\">" . $animal["description"] . "</p>\n";
    echo "</br>";
    if ($animal["availability"] == 1) {
        echo "<form class=\"process-adoption\" method=\"post\">";
        echo "<span class=\"btn btn-success btn-lg\">Available for adoption.</span>";

        // Prepare a select statement
        $sql = "SELECT animalid FROM adoption_requests WHERE userid = :userid AND animalid = :animalid";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":userid", $param_userid, PDO::PARAM_STR);
            $stmt->bindParam(":animalid", $param_animalid, PDO::PARAM_STR);

            $param_userid   = $userid;
            $param_animalid = $animalid;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    // Check if the user has already submitted a request for this certain animal, if they have, give them the option to unrequest it.
                    echo "<input type=\"submit\" class=\"btn btn-danger btn-lg\" name=\"request_button\" style=\"margin-left: 3%; width: 154px;\" value=\"UNREQUEST\">";
                } else {
                    // They have not yet submitted a request for this animal, so give them an option to request it.
                    echo "<input type=\"submit\" class=\"btn btn-primary btn-lg\" name=\"request_button\" style=\"margin-left: 3%; width: 154px;\" value=\"REQUEST\">";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        echo "</form>";
    } else {
        echo "<span class=\"btn btn-danger btn-lg\">Not available for adoption.</span></p>";
    }
    echo "</div>";
} else {
    echo "<h1>Oops, an animal with this id doesn't exist.</h1>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
        <meta name="description" content="View animals page for Aston Animal Sanctuary, here you can view a list of animals">
    <title>View Animals | Aston Animal Sanctuary</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 550px; padding: 20px; }
    </style>
        <style type="text/css">
        .fouc-fix { display:none; }
    </style>
</head>
<body>
</body>
</html>
