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
    <meta name="description" content="About page">
    <title>About Us | Aston Animal Sanctury</title>
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
    </style>
</head>

<body>
  <div class="wrapper">
    <div class="row">
      <div class="col-md-5">
        <div class="about-image">
          <img src="includes/assets/adopt.ico"/>
        </div>
      </div>
    </br>
    <div class="col-md-7 about-right">
      <h2 class="About-Us-Text"><b style="color: #efdb8c;">About Us</b></h2>
      <p class="First-par">Here at Aston Animal Sanctuary, our mission is to run a successful sanctuary where animal can be looked after before being adopted to the public.</p>
      <p class="Second-par">We strive to give our animals the best homes and provide a valuable source of adoption to all our clients, making as smooth a transaction for adopting an animal and delivering it to a friendly,
      stable environment. Most of our pets are loud, quiet, fluffy and large. They each come with their own unique personality and have lots of love to go around. It is up to you to give them the care that most of
      them have never had.</p>
      <p class="First-par">Whilst you are browsing for you new member of the family, we are giving lots of care to our animals, making sure that they are getting lots of rest, food and all the love needed</p>
      <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='register.php'">Sign Up</button>  <!-- Have to use window.location.href to redirect buttons with bootstrap -->
    </div>
    </div>
  </div>
</body>
</html>
