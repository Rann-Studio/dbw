<?php
    session_start();
    include "./_config/config.php";
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!-- FontAwesome -->
        <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.15.4/css/all.css">
        <!-- Icon -->
        <link rel="icon" href="./assets/images/icon.png" type="image/png">
        <!-- Title -->
        <title>Database Berbasis Web - View All</title>
    </head>

    <body>
        <!-- Nav Bar -->
        <?php include "./frame./navbar.php"; ?>
        <!-- End Nav Bar -->
        
        <!-- Table -->
        <?php
            $sql = "SELECT * FROM pengungsi, dana WHERE pengungsi.kode = dana.kode";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                echo "<table class='table table-striped text-center'>";
                echo "<thead class='table-light'>";
                echo "<tr>";
                echo "<th>NIK</th>";
                echo "<th>Nama</th>";
                echo "<th>Asal</th>";
                echo "<th>Jenis</th>";
                echo "<th>Jumlah</th>";
                echo "<th>Kode</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row = $result -> fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["nik"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["asal"] . "</td>";
                    echo "<td>" . $row["jenis"] . "</td>";
                    echo "<td>" . $row["jumlah"] . "</td>";
                    echo "<td>" . $row["kode"] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>