function getOrderDetails(orderNumber) {
    // XML HTTP Reference - https://www.w3schools.com/xml/tryit.asp?filename=tryxml_httprequest
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            setModalValue(JSON.parse(xhttp.responseText), orderNumber);
        }
    };
    xhttp.open("GET", "../php/getorderdetails.php?orderNumber=" + orderNumber, true);
    xhttp.send();
}