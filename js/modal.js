function setModalValue(response, orderNumber) {
    if (response.length != 0) {
        // set order id
        document.getElementById("orderNumberID").innerText = orderNumber;
        // check if comments are null and then add comments
        var comments = response[0].comments;
        if (!!comments) {
            document.getElementById("comments").innerText = comments.trim();
        } else {
            document.getElementById("comments").innerText = "Not Available";
        }
        // create table
        var table = "<br><div class=\"outerPane\"><div class=\"pane\">";
        table += "<table><tr><th>Product Code</th><th>Product Line</th><th>Product Name</th></tr>";
        for (var i = 0; i < response.length; i++) {
            var productCode = response[i].productCode,
                productLine = response[i].productLine,
                productName = response[i].productName;
            if (!!productCode) {
                productCode = response[i].productCode.trim();
            } else {
                productCode = "-";
            }

            if (!!productLine) {
                productLine = response[i].productLine.trim();
            } else {
                productLine = "-";
            }

            if (!!productName) {
                productName = response[i].productName.trim();
            } else {
                productName = "-";
            }

            table += "<tr><td>" + productCode + "</td><td>" + productLine +
                "</td><td>" + productName + "</td></tr>";
        }
        table += "</table></div></div><br>";
        document.getElementById("moreInfoTable").innerHTML = table;
        // show modal
        var modal = document.getElementById("moreInfoModal");
        modal.style.display = "block";
    } else {
        // set order id
        document.getElementById("orderNumberIDForNoData").innerText = orderNumber;
        var modal = document.getElementById("noDataAvailable");
        modal.style.display = "block";
    }
}

// Closes more info modal
function closeModal() {
    var modal = document.getElementById("moreInfoModal");
    modal.style.display = "none";
}

// Closes no data availabe modal
function closeModalForNoData() {
    var modal = document.getElementById("noDataAvailable");
    modal.style.display = "none";
}