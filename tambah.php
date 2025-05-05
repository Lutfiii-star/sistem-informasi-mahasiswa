<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Tambah Data Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f2f6fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h3 {
            text-align: center;
            color: #0d47a1;
            margin-top: 40px;
            font-size: 28px;
            font-weight: 700;
        }

        p {
            text-align: center;
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        form {
            width: 90%;
            max-width: 500px;
            margin: auto;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 6px;
            color: #1a237e;
        }

        input[type="text"],
        input[type="email"],
        textarea,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cfd8dc;
            border-radius: 10px;
            font-size: 15px;
            background-color: #f8fafc;
            transition: 0.3s ease;
            box-sizing: border-box;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #42a5f5;
            background-color: #ffffff;
        }

        select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg fill='gray' height='24' viewBox='0 0 24 24' width='24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        input[type="submit"],
        .btn-cancel {
            background-color: #2196f3;
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 25px;
            display: inline-block;
            text-decoration: none;
        }

        input[type="submit"]:hover {
            background-color: #1e88e5;
        }

        .btn-cancel {
            background-color: #cfd8dc;
            color: #333;
            margin-left: 12px;
        }

        .btn-cancel:hover {
            background-color: #b0bec5;
        }

        #npm-msg {
            font-size: 13px;
            margin-top: 4px;
            color: red;
        }

        @media (max-width: 600px) {
            form {
                padding: 30px 20px;
            }

            input,
            textarea,
            select {
                font-size: 14px;
            }

            input[type="submit"],
            .btn-cancel {
                font-size: 14px;
                padding: 10px 20px;
            }
        }
    </style>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function cekNpm(npm) {
            if (npm.length < 3) {
                document.getElementById("npm-msg").innerText = "";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cek_npm.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("npm-msg").innerText = xhr.responseText;
                }
            };
            xhr.send("npm=" + encodeURIComponent(npm));
        }
    </script>
</head>

<body>
    <h3>Entry Data Mahasiswa</h3>
    <p>Silakan masukkan data mahasiswa berdasarkan formulir berikut:</p>

    <form action="" method="post">
        <div class="form-group">
            <label for="npm">NPM:</label>
            <input type="text" name="npm" id="npm" required
                   inputmode="numeric"
                   pattern="\d{9}"
                   maxlength="9"
                   onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                   onkeyup="cekNpm(this.value)">
            <div id="npm-msg"></div>
        </div>

        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <div class="form-group">
            <label for="prodi">Program Studi:</label>
            <select name="prodi" id="prodi" required>
                <option value="">--Pilih Prodi--</option>
                <option value="TI">Teknik Informatika</option>
                <option value="SI">Sistem Informasi</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea name="alamat" id="alamat" rows="3" required></textarea>
        </div>

        <div style="text-align: center; margin-top: 20px;">
            <input type="submit" name="submit" value="Simpan Data">
            <a href="index.php" class="btn-cancel">Batal</a>
        </div>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $npm = trim($_POST['npm']);
        $nama = $_POST['nama'];
        $prodi = $_POST['prodi'];
        $email = $_POST['email'];
        $alamat = $_POST['alamat'];

        // Validasi NPM harus 9 digit angka
        if (!preg_match('/^\d{9}$/', $npm)) {
            echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Gagal',
                text: 'NPM harus terdiri dari 9 digit angka!',
                confirmButtonColor: '#f57c00'
            });
            </script>";
            return;
        }

        include "koneksi.php";

        $cek_npm = mysqli_prepare($conn, "SELECT npm FROM tbl_mahasiswa WHERE npm = ?");
        mysqli_stmt_bind_param($cek_npm, "s", $npm);
        mysqli_stmt_execute($cek_npm);
        mysqli_stmt_store_result($cek_npm);

        if (mysqli_stmt_num_rows($cek_npm) > 0) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'NPM sudah terdaftar!',
                confirmButtonColor: '#d33'
            });
            </script>";
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO tbl_mahasiswa (npm, nama, prodi, email, alamat) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssss", $npm, $nama, $prodi, $email, $alamat);
            $hasil = mysqli_stmt_execute($stmt);

            if ($hasil) {
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil disimpan',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    window.location.href = 'index.php';
                });
                </script>";
            } else {
                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Data gagal disimpan',
                    confirmButtonColor: '#d33'
                });
                </script>";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_stmt_close($cek_npm);
    }
    ?>
</body>

</html>