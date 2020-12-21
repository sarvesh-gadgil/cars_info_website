<?php
require_once 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/modal.css">
    <link rel="stylesheet" href="../css/heroimage.css">
    <style>
        /* Citing below code from CSS Tables Reference: https://www.w3schools.com/css/css_table.asp */
        tr:hover {
            background-color: white;
        }
    </style>
    <title>Ordered Models</title>
    <link rel="shortcut icon" href="../image/car-favicon.png">
</head>
<body>
<?php include 'navbar.php';?>
<?php
function createHeaderInfoMessage($message)
{
    return "<br><span class=\"subHeader leftTab\">" . $message . "</span><br>";
}

function createTableAndHeaders()
{
    $table = "<div class=\"outerPane\"><div class=\"pane\">";
    $table .= "<table>";
    $table .= "<tr>";
    $table .= "<th>Order Number</th>";
    $table .= "<th>Order Date</th>";
    $table .= "<th>Status</th>";
    $table .= "</tr>";
    return $table;
}

function createTableDetails($orderNumber, $orderDate, $status)
{
    $tableDetails = "<tr>";
    $tableDetails .= "<td><a href=\"#!\" class=\"footerLink\" onclick=getOrderDetails(" . $orderNumber . ")>" . $orderNumber . "</a></td>";
    $tableDetails .= "<td>" . $orderDate . "</td>";
    $tableDetails .= "<td>" . $status . "</td>";
    $tableDetails .= "</tr>";
    return $tableDetails;
}

function closeTable()
{
    return "</table></div></div>";
}
?>

<!-- Citing below code from CSS Hero Image reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_hero_image -->
<div class="hero-image" style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(../image/order.jpg);">
  <div class="hero-text">
    <h1 style="font-size:60px">Ordered Models</h1>
  </div>
</div>

<?php
// Create table of all orders currently “In process”
try {
    $conn = getConnection();
    $getOrders = $conn->prepare("SELECT orderNumber, orderDate, status FROM orders WHERE status = 'In process' ORDER BY orderNumber DESC");
    if ($getOrders->execute()) {
        if ($getOrders->rowCount() == 0) {
            echo noDataAvailable();
        } else {
            echo createHeaderInfoMessage("Orders Currently In Process");
            $table = createTableAndHeaders();
            while ($row = $getOrders->fetch(PDO::FETCH_ASSOC)) {
                $table .= createTableDetails($row['orderNumber'], $row['orderDate'], $row['status']);
            }
            $table .= closeTable();
            echo $table;
        }
    }
} catch (Exception $e) {
    error_log("Error getting orders in process: " . $e->getMessage(), 1);
    handleError("Error getting orders in process.");
} finally {
    $conn = null;
}
?>

<?php
// Create table of cancelled orders
try {
    $conn = getConnection();
    $getOrders = $conn->prepare("SELECT orderNumber, orderDate, status FROM orders WHERE status = 'cancelled' ORDER BY orderNumber DESC");
    if ($getOrders->execute()) {
        if ($getOrders->rowCount() == 0) {
            echo noDataAvailable();
        } else {
            echo createHeaderInfoMessage("Cancelled Orders");
            $table = createTableAndHeaders();
            while ($row = $getOrders->fetch(PDO::FETCH_ASSOC)) {
                $table .= createTableDetails($row['orderNumber'], $row['orderDate'], $row['status']);
            }
            $table .= closeTable();
            echo $table;
        }
    }
} catch (Exception $e) {
    error_log("Error getting cancelled orders: " . $e->getMessage(), 1);
    handleError("Error getting cancelled orders.");
} finally {
    $conn = null;
}

?>

<?php
// Create table of 20 recent orders
try {
    $conn = getConnection();
    $getOrders = $conn->prepare("SELECT orderNumber, orderDate, status FROM orders ORDER BY orderNumber DESC LIMIT 20");
    if ($getOrders->execute()) {
        if ($getOrders->rowCount() == 0) {
            echo noDataAvailable();
        } else {
            echo createHeaderInfoMessage("Recent Orders");
            $table = createTableAndHeaders();
            while ($row = $getOrders->fetch(PDO::FETCH_ASSOC)) {
                $table .= createTableDetails($row['orderNumber'], $row['orderDate'], $row['status']);
            }
            $table .= closeTable();
            echo $table;
        }
    }
} catch (Exception $e) {
    error_log("Error getting recent orders: " . $e->getMessage(), 1);
    handleError("Error getting recent orders.");
} finally {
    $conn = null;
}
?>
<br>
<?php include 'footer.php';?>

<!-- Citing below html from reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal2  -->
<div id="moreInfoModal" class="modal section">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModal()">&times;</span>
                More Info about Order Number: <span id="orderNumberID"></span>
            </div>
            <div class="modal-body">
                <div id="moreInfoTable"></div>
                <b>Comments:</b> <span id="comments"></span><br>
            </div>
            <br>
            <div class="modal-footer">
                <button onclick="closeModal()" class="closeButton">Close</button>
            </div>
            <br>
        </div>
</div>

<!-- Citing below html from reference - https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal2  -->
<div id="noDataAvailable" class="modal section">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close" onclick="closeModalForNoData()">&times;</span>
                More Info about Order Number: <span id="orderNumberIDForNoData"></span>
            </div>
            <div class="modal-body" style="text-align:center; padding: 30px">
                No data available for this order number.
            </div>
        </div>
</div>

<script src="../js/order.js"></script>
<script src="../js/modal.js"></script>
<script src="../js/active.js"></script>
<script>
    setActivePage("orders");
</script>
</body>
</html>
