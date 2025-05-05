<?php
if (isset($_GET['npm'])) {
    include "koneksi.php";
    $npm = $_GET['npm'];

    $hapus = mysqli_query($conn, "DELETE FROM tbl_mahasiswa WHERE npm='$npm'");

    if ($hapus) {
        header("Location: index.php?status=berhasil");
    } else {
        header("Location: index.php?status=gagal");
    }
} else {
    header("Location: index.php?status=gagal");
}
