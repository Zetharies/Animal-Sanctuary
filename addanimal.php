<?php
// Initialize the session
session_start();

// Checks to see if a user is logged in and is trying to access addanimal url without being an admin
if(isset($_SESSION["loggedin"]) && $_SESSION["admin"] !== true || $_SESSION["loggedin"] === true && $_SESSION["admin"] !== true){
    header("Location: userhome.php");
    exit;
}

// Check if the user is logged in, if not then redirect them to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: index.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$name = $password = $animalid = "";
$name_error = $dob_error = $gender_error = $type_error = $description_error = $file_error = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate name. Animals can have the same name, so we do not need to prepare any statements
    if(empty(trim($_POST["name"]))){
        $name_error = "Please enter a name.";
    } else { // Unlike usernames, animals can have the same name so we do not need to check if an animal has the same name as another.
        $name = trim($_POST["name"]);
        $stmt = $pdo->query("SELECT * FROM animal WHERE animalid = (SELECT MAX(animalid) FROM animal)");
        $animalid = $stmt->fetchColumn(); // Get the latest id
        $animalid += 1; // Add 1 to the id (this will be the newest id for the new animal)
    }

    // Validate Date of Birth
    if($_POST["Day"] === "Day"){
        $dob_error = "Please enter a day.";
    } else if($_POST["Month"] === "Month"){
        $dob_error = "Please enter a month.";
    } else if($_POST["Year"] === "Year"){
        $dob_error = "Please enter a year.";
    } else {
      $year = $_POST["Year"];
      $month = $_POST["Month"];
      $day = $_POST["Day"];
      $dob = "$year-$month-$day";
    }

    // Validate name. Animals can have the same name, so we do not need to prepare any statements
    //$validateButtons = $_POST["Gender"];
    if(!isset($_POST["Gender"])){
        $gender_error = "Please select a gender.";
    } else {
      $gender = $_POST["Gender"];
    }

    // Validate Type of animal
    if($_POST["Type"] === "Type"){
        $type_error = "Please select a type of animal.";
    } else {
      $type = $_POST["Type"];
    }

    // Validate Description
    if(empty(trim($_POST["description"]))){
        $description_error = "Please add a description.";
    } else {
      $description = (trim($_POST["description"]));
    }

    $availability = 1; // Set the availability to one by default.

    // Validate File upload
    foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
      // Check if no file was chosen. By default PHP values are 2MB for upload_max_filesize, 8MB for post_max_size.
      if(empty($_FILES['files']['tmp_name'][$key])){
      $file_error = "Please select your image(s). 2MB max";
      }
    }


    // Check input errors before inserting in database
    if(empty($name_error) && empty($dob_error) && empty($gender_error) && empty($type_error) && empty($description_error) && empty($file_error)){

      // inserting animal data into database
      $animal_data_sql = "INSERT INTO animal (name, dob, description, availability, gender, type) VALUES (:name, :dob, :description, :availability, :gender, :type)";

      // INSERT DATA INTO ANIMALS
      if($stmt = $pdo->prepare($animal_data_sql)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":name", $param_name, PDO::PARAM_STR);
          $stmt->bindParam(":dob", $param_dob, PDO::PARAM_STR);
          $stmt->bindParam(":description", $param_description, PDO::PARAM_STR);
          $stmt->bindParam(":availability", $param_availability, PDO::PARAM_STR);
          $stmt->bindParam(":gender", $param_gender, PDO::PARAM_STR);
          $stmt->bindParam(":type", $param_type, PDO::PARAM_STR);

          // Set parameters
          $param_name = $name;
          $param_dob = $dob;
          $param_description = $description;
          $param_availability = $availability;
          $param_gender = $gender;
          $param_type = $type;


          // Attempt to execute the prepared statement
          if($stmt->execute()){
              // Redirect to login page
              header("Location: index.php");
          } else{
              echo "Something went wrong. Please try again later.";
          }
      }

        // check files are set or not
        if(isset($_FILES['files'])){

        $errors= array();
        $desired_dir="includes/animals/"; // replace with your directory name where you want to store images
        // getting files array
        foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){

            $file_name = $_FILES['files']['name'][$key];
            $file_size =$_FILES['files']['size'][$key];
            $file_tmp =$_FILES['files']['tmp_name'][$key];
            $file_type=$_FILES['files']['type'][$key];

            $allowedExtensions = array('jpg', 'gif', 'jpeg', 'png', 'bmp', 'wbmp');

            $extension = end(explode('.',$file_name));
            //is the extension allowed?
            if(in_array($extension, $allowedExtensions)){
              $filename=time().$file_name; // for creating unique file name

              if(empty($errors)==true) {
                  // moving files to destination
                  $move=move_uploaded_file($file_tmp,$desired_dir.$filename);
                  // you can direct write move_uploaded files method in bellow if condition
                  if($move) {
                      // inserting image data into database
                    //$stmt = $pdo->query("SELECT animalid FROM animal ORDER BY animalid DESC LIMIT 1");
                    //$animalid = $stmt->fetch();
                      $animal_image_sql = "INSERT INTO animal_images (animalName, image, animalid) VALUES (:name, :filename, :animalid)";

                      // INSERT IMAGES INTO ANIMAL_IMAGES
                      if($stmt = $pdo->prepare($animal_image_sql)){
                          // Bind variables to the prepared statement as parameters
                          $stmt->bindParam(":name", $param_animalName, PDO::PARAM_STR);
                          $stmt->bindParam(":filename", $param_name, PDO::PARAM_STR);
                          $stmt->bindParam("animalid", $param_animalid, PDO::PARAM_STR);

                          // Set parameters
                          $param_animalName = $name;
                          $param_name = $filename;
                          $param_animalid = $animalid;


                          // Attempt to execute the prepared statement
                          if($stmt->execute()){
                              // Redirect to login page
                              echo "done";
                          } else{
                              echo "Something went wrong. Please try again later.";
                          }
                      }

                      // echo "The file ".$filename." has been uploaded"; // only for debugging
                  } else {
                      // echo $filename."is not uploaded"; // use this for debugging otherwise remove it
                  }
              } else {
                  $file_error = $errors;
                  $filename = "NotAvailable.jpg";
              }

            }
          }
        }

        // Close statement
        unset($stmt);
    }

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Add an animal page for Aston Animal Sanctuary, here an adiminstrator can add an animal to the system">
    <title>Add animal | Aston Animal Sanctuary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
        head { }
        body{ font: 14px sans-serif; }
        .wrapper{ width: 550px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <form class="form-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="margin-top: 5vh;" enctype="multipart/form-data">
          <h2>Add an animal</h2>
          <p>Please fill this form in order to add an animal.</p>
            <div class="form-group <?php echo (!empty($name_error)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{2,15}$" title="Must start with a Letter | Min 3 characters | Max 15 characters | No illegal symbols" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($dob_error)) ? 'has-error' : ''; ?>">
                <label>Date of Birth</label>
                <br/>

                <div class="dob" style="display:inline-flex; width:100%">
                  <!-- Day -->
                  <select name="Day" class="form-control">
          				<option class="form-control">Day</option>
          				<?php
            				for ($i = 1; $i <= 31; $i++){
            				echo '<option value=' . $i . ' class="form-control">' . $i . '</option>';
            			   }
          			  ?>
          			</select>

                <!-- Month -->
                <select name="Month" class="form-control">
            				<option class="form-control">Month</option>
            				<?php
            				for ($i = 1; $i <= 12; $i++){
            				echo '<option value=' . $i . ' class="form-control">' . $i . '</option>';
            			}
            			?>
                </select>

                <!-- Month -->
                <select name="Year" class="form-control">
            				<option class="form-control">Year</option>
            				<?php
                    $year = date('Y');
                    $year_limit = 1905;
            				for ($i = $year; $i >= $year_limit; $i--){
            				echo '<option value=' . $i . ' class="form-control">' . $i . '</option>';
            			}
            			?>
                </select>

              </div>

                <span class="help-block"><?php echo $dob_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($type_error)) ? 'has-error' : ''; ?>">
                <label>Gender</label>
                <br/>
                <input type="radio" name="Gender" value="male" />Male
                <input type="radio" name="Gender" value="female" />Female
                <input type="radio" name="Gender" value="other" />Other
                <span class="help-block"><?php echo $gender_error; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($type_error)) ? 'has-error' : ''; ?>">
                <label>Type</label>
                <select name="Type" class="form-control">
            				<option class="form-control">Type</option>
                    <option class="form-control">Dog</option>
                    <option class="form-control">Cat</option>
                    <option class="form-control">Hamster</option>
                    <option class="form-control">Fish</option>
                    <option class="form-control">Other</option>
                </select>
                <span class="help-block"><?php echo $type_error; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($type_error)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <textarea name="description" rows="5" cols="51" class="form-control"></textarea>
                <span class="help-block"><?php echo $description_error; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($type_error)) ? 'has-error' : ''; ?>">
                <label>Image(s)</label>
                <input name="files[]" type="file" multiple="multiple" accept="image/x-png, image/gif, image/jpeg" /> <!-- multiple tag allows us to select multiple files, accept tag only accepts certain files -->
                <span class="help-block"><?php echo $file_error; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-success btn-lg" value="Confirm">
                <button type="button" class="btn btn-danger btn-lg" onclick="window.location.href='adminhome.php'">Cancel</button>  <!-- Have to use window.location.href to redirect buttons with bootstrap -->
            </div>
        </form>
    </div>
</body>
</html>
