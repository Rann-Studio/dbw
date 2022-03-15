<?php
    session_start();
    if (!isset($_SESSION["ADMINISTRATOR"])) {
        header("Location: index.php");
        exit;
    }
    include "config.php";

    $page = $_GET["page"];

    if($page == 'pengungsi'){
        $nik = $_GET["nik"];
        $nama = $_GET["nama"];
        $asal = $_GET["asal"];
        $kode = $_GET["kode"];
        $sqlCheck = "SELECT * FROM $page WHERE nik = '$nik'";
        $sql = "INSERT INTO $page (nik, nama, asal, kode) VALUES ('$nik', '$nama', '$asal', '$kode')";
    }

    if($page == 'dana'){
        $kode = $_GET["kode"];
        $jenis = $_GET["jenis"];
        $jumlah = $_GET["jumlah"];
        $sqlCheck = "SELECT * FROM $page WHERE kode = '$kode'";
        $sql = "INSERT INTO $page (kode, jenis, jumlah) VALUES ('$kode', '$jenis', '$jumlah')";
    }

    $resultCheck = $conn -> query($sqlCheck);
    if($resultCheck -> num_rows > 0){
        header("Location: ./../$page.php?error=data_sudah_ada");
    } else {
        $conn -> query($sql);
        header("Location: ./../$page.php");
    }
?>