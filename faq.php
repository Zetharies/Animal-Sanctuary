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
    <meta name="description" content="Frequently asked questions page for Aston Animal Sanctuary, here a user can see a list of questions they may have and view the answers for their queries.">
    <title>FAQ | Aston Animal Sanctury</title>
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
      .faq-question{
        color: #ff5a70; /* Cool Red */
      }
      .faq-answer{
        color: #ffffff; /* Cool Green */
      }
    </style>
</head>

<body>
  <div class="wrapper">
    <div class="col-md-7 about-right">
      <h2 class="Terms-Text"><b style="color: #efdb8c;">Frequently asked questions</b></h2>
      <h3 class="Services-Text"><b class="faq-question">1. How do I create an account?</b></h3>
      <p class="faq-answer">To create an account, go to the login or home page, and then click the "Sign up now." button, alternatively, you can <a href="register.php" class="faq-answer" style="text-decoration: underline;">sign up here</a>.</p>

      <h3 class="Data-Privacy-Text"><b class="faq-question">2. How do I view my requests?</b></h3>
      <p class="faq-answer">Once you have successfully registered an account, you will see a "View my requests" tab that will allow you to see all the animals you have requested to adopt.</p>

      <h3 class="Your-Commitment-Text"><b class="faq-question">3. How can I change my password?</b></h3>
      <p class="faq-answer">Login to your account, you will be able to see a "Reset Your Password" tab which will allow you to change your password. You will then need to login to your account again.</p>

      <h3 class="Your-Commitment-Text"><b class="faq-question">4. How can I request an animal?</b></h3>
      <p class="faq-answer">To request an animal, check on the "available for adoptions" tab and filter through the animals you would like to adopt, then select an animal and click on the request button to submit your interest in that animal.</p>

      <h3 class="Your-Commitment-Text"><b class="faq-question">5. How can I check my current adoptions?</b></h3>
      <p class="faq-answer">Once you have submitted a request for an animal, you can visit your home page and you will be able to see all of the animals you have requested.</p>

      <h3 class="Your-Commitment-Text"><b class="faq-question">6. How do I check all of my adoptions?</b></h3>
      <p class="faq-answer">To see all of the information of all your adoptions, visit the "View my requests" tab and you will be able to see all of your requests and the current status of that request.</p>

      <h3 class="Your-Commitment-Text"><b class="faq-question">7. How do I re-request an animal?</b></h3>
      <p class="faq-answer">Visit that animal page and then select to unrequest that animal and then request it again.</p>
    </div>
    </div>
  </div>
</body>
</html>
