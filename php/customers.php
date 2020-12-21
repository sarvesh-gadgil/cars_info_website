<?php
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/heroimage.css">
    <style>
         /* Citing below code from CSS Tables Reference: https://www.w3schools.com/css/css_table.asp */
        tr:hover {
            background-color: white;
        }
    </style>
    <title>Our Customers</title>
    <link rel="shortcut icon" href="../image/car-favicon.png">
</head>
<body>
<?php include 'navbar.php';?>

<!-- Citing below code from CSS Hero Image reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_hero_image -->
<div class="hero-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(../image/customer.jpg);">
  <div class="hero-text">
    <h1 style="font-size:60px">Our Customers Around The World</h1>
  </div>
</div>

<?php
function createTableAndHeaders($customerName, $country, $city, $phone)
{
    $table = "<table>";
    $table .= "<tr>";
    $table .= "<th>Customer Name</th>";
    $table .= "<th>Country</th>";
    $table .= "<th>City</th>";
    $table .= "<th>Phone</th>";
    $table .= "</tr>";
    $table .= createTableDetails($customerName, $country, $city, $phone);
    return $table;
}

function startPane()
{
    return "<div class=\"outerPane\"><div class=\"pane\">";
}

function createTableDetails($customerName, $country, $city, $phone)
{
    $tableDetails = "<tr>";
    $tableDetails .= "<td>" . $customerName . "</td>";
    $tableDetails .= "<td>" . $country . "</td>";
    $tableDetails .= "<td>" . $city . "</td>";
    $tableDetails .= "<td>" . $phone . "</td>";
    $tableDetails .= "</tr>";
    return $tableDetails;
}

function closeTableAndPane()
{
    return "</table></div></div><br>";
}

function createHeaderInfoMessage($country)
{
    return "<br><span class=\"subHeader leftTab\">Customers from " . $country . "</span><br>";
}
?>

<?php
try {
    $customerDetails = "";
    $previousCountry = "";
    $isCountryChanged = false;
    $isFirstElement = true;
    $conn = getConnection();
    $getCustomers = $conn->prepare("SELECT customerName, country, city, phone FROM customers ORDER BY country ASC, customerName ASC");
    if ($getCustomers->execute()) {
        if ($getCustomers->rowCount() == 0) {
            $customerDetails .= noDataAvailable();
        } else {
            while ($row = $getCustomers->fetch(PDO::FETCH_ASSOC)) {
                $country = trim($row['country']);
                if ($isFirstElement) {
                    $previousCountry = $country;
                    $customerDetails .= createHeaderInfoMessage($country);
                    // start pane
                    $customerDetails .= startPane();
                }
                if ($country == $previousCountry) {
                    $isCountryChanged = false;
                } else {
                    $isCountryChanged = true;
                    $previousCountry = $country;
                    // close table and pane
                    $customerDetails .= closeTableAndPane();
                    $customerDetails .= createHeaderInfoMessage($country);
                    // start pane
                    $customerDetails .= startPane();
                }
                if (!$isCountryChanged && $isFirstElement) {
                    $isFirstElement = false;
                    // create table
                    $customerDetails .= createTableAndHeaders($row['customerName'], $country, $row['city'], $row['phone']);
                } else if (!$isCountryChanged) {
                    // tr and append
                    $customerDetails .= createTableDetails($row['customerName'], $country, $row['city'], $row['phone']);
                } else {
                    // create table
                    $customerDetails .= createTableAndHeaders($row['customerName'], $country, $row['city'], $row['phone']);
                }
            }
            $customerDetails .= closeTableAndPane();
        }
    }
    if ($customerDetails != "") {
        echo $customerDetails;
    } else {
        echo noDataAvailable();
    }
} catch (Exception $e) {
    error_log("Error getting customers: " . $e->getMessage(), 1);
    handleError("Error getting customers.");
} finally {
    $conn = null;
}
?>
<?php include 'footer.php';?>
<script src="../js/active.js"></script>
<script>
    setActivePage("customers");
</script>
</body>
</html>
