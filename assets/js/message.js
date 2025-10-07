$("#typingArea").on("submit", function(e) {
    e.preventDefault();

    // Add a loading indicator
    $("#loadingIndicator").show();

    let formData = new FormData(this);
    formData.append("send", "send");

    let textValue = $("#typingField").val().trim(); 
    formData.append("text", textValue); 

    let fileInputFile = $("#attachFile")[0].files[0];
    if (fileInputFile) {
        formData.append("file", fileInputFile);
    }

    $.ajax({
        type: "POST",
        url: "./../include/messages.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            // Remove the loading indicator when the response is received
            $("#loadingIndicator").hide();

            // Handle the response as needed
        }
    });

    $("#mainSection").scrollTop($("#mainSection")[0].scrollHeight);

    $("#typingField").val("");
});

