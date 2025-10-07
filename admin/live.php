<?php
session_start();
include "./../include/config.php";
$userid = $_SESSION["user_id"];

if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit; 
}
if (isset($_GET['employee'])) {
    $selectedEmployeeId = $_GET['employee'];
} else {
    $selectedEmployeeId = $userid;
}


$query = "SELECT * FROM user_locations WHERE userid = $selectedEmployeeId"; 
$result = mysqli_query($conn, $query);
$latitude = 0;
$longitude = 0;
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $latitude = $row['latitude'];
    $longitude = $row['longitude'];
    
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Live | Jiffy</title>

    <!-- Favicon -->
    <link href="./../assets/images/Jiffy-favicon.png" rel="icon">

    <link href="./../assets/images/Jiffy-favicon.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="./../assets/css/backend-plugin.min.css">
    <link rel="stylesheet" href="./../assets/css/style.css">
    <link rel="stylesheet" href="./../assets/css/custom.css">
    <link rel="stylesheet" href="./../assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="./../assets/vendor/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-calendar/dist/tui-calendar.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-date-picker/dist/tui-date-picker.css">
    <link rel="stylesheet" href="./../assets/vendor/tui-calendar/tui-time-picker/dist/tui-time-picker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="./../assets/css/icon.css">
    <link rel="stylesheet" href="./../assets/css/card.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<style>
      .search-content{
            display:none;
        }
</style>
</head>

<body>
    <!-- loader Start -->
    <div id="loading">
        <div id="loading-center">
        </div>
    </div>
    <!-- loader END -->


    <!-- Wrapper Start -->
    <div class="wrapper">
        <?php
        include 'topbar.php';
        include 'sidebar.php';
        ?>

        <div class="content-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-md-6">
                                        <h4 class="card-title">Live Location</h4>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <label for="selectEmployee" class="mr-2">Select Employee:</label>
                                        <select id="selectEmployee" onchange="selectEmployeeChanged()">
                                        <?php
                                            $sql = "SELECT id, full_name FROM employee  WHERE active ='active' AND Company_id ='$companyId' ORDER BY full_name  ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {                                                    
                                                    $selected = ($row["id"] == $selectedEmployeeId) ? 'selected' : '';
                                                    echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["full_name"] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body" id="search">
                                <div class="table-responsive">
                                    <div id="map" style="height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Wrapper End-->
    <?php
    include 'footer.php';
    ?>
    <!-- Backend Bundle JavaScript -->
    <script src="./../assets/js/backend-bundle.min.js"></script>

    <!-- Table Treeview JavaScript -->
    <script src="./../assets/js/table-treeview.js"></script>

    <!-- Chart Custom JavaScript -->
    <script src="./../assets/js/customizer.js"></script>

    <!-- Chart Custom JavaScript -->
    <script async src="./../assets/js/chart-custom.js"></script>
    <!-- Chart Custom JavaScript -->
    <script async src="./../assets/js/slider.js"></script>

    <!-- app JavaScript -->
    <script src="./../assets/js/app.js"></script>

    <script src="./../assets/vendor/moment.min.js"></script>
    <script>
        function initMap() {
            const myLatLng = [<?php echo $latitude ?>, <?php echo $longitude ?>];
            const map = L.map("map").setView(myLatLng, 15);           
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            L.marker(myLatLng).addTo(map)
                .bindPopup("Employee Location")
                .openPopup();
        }       
        function selectEmployeeChanged() {
            const selectedEmployeeId = document.getElementById("selectEmployee").value;         
            window.location.href = "live.php?employee=" + selectedEmployeeId;
        }

        window.onload = initMap;
    </script>
</body>

</html>