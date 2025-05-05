<?php
// index.php

include "koneksi.php";

// Konfigurasi pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Pencarian
$search = "";
if (isset($_GET['cari']) && $_GET['cari'] != "") {
    $search = mysqli_real_escape_string($conn, $_GET['cari']);
    $sql = "SELECT * FROM tbl_mahasiswa WHERE npm LIKE '%$search%' OR nama LIKE '%$search%' ORDER BY nama ASC LIMIT $offset, $limit";
    $count_sql = "SELECT COUNT(*) FROM tbl_mahasiswa WHERE npm LIKE '%$search%' OR nama LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM tbl_mahasiswa ORDER BY nama ASC LIMIT $offset, $limit";
    $count_sql = "SELECT COUNT(*) FROM tbl_mahasiswa";
}

$query = mysqli_query($conn, $sql);
$total_query = mysqli_query($conn, $count_sql);
$total_data = mysqli_fetch_row($total_query)[0];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sistem Informasi Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom right, #e3f2fd, #bbdefb);
            margin: 0;
            padding: 0;
            color: #0d47a1;
        }

        h1,
        h2 {
            text-align: center;
            margin-top: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 50, 0.3);
        }

        .top-bar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(145deg, #2196f3, #1e88e5);
            padding: 15px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
            border-radius: 0 0 10px 10px;
        }

        .nav-left {
            display: flex;
            gap: 10px;
        }

        .button {
            background: linear-gradient(to right, #42a5f5, #1e88e5);
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 0 #1565c0;
            transition: all 0.2s ease;
        }

        .button:hover {
            background: #1976d2;
            box-shadow: 0 2px 0 #0d47a1;
        }

        .search-box {
            margin-top: 10px;
        }

        .search-container {
            display: flex;
        }

        .search-container input {
            padding: 8px;
            border: 1px solid #90caf9;
            border-radius: 5px 0 0 5px;
            outline: none;
            width: 200px;
        }

        .search-container button {
            padding: 8px;
            background-color: #1565c0;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .desktop-table {
            overflow-x: auto;
            margin: 20px auto;
            width: 95%;
            display: block;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            border: 1px solid #bbdefb;
            text-align: left;
        }

        table th {
            background: linear-gradient(to right, #64b5f6, #2196f3);
            color: white;
        }

        .aksi a {
            text-decoration: none;
            margin-right: 10px;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
        }

        .aksi .edit {
            background-color: #1976d2;
            color: white;
            box-shadow: 0 2px 4px rgba(25, 118, 210, 0.4);
        }

        .aksi .hapus {
            background-color: #d32f2f;
            color: white;
            box-shadow: 0 2px 4px rgba(211, 47, 47, 0.4);
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            padding: 8px 14px;
            margin: 0 5px;
            background-color: #1e88e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0, 0, 100, 0.2);
        }

        .pagination a.active {
            background-color: #0d47a1;
        }

        .mobile-list {
            display: none;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            margin: 10px auto;
            padding: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 90%;
            transition: transform 0.2s ease;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.02);
        }

        .card-header {
            font-weight: bold;
            color: #0d47a1;
        }

        .card-body {
            display: none;
            margin-top: 10px;
            font-size: 14px;
        }

        .card.open .card-body {
            display: block;
        }

        .card .aksi {
            margin-top: 10px;
        }

        .card .aksi a {
            display: inline-block;
            margin-right: 10px;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
        }

        .card .edit {
            background-color: #2196f3;
            color: white;
        }

        .card .hapus {
            background-color: #e53935;
            color: white;
        }

        @media (max-width: 768px) {
            .desktop-table {
                display: none;
            }

            .mobile-list {
                display: block;
            }

            .top-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .nav-left {
                justify-content: center;
                flex-wrap: wrap;
            }

            .search-container input {
                width: 100%;
            }
        }
    </style>


    <script>
        function konfirmasiHapus(npm) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'hapus.php?npm=' + encodeURIComponent(npm);
                }
            });
            return false;
        }

        function toggleDetail(card) {
            card.classList.toggle('open');
        }
    </script>
</head>

<body>
    <h1>Sistem Informasi Mahasiswa</h1>
    <div class="top-bar">
        <div class="nav-left">
            <a class="button" href="index.php"><i class="fa fa-home"></i> Home</a>
            <a class="button" href="tambah.php"><i class="fa fa-plus"></i> Tambah Mahasiswa</a>
        </div>
        <form method="GET" class="search-box">
            <div class="search-container">
                <input type="text" name="cari" placeholder="Cari NPM/Nama..." value="<?= isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : '' ?>">
                <button type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>

    <h2 style="text-align: center; color: #2c3e50;">Data Mahasiswa</h2>

    <div class="desktop-table">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Nama</th>
                    <th>Program Studi</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = $offset + 1;
                while ($data = mysqli_fetch_array($query)) {
                    $npm = str_pad($data['npm'], 9, '0', STR_PAD_LEFT);
                    echo "<tr>
                            <td>$no</td>
                            <td>$npm</td>
                            <td>{$data['nama']}</td>
                            <td>{$data['prodi']}</td>
                            <td>{$data['email']}</td>
                            <td>{$data['alamat']}</td>
                            <td class='aksi'>
                                <a class='edit' href='edit.php?npm={$data['npm']}'>Edit</a>
                                <a class='hapus' href='#' onclick=\"return konfirmasiHapus('{$data['npm']}')\">Hapus</a>
                            </td>
                          </tr>";
                    $no++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="mobile-list">
        <?php
        mysqli_data_seek($query, 0);
        $no = $offset + 1;
        while ($data = mysqli_fetch_array($query)) {
            $npm = str_pad($data['npm'], 9, '0', STR_PAD_LEFT);
            echo "<div class='card' onclick=\"toggleDetail(this)\">
                    <div class='card-header' data-index='$no'>
                        <strong>$npm</strong><br>{$data['nama']}
                    </div>
                    <div class='card-body'>
                        <p><strong>Prodi:</strong> {$data['prodi']}</p>
                        <p><strong>Email:</strong> {$data['email']}</p>
                        <p><strong>Alamat:</strong> {$data['alamat']}</p>
                        <div class='aksi'>
                            <a class='edit' href='edit.php?npm={$data['npm']}'>Edit</a>
                            <a class='hapus' href='#' onclick=\"return konfirmasiHapus('{$data['npm']}')\">Hapus</a>
                        </div>
                    </div>
                  </div>";
            $no++;
        }
        ?>
    </div>

    <div class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            $active = ($i == $page) ? "active" : "";
            $search_param = $search ? "&cari=" . urlencode($search) : "";
            echo "<a class='$active' href='?page=$i$search_param'>$i</a>";
        }
        ?>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                <?php if ($_GET['status'] == 'berhasil'): ?>
                    Swal.fire({
                        icon: 'success',
                        title: 'Operasi berhasil',
                        text: 'Data berhasil diproses!',
                    });
                <?php elseif ($_GET['status'] == 'gagal'): ?>
                    Swal.fire({
                        icon: 'error',
                        title: 'Operasi gagal',
                        text: 'Terjadi kesalahan!',
                    });
                <?php endif; ?>
            });
        </script>
    <?php endif; ?>
</body>

</html>
