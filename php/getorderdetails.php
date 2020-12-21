<?php
require_once 'dbconnect.php';
?>

<?php
try {
    $orderNumber = $_GET['orderNumber'];
    $conn = getConnection();
    $getOrderDetails = $conn->prepare("SELECT a.comments, b.orderNumber, b.productCode, c.productName, c.productLine
    FROM orders a, orderdetails b, products c
    WHERE a.orderNumber = b.orderNumber AND b.productCode = c.productCode AND b.orderNumber = :orderNumber");
    $getOrderDetails->bindParam(":orderNumber", $orderNumber);
    if ($getOrderDetails->execute()) {
        $orderDetails = array();
        $counter = 0;
        while ($row = $getOrderDetails->fetch(PDO::FETCH_ASSOC)) {
            $orderDetails[$counter] = array("comments" => $row['comments'], "orderNumber" => $row['orderNumber'],
                "productCode" => $row['productCode'], "productName" => $row['productName'], "productLine" => $row['productLine']);
            $counter++;
        }
        echo json_encode($orderDetails);
    } else {
        error_log("No Order Available for orderNumber: " . $orderNumber, 1);
        echo json_encode(array());
    }
} catch (Exception $e) {
    error_log("No Order Available for orderNumber: " . $orderNumber, 1);
    echo json_encode(array());
} finally {
    $conn = null;
}
?>