<!-- ======= Header ======= -->
<?php
$path = "./../assets2/img/Jiffy-logo.png";

if (!file_exists($path)) {
    $path = "assets2/img/Jiffy-logo.png"; 
}

?>
<header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center">
            <img src="<?=$path?>" alt="Logo" style="height: 60px; width: 100px;">
        </a>
    </div>
</header>