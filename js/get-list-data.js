function getListData(x) {
    if (currentButton) {
        currentButton.style.backgroundColor = "";
        currentButton.style.color = "";
    }
    button = document.getElementById("button-" + x);
    button.style.backgroundColor = "#17252A";
    button.style.color = "white";

    $.ajax({
        type: "POST",
        url: "getListData.php",
        data: {
            'listname': button.innerHTML
        }
    }).done(function(msg) {
        //console.log(msg);
        document.getElementById("current-list-list").innerHTML = msg;
    });
    currentButton = button;
}