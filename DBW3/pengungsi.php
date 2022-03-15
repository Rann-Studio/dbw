<?php
    session_start();
    if (!isset($_SESSION["ADMINISTRATOR"])) {
        header("Location: index.php");
        exit;
    }
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
        <title>Database Berbasis Web - Data Pengungsi</title>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    </head>
    <body>
        <!-- Nav Bar -->
        <?php include "./frame/navbar.php"; ?>
        <!-- End Nav Bar -->

        <!-- Table -->
        <?php
            $sql = "SELECT * FROM pengungsi";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                echo "<table class='table table-striped text-center'>";
                echo "<thead class='table-light'>";
                echo "<tr>";
                echo "<th>NIK</th>";
                echo "<th>Nama</th>";
                echo "<th>Asal</th>";
                echo "<th>Kode</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row = $result -> fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["nik"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["asal"] . "</td>";
                    echo "<td>" . $row["kode"] . "</td>";
                    echo "<th>";
                    echo "<button type='button' onclick='updateData(this)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#updateDataModal'>Update</button>";
                    echo "&nbsp;";
                    echo "<button type='button' onclick='deleteData(this)' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteDataModal'>Delete</button>";
                    echo "</th>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            }
        ?>

        <!-- Insert Modal -->
        <div class="modal fade" id="insertDataModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Insert New Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="insertnik" autocomplete="off">
                            <label for="insertnik">NIK</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="insertnama" autocomplete="off">
                            <label for="insertnama">Nama</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="insertasal" autocomplete="off">
                            <label for="insertasal">Asal</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="insertkode" aria-label="Default select example">
                                <?php
                                    $sql = "SELECT kode FROM dana";
                                    $result = $conn -> query($sql);
                                    if($result -> num_rows > 0){
                                        while($row = $result -> fetch_assoc()){
                                            echo "<option value='" . $row["kode"] . "'>" . $row["kode"] . "</option>";
                                        }
                                    }
                                ?>
                            </select>
                            <label for="insertkode">Kode</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="insertData()">Insert</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Insert Modal -->

        <!-- Update Modal -->
        <div class="modal fade" id="updateDataModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="updatenik" autocomplete="off">
                            <label for="updatenik">NIK</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="updatenama" autocomplete="off">
                            <label for="updatenama">Nama</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="updateasal" autocomplete="off">
                            <label for="updateasal">Asal</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="updatekode" aria-label="Default select example">
                                <option value="D01">D01</option>
                                <option value="D02">D02</option>
                            </select>
                            <label for="updatekode">Kode</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="confirmUpdate">Update</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Update Modal -->

        <!-- Delete Modal -->
        <div class="modal fade" id="deleteDataModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-danger">Anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Delete Modal -->

        <script>
            function insertData(){
                var url=location.href;
                var curPage = url.substring(url.lastIndexOf('/')+1).replace(/\.[^/.]+$/, "");

                var nik = document.getElementById("insertnik").value;
                var nama = document.getElementById("insertnama").value;
                var asal = document.getElementById("insertasal").value;
                var kode = document.getElementById("insertkode").value;

                window.location.href = "./_config/insert.php?page="+curPage+"&nik="+nik+"&nama="+nama+"&asal="+asal+"&kode="+kode;

            }

            function updateData(element) {
                var row = element.parentNode.parentNode;
                var rowData = row.getElementsByTagName('td');
                var nownik = rowData[0].innerHTML;
                var nama = rowData[1].innerHTML;
                var asal = rowData[2].innerHTML;
                var kode = rowData[3].innerHTML;

                document.getElementById('updatenik').value = nownik;
                document.getElementById('updatenama').value = nama;
                document.getElementById('updateasal').value = asal;
                document.getElementById('updatekode').value = kode;

                var url=location.href;
                var curPage = url.substring(url.lastIndexOf('/')+1).replace(/\.[^/.]+$/, "");

                document.getElementById('confirmUpdate').addEventListener('click', function(){
                    var nik = document.getElementById('updatenik').value;
                    var nama = document.getElementById('updatenama').value;
                    var asal = document.getElementById('updateasal').value;
                    var kode = document.getElementById('updatekode').value;

                    window.location.href = "./_config/update.php?page=" + curPage + "&nownik=" + nownik + "&nik=" + nik + "&nama=" + nama + "&asal=" + asal + "&kode=" + kode;

                })

            }
            function deleteData(element) {
                var row = element.parentNode.parentNode;
                var rowData = row.getElementsByTagName('td');
                var nik = rowData[0].innerHTML;

                var url=location.href;
                var curPage = url.substring(url.lastIndexOf('/')+1).replace(/\.[^/.]+$/, "");

                document.getElementById('confirmDelete').addEventListener('click', function(){
                    window.location.href = "./_config/delete.php?page=" + curPage + "&nik=" + nik;
                });
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>