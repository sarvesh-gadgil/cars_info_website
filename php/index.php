<?php
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/accordian.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/heroimage.css">
    <style>
        /* Citing below code from CSS Tables Reference: https://www.w3schools.com/css/css_table.asp */
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
    <title>Our Product Lines</title>
    <link rel="shortcut icon" href="../image/car-favicon.png">
</head>
<body>
<?php include 'navbar.php';?>

<!-- Citing below code from CSS Hero Image reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_hero_image -->
<div class="hero-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(../image/rolls-royce.jpg);">
  <div class="hero-text">
    <h1 style="font-size:60px">Our Product Lines</h1>
  </div>
</div>

<br>
<?php
try {
    $conn = getConnection();
    $getProductLines = $conn->prepare("SELECT productLine, textDescription FROM productlines");
    $accordian = "";
    if ($getProductLines->execute()) {
        while ($row = $getProductLines->fetch(PDO::FETCH_ASSOC)) {
            $productLine = $row['productLine'];
            if ($row['productLine'] != '') {
                $accordian .= "<button class=\"accordion\"><b>" . $productLine . "</b>: " . $row['textDescription'] . "</button>";
                $accordian .= "<div class=\"panel\">";
                try {
                    // Getting the productline data
                    $getProducts = $conn->prepare("SELECT * FROM products where productLine = :productLine");
                    $getProducts->bindValue(':productLine', $productLine);
                    if ($getProducts->execute()) {
                        if ($getProducts->rowCount() == 0) {
                            $accordian .= noDataAvailable();
                        } else {
                            $table = "<br><table>";
                            $table .= "<tr>";
                            $table .= "<th>Product Code</th>";
                            $table .= "<th>Product Name</th>";
                            $table .= "<th>Product Line</th>";
                            $table .= "<th>Product Scale</th>";
                            $table .= "<th>Product Vendor</th>";
                            $table .= "<th>Product Description</th>";
                            $table .= "<th>Quantity in Stock</th>";
                            $table .= "<th>Buy Price</th>";
                            $table .= "<th>MSRP</th>";
                            $table .= "</tr>";
                            while ($row = $getProducts->fetch(PDO::FETCH_ASSOC)) {
                                $table .= "<tr>";
                                $table .= "<td>" . $row['productCode'] . "</td>";
                                $table .= "<td>" . $row['productName'] . "</td>";
                                $table .= "<td>" . $row['productLine'] . "</td>";
                                $table .= "<td>" . $row['productScale'] . "</td>";
                                $table .= "<td>" . $row['productVendor'] . "</td>";
                                $table .= "<td>" . $row['productDescription'] . "</td>";
                                $table .= "<td>" . $row['quantityInStock'] . "</td>";
                                $table .= "<td>" . $row['buyPrice'] . "</td>";
                                $table .= "<td>" . $row['MSRP'] . "</td>";
                                $table .= "</tr>";
                            }
                            $table .= "</table><br>";
                            $accordian .= $table;
                        }
                    }
                } catch (Exception $e) {
                    error_log("Error getting product line: " . $productLine . " and error is: " . $e->getMessage(), 1);
                    handleError("Error getting product line " . $productLine);
                }
                $accordian .= "</div>";
            }
        }
    }
    if ($accordian != "") {
        echo $accordian;
    } else {
        echo noDataAvailable();
    }
} catch (Exception $e) {
    error_log("Error in getting product lines is: " . $e->getMessage(), 1);
    handleError("Error getting product lines.");
} finally {
    $conn = null;
}
?>
<br>
<?php include 'footer.php';?>
<script src="../js/accordian.js"></script>
<script src="../js/active.js"></script>
<script>
    setActivePage("home");
</script>
</body>
</html>
