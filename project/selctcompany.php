<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["databaseSelect"])) {
    $selectedDatabase = $_POST["databaseSelect"];
    $_SESSION["databasename"] = $selectedDatabase;
    if (!empty($_SESSION["databasename"])) {
        header("location: index.php");
        exit;  
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="databaseSelect">Select Database:</label>
    <select name="databaseSelect" id="databaseSelect">
        <option value="jiffy2">Database 1</option>
        <option value="mine">Database 2</option>        
    </select>
    <input type="submit" value="Save">
</form>

<script>
    document.getElementById('databaseSelect').addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue !== '') {
           
        }
    });
</script>

</body>
</html>
