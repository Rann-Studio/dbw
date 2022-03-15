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
        $sql = "DELETE FROM $page WHERE nik = $nik";
    }

    if($page == 'dana'){
        $kode = $_GET["kode"];
        $sql = "DELETE FROM $page WHERE kode = '$kode'";
    }

    if($conn -> query($sql) === TRUE){
        header("Location: ./../$page.php");
    } else {
        header("Location: ./../$page.php");
    }
?>