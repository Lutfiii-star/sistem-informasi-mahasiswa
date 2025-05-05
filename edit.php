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
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        h3 {
            text-align: center;
            color: #0d47a1;
            margin-top: 30px;
            font-size: 26px;
            font-weight: 700;
        }

        form {
            max-width: 500px;
            margin: 30px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
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
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            background-color: #f9f9f9;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 12px 24px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 48%;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .back-link {
            display: inline-block;
            padding: 12px 24px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            width: 48%;
            margin-top: 10px;
            text-align: center;
        }

        .back-link:hover {
            background-color: #5a6268;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
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
        <textarea name="alamat" rows="3"><?= $data['alamat'] ?></textarea>
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
