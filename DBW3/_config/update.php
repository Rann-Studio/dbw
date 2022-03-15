<?php
    session_start();
    if (!isset($_SESSION["ADMINISTRATOR"])) {
        header("Location: index.php");
        exit;
    }
    include "config.php";

    $page = $_GET["page"];

    if($page == 'pengungsi'){
        $nownik = $_GET["nownik"];
        $nik = $_GET["nik"];
        $nama = $_GET["nama"];
        $asal = $_GET["asal"];
        $kode = $_GET["kode"];
        $sql = "UPDATE $page SET nik = '$nik', nama = '$nama', asal = '$asal', kode = '$kode' WHERE nik = $nownik";
    }

    if($page == 'dana'){
        $nowkode = $_GET["nowkode"];
        $kode = $_GET["kode"];
        $jenis = $_GET["jenis"];
        $jumlah = $_GET["jumlah"];
        $sql = "UPDATE $page SET kode = '$kode', jenis = '$jenis', jumlah = $jumlah WHERE kode = '$nowkode'";
        echo '<script>console.log("'.$sql.'");</script>';
    }
    
    try {
        $conn -> query($sql);
        header("Location: ./../$page.php");
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            header("Location: ./../$page.php?error=duplicate_key");
        } else {
            header("Location: ./../$page.php?error=unknown");
        }
    }
?>