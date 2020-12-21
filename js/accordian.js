// Citing below code from CSS Accordian Reference: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_accordion_symbol
// Accordian js code
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        if (this.nextElementSibling.style.maxHeight) {
            // Hiding the old accordian
            for (i = 0; i < acc.length; i++) {
                acc[i].classList.remove("active");
                acc[i].nextElementSibling.style.maxHeight = null;
            }
        } else {
            // Hiding the old accordian
            for (i = 0; i < acc.length; i++) {
                acc[i].classList.remove("active");
                acc[i].nextElementSibling.style.maxHeight = null;
            }

            // Showing onclicked accordian
            this.classList.add("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    });
}