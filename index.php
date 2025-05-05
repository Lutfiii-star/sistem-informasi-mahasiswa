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
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #003366;
            margin: 30px 0 10px;
            font-size: 40px;
        }

        .top-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .nav-left {
            margin-right: 20px;
        }

        .nav-left a.button {
            text-decoration: none;
            color: white;
            background-color: #3498db;
            padding: 10px 18px;
            margin-right: 10px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            display: inline-block;
            transition: 0.3s;
        }

        .nav-left a.button:hover {
            background-color: #2980b9;
        }

        .search-container {
            position: relative;
            display: flex;
            justify-content: flex-end;
        }

        .search-container input[type="text"] {
            padding: 10px 40px 10px 14px;
            width: 250px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .search-container button {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #555;
            font-size: 16px;
            cursor: pointer;
        }

        .search-container button:active {
            transform: scale(1.2); /* Enlarge button on click */
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 14px;
            text-align: center;
            font-size: 15px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ecf0f1;
        }

        .aksi a {
            margin: 0 5px;
            padding: 8px 14px;
            border-radius: 6px;
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        .edit {
            background-color: #2ecc71;
        }

        .edit:hover {
            background-color: #27ae60;
        }

        .hapus {
            background-color: #e74c3c;
        }

        .hapus:hover {
            background-color: #c0392b;
        }

        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a {
            text-decoration: none;
            color: #3498db;
            border: 1px solid #3498db;
            padding: 6px 12px;
            margin: 0 4px;
            border-radius: 4px;
            font-weight: bold;
        }

        .pagination a.active {
            background-color: #3498db;
            color: white;
        }

        .pagination a:hover {
            background-color: #2980b9;
            color: white;
        }

        .desktop-table {
            display: block;
        }

        .mobile-list {
            display: none;
        }

        .card {
            background-color: white;
            margin: 10px auto;
            padding: 12px;
            width: 90%;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            cursor: pointer;
        }

        .card-header {
            font-size: 16px;
            color: #2c3e50;
            font-weight: bold;
        }

        .card-body {
            margin-top: 10px;
            display: none;
            font-size: 14px;
            color: #333;
        }

        .card.open .card-body {
            display: block;
        }

        .card-header::before {
            content: attr(data-index);
            font-weight: bold;
            color: #3498db;
            margin-right: 10px;
        }

        .aksi {
            display: flex;
            justify-content: space-between;
        }

        .aksi a {
            padding: 6px 12px;
            font-size: 14px;
            text-align: center;
            width: 45%;
            border-radius: 6px;
        }

        .edit {
            background-color: #2ecc71;
        }

        .edit:hover {
            background-color: #27ae60;
        }

        .hapus {
            background-color: #e74c3c;
        }

        .hapus:hover {
            background-color: #c0392b;
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
                text-align: center;
            }

            .nav-left {
                margin: 10px 0;
            }

            .nav-left .button {
                margin: 5px;
            }

            .search-container {
                position: relative;
                width: 100%;
            }

            .search-container input[type="text"] {
                width: 80%;
                padding: 10px;
                margin-bottom: 10px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 14px;
            }

            .search-container button {
                position: absolute;
                right: 10px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #555;
                font-size: 16px;
                cursor: pointer;
            }

            .search-container button:active {
                transform: scale(1.2);
            }

            .card {
                margin: 15px auto;
                padding: 12px;
                width: 90%;
            }

            .card-header {
                font-size: 18px;
                color: #2c3e50;
                font-weight: bold;
            }

            .card-body {
                font-size: 14px;
                color: #333;
                margin-top: 10px;
            }

            .aksi a {
                padding: 6px 12px;
                font-size: 14px;
                width: 48%;
            }

            .pagination a {
                padding: 6px 12px;
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

    <?php
    include "koneksi.php";
    $limit = 5;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

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
    ?>

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
                    echo "<tr>
                            <td>$no</td>
                            <td>{$data['npm']}</td>
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
            echo "<div class='card' onclick=\"toggleDetail(this)\">
                    <div class='card-header' data-index='$no'>
                        <strong>{$data['npm']}</strong><br>{$data['nama']}
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
        $total_query = mysqli_query($conn, $count_sql);
        $total_data = mysqli_fetch_row($total_query)[0];
        $total_pages = ceil($total_data / $limit);

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
