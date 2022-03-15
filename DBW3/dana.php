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
        <title>Database Berbasis Web - Data Dana</title>
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
            $sql = "SELECT * FROM dana";
            $result = $conn -> query($sql);
            if($result -> num_rows > 0){
                echo "<table class='table table-striped text-center'>";
                echo "<thead class='table-light'>";
                echo "<tr>";
                echo "<th>Kode</th>";
                echo "<th>Jenis</th>";
                echo "<th>Jumlah</th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                while($row = $result -> fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" . $row["kode"] . "</td>";
                    echo "<td>" . $row["jenis"] . "</td>";
                    echo "<td>" . $row["jumlah"] . "</td>";
                    echo "<th>";
                    echo "<button type='button' onclick='updateData(this)' class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#updateDataModal'><i class='fas fa-edit'></i> Update</button>";
                    echo "&nbsp;";
                    echo "<button type='button' onclick='deleteData(this)' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteDataModal'><i class='fas fa-trash'></i> Delete</button>";
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
                            <input type="text" class="form-control" id="insertkode" autocomplete="off">
                            <label for="insertkode">Kode</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="insertjenis" autocomplete="off">
                            <label for="insertjenis">Jenis</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="insertjumlah" autocomplete="off">
                            <label for="insertjumlah">Jumlah</label>
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
                            <input type="text" class="form-control" id="updatekode" autocomplete="off">
                            <label for="updatekode">Kode</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="updatejenis" autocomplete="off">
                            <label for="updatejenis">Jenis</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="updatejumlah" autocomplete="off">
                            <label for="updatejumlah">Jumlah</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="confirmUpdate">Update</button>
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

                var kode = document.getElementById("insertkode").value;
                var jenis = document.getElementById("insertjenis").value;
                var jumlah = document.getElementById("insertjumlah").value;

                window.location.href = "./_config/insert.php?page="+curPage+"&kode="+kode+"&jenis="+jenis+"&jumlah="+jumlah;
            }

            function updateData(element) {
                var row = element.parentNode.parentNode;
                var rowData = row.getElementsByTagName('td');

                var nowkode = rowData[0].innerHTML;
                var jenis = rowData[1].innerHTML;
                var jumlah = rowData[2].innerHTML;

                document.getElementById('updatekode').value = nowkode;
                document.getElementById('updatejenis').value = jenis;
                document.getElementById('updatejumlah').value = jumlah;

                var url=location.href;
                var curPage = url.substring(url.lastIndexOf('/')+1).replace(/\.[^/.]+$/, "");

                document.getElementById('confirmUpdate').addEventListener('click', function(){
                    var kode = document.getElementById('updatekode').value;
                    var jenis = document.getElementById('updatejenis').value;
                    var jumlah = document.getElementById('updatejumlah').value;

                    window.location.href = "./_config/update.php?page=" + curPage + "&nowkode=" + nowkode + "&kode=" + kode + "&jenis=" + jenis + "&jumlah=" + jumlah;

                })

            }
            function deleteData(element) {
                var row = element.parentNode.parentNode;
                var rowData = row.getElementsByTagName('td');
                var kode = rowData[0].innerHTML;

                var url=location.href;
                var curPage = url.substring(url.lastIndexOf('/')+1).replace(/\.[^/.]+$/, "");

                document.getElementById('confirmDelete').addEventListener('click', function(){
                    window.location.href = "./_config/delete.php?page=" + curPage + "&kode=" + kode;
                });
            }
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </body>
</html>