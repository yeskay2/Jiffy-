$(document).ready(function () {
    setInterval(function () {
        if (!$("#search").val()) {
            $.ajax({
                url: "./../include/users.php",
                type: "POST",
                success: function (data) {
                    $("#onlineUsers").html(data);
                }
            });
        } else {
            $("#search").on("keyup", function(){
                let search = $(this).val();
                $.ajax({
                    url: "./../include/search.php",
                    type: "POST",
                    data: { search: search},
                    success: function (data) {
                        $("#onlineUsers").html(data);
                    }
                });
            });
        }
    },500);
});