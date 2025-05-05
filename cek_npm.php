<?php
include "koneksi.php";

if (isset($_POST['npm'])) {
    $npm = $_POST['npm'];

    // Cek apakah NPM sudah terdaftar
    $stmt = mysqli_prepare($conn, "SELECT npm FROM tbl_mahasiswa WHERE npm = ?");
    mysqli_stmt_bind_param($stmt, "s", $npm);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "NPM sudah terdaftar.";
    } else {
        echo "";
    }

    mysqli_stmt_close($stmt);
}
?>
