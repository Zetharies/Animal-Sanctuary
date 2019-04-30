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
  require_once "header.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Terms page for Aston Animal Sanctuary, here a user can view the terms and services for our website.">
    <title>Terms | Aston Animal Sanctury</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="includes/css/style.css">
    <link rel="shortcut icon" href="includes/assets/adopt.ico" />
    <style type="text/css">
      body{ font: 14px sans-serif; }
      .wrapper{ width: 550px; padding: 20px; }
      img { width: 250px; height: auto;}
      .col-md-5{
        margin-left: 1%;
      }
      .col-md-7{
        width: 100%;
        font-size: 18px;
      }
      .our-services{
        color: #acf3ff; /* Cool Blue */
      }
    </style>
</head>

<body>
  <div class="wrapper">
    <div class="col-md-7 about-right">
      <h2 class="Terms-Text"><b style="color: #efdb8c;">Terms and conditions</b></h2>
      <h3 class="Services-Text"><b class="our-services">1. Our services</b></h3>
      <p class="First-par">We strive to find the right homes for our animals. To help advance our mission, we carefully take a look at all the requests that have been made by determining which animal is most suitable to a user.
      By using our services, you agree that we can change these terms at any time.</p>

      <h3 class="Data-Privacy-Text"><b class="our-services">2. Our Data Policy and your privacy</b></h3>
      <p class="Second-par">We will be collecting personal data from you in order to give you the best experience possible and make your adoption process go as smoothly as we can. You can learn
      about how we collect and use your data from a member of staff in our <a href="contact.php" style="text-decoration: underline;">contact page</a>.</p>

      <h3 class="Your-Commitment-Text"><b class="our-services">3. Your commitment</b></h3>
      <p class="Second-par">We provide this adoption service in order to help advance our mission. In exchange, we require you to:</p>
      <ul><br><br><br><br><br><br>
        <li>Help Zeth get a minimum of 95% on this coursework.</li>
        <li>Only request animals you are truly interested in.</li>
        <li>Use valid user details.</li>
      </ul><br><br><br><br>
      <i>Date of last revision:</i> 09/04/2019
      <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='register.php'">I agree to these terms</button>  <!-- Have to use window.location.href to redirect buttons with bootstrap -->
    </div>
    </div>
  </div>
</body>
</html>
