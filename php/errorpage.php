<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/heroimage.css">
    <style>
        .message {
            text-align: center;
            font-size: 18px;
            font-family: Arial, Helvetica, sans-serif;
        }
        .errorPageLink {
            color: rgb(76, 138, 218);
            text-decoration: none;
        }

        a.errorPageLink:hover {
            text-decoration: underline;
        }
    </style>
    <title>Something went wrong</title>
    <link rel="shortcut icon" href="../image/car-favicon.png">
</head>
<body>
<?php include 'navbar.php';?>

<!-- Citing below code from reference CSS Hero Image reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_hero_image -->
<div class="hero-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(../image/error.png);">
  <div class="hero-text">
    <h1 style="font-size:60px">Sorry. Something Went Wrong...</h1>
  </div>
</div>

<br><br>
<div class="message">
<a href="index.php" class="errorPageLink">Click here to go home ></a>
<br><br>
<?php
$message = $_GET['message'];
echo "<b>Error reason:</b> " . $message;
?>
</div>
<br><br>
<?php include 'footer.php';?>
</body>
</html>