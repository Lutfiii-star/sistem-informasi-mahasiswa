<?php
if (isset($_POST['npm'])) {
    $npm = trim($_POST['npm']);

    include "koneksi.php";

    $duplikat_mirip = false;
    $npm_terdaftar = false;

    $query = mysqli_query($conn, "SELECT npm FROM tbl_mahasiswa");
    while ($row = mysqli_fetch_assoc($query)) {
        $existing_npm = $row['npm'];

        // Sama persis
        if ($npm === $existing_npm) {
            $npm_terdaftar = true;
            break;
        }

        // Cek mirip (maks. beda 1 karakter)
        if (strlen($npm) === strlen($existing_npm)) {
            $beda = 0;
            for ($i = 0; $i < strlen($npm); $i++) {
                if ($npm[$i] !== $existing_npm[$i]) {
                    $beda++;
                }
            }
            if ($beda <= 1) {
                $duplikat_mirip = true;
                break;
            }
        }
    }

    if ($npm_terdaftar) {
        echo "❌ NPM sudah terdaftar";
    // } elseif ($duplikat_mirip) {
    //     echo "⚠️ NPM terlalu mirip dengan data yang sudah ada";
    } else {
        echo "✅ NPM tersedia";
    }
}
?>
