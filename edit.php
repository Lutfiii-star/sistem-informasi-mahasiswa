<?php
include "koneksi.php";

if (isset($_GET['npm'])) {
    $npm = $_GET['npm'];
    $query = mysqli_query($conn, "SELECT * FROM tbl_mahasiswa WHERE npm='$npm'");
    $data = mysqli_fetch_assoc($query);
    if (!$data) {
        echo "<script>window.location.href='index.php';</script>";
    }
} else {
    echo "<script>window.location.href='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #e8f0fe;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h3 {
            text-align: center;
            color: #0d47a1;
            margin-top: 30px;
            font-size: 26px;
            font-weight: 700;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        form {
            max-width: 500px;
            margin: 30px auto;
            padding: 40px;
            background: linear-gradient(145deg, #ffffff, #f1f5f9);
            border-radius: 16px;
            box-shadow: 12px 12px 30px rgba(0, 0, 0, 0.1), -12px -12px 30px rgba(255, 255, 255, 0.7);
            transition: 0.3s ease;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            box-sizing: border-box;
            width: 100%;
            padding: 14px 18px;
            border: 1px solid #cfd8dc;
            border-radius: 12px;
            font-size: 15px;
            background-color: #f9fafc;
            box-shadow: inset 2px 2px 6px #d1d9e6, inset -2px -2px 6px #ffffff;
            transition: 0.3s ease;
            display: block;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #42a5f5;
            background-color: #ffffff;
            box-shadow: inset 1px 1px 4px #ccc, inset -1px -1px 4px #ffffff;
        }

        input[type="submit"],
        .back-link {
            background: linear-gradient(145deg, #2196f3, #1e88e5);
            color: white;
            padding: 8px 18px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s ease;
            box-shadow: 3px 3px 8px #b0bec5, -3px -3px 8px #ffffff;
            width: auto;
            min-width: 120px;
        }

        input[type="submit"]:hover,
        .back-link:hover {
            transform: translateY(-1px);
            box-shadow: 5px 5px 10px #a0aeb7, -5px -5px 10px #ffffff;
        }

        .back-link {
            background: linear-gradient(145deg, #6c757d, #5a6268);
            color: white;
            text-decoration: none;
            text-align: center;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin-top: 10px;
        }

        @media (max-width: 600px) {
            form {
                padding: 30px 20px;
            }

            input[type="submit"],
            .back-link {
                width: 100%;
                margin-top: 10px;
            }

            .button-container {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <h3>Edit Data Mahasiswa</h3>

    <form method="post">
        <div class="form-group">
            <label for="npm">NPM:</label>
            <input type="text" name="npm" value="<?= $data['npm'] ?>" readonly>
        </div>

        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi:</label>
            <select name="prodi" required>
                <option value="">--Pilih Prodi--</option>
                <?php
                $prodi_list = ["Teknik Informatika", "Sistem Informasi", "Rekayasa Perangkat Lunak"];
                foreach ($prodi_list as $p) {
                    $selected = ($p == $data['prodi']) ? "selected" : "";
                    echo "<option value='$p' $selected>$p</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= $data['email'] ?>">
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea name="alamat"><?= $data['alamat'] ?></textarea>
        </div>

        <div class="button-container">
            <input type="submit" name="update" value="Update Data">
            <a href="index.php" class="back-link">Kembali</a>
        </div>
    </form>

    <?php
    if (isset($_POST['update'])) {
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];

        $update = mysqli_query($conn, "UPDATE tbl_mahasiswa SET 
        nama='$nama',
        prodi='$prodi',
        email='$email',
        alamat='$alamat' 
        WHERE npm='$npm'");

        if ($update) {
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil diperbarui.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'index.php';
            });
        </script>";
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Data gagal diperbarui.',
                confirmButtonText: 'OK'
            });
        </script>";
        }
    }
    ?>

</body>

</html>
