<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Surat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="updatePassword.css">
    <link rel="stylesheet" type="text/css" href="logout.css">

    <script>
        function confirmSave() {
            return confirm("Apakah Anda ingin menyimpan data ini?");
        }

        function toggleProfileOptions() {
            const profileOptions = document.getElementById("profilelogout");
            profileOptions.style.display = profileOptions.style.display === "block" ? "none" : "block";
        }

        function updatePassword() {
            window.location.href = 'updatePassword.php';
        }

        function confirmLogout() {
            if (confirm("Apakah Anda yakin ingin keluar?")) {
                window.location.href = 'logout.php';  // Redirect to logout.php if confirmed
            }
        }

        function confirmPasswordChange(event) {
            if (!confirm("Apakah Anda yakin ingin mengubah password ini?")) {
                event.preventDefault(); // Prevent form submission if not confirmed
            }
        }

        // This function will be called from the PHP script after a successful password change
        function showSuccessAlert() {
            alert("Password Anda berhasil diubah.");
        }
    </script>
</head>
<body>
    <?php
    session_start();

    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Mengambil data dari sesi
    $nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
    $level_pengguna = isset($_SESSION['level']) ? $_SESSION['level'] : '';

    // Check if there's a success message in the URL
    $password_changed = isset($_GET['success']) && $_GET['success'] === 'true';
    ?>
    <div class="sidebar">
        <div class="header">
            <div class="logo">
                <img src="image/logo.png" alt="Logo">
            </div>
            <div class="nama">
                <p>ARSIP SURAT MADAWAT</p>
            </div>
        </div>

        <div class="headerr">
            <div class="profil">
                <img src="image/profile.png" alt="Profil">
            </div>
            <div class="namaa">
                <p>Welcome,</p>
                <span>
                    <?php echo htmlspecialchars($nama_pengguna); ?> (<?php echo htmlspecialchars($level_pengguna); ?>)
                </span>
            </div>
        </div>

       <!-- Isi Sidebar -->
        <a href="dashboard.php" style="background-color: black;"><i class="fa fa-fw fa-home"></i> Dashboard</a>
        
        <!-- Tampilkan menu data surat jika pengguna bukan kepala lurah -->
        <?php if ($level_pengguna !== 'kepala lurah') : ?>
        <div class="dropdown">
            <a href="" style="background-color: black;"><i class="fa fa-fw fa-edit"></i> Data Surat</a>
            <div class="dropdown-content" style="background-color: black;">
                <a href="dataSuratmasuk.php">Surat Masuk</a>
                <a href="dataSuratkeluar.php">Surat Keluar</a>
            </div>
        </div>
        <?php endif; ?>
        
        <div class="dropdown1">
            <a href="" style="background-color: black;"><i class="fa fa-fw fa-print"></i> Cetak Laporan</a>
            <div class="dropdown-content1" style="background-color: black;">
                <a href="laporansuratmasuk.php">Laporan Surat Masuk</a>
                <a href="laporansuratkeluar.php">Laporan Surat Keluar</a>
            </div>
        </div>
        
        <!-- Tampilkan menu pengguna jika pengguna bukan kepala lurah -->
        <?php if ($level_pengguna !== 'kepala lurah') : ?>
        <div>
            <a href="dataPengguna.php" style="padding-top: 30px;"><i class="fa fa-fw fa-user"></i> Users</a>
        </div>
        <?php endif; ?>
    </div>
    
    <div class="navbar">
        <button class="profile-btn" id="profile-btn">
            <img src="image/profile.png" alt="Profil">
        </button>
    </div>

    <!-- Logout -->
    <div id="profilelogout" class="logout">
        <div class="logout-content">
            <span class="close" onclick="toggleProfileOptions()">&times;</span>
            <form id="form-logout">
                <button type="button" onclick="updatePassword()">Update Password</button>
                <button type="button" onclick="confirmLogout()">Logout</button>
            </form>
        </div>
    </div>

    <div class="isi">
        <div class="kotak">
        <form action="prosesUpdatepassword.php" method="POST" enctype="multipart/form-data" onsubmit="confirmPasswordChange(event)">
            <div class="namaUP">
                <p>Ubah Password</p>
            </div>

            <hr>
                <div class="kotak1">
                    <label for="password_lama">Password Lama :</label>
                    <input type="password" id="password_lama" name="password_lama" required>
                </div>
                <div class="kotak2">
                    <label for="password_baru">Password Baru :</label>
                    <input type="password" id="password_baru" name="password_baru" required>
                </div>
                <div class="kotak3">
                    <label for="ulangi_password_baru">Masukkan Ulang Password Baru :</label>
                    <input type="password" id="ulangi_password_baru" name="ulangi_password_baru" required>
                </div>
                <div class="line">
                    <hr>
                </div>
                <div class="btn-container">
                    <button class="btn-reset-data" type="reset"><i class="fa fa-fw fa-refresh"></i> &nbsp; Reset</button>
                    <button class="btn-simpan-data" type="submit" name="simpan"><i class="fa fa-fw fa-save"></i> &nbsp; Ubah</button>
                </div>
            </form>
        </div>

        <div class="footer">
            <p>KANTOR KELURAHAN MADAWAT</p>
        </div>
    </div>

    <script>
        document.getElementById("profile-btn").addEventListener("click", toggleProfileOptions);

        // Show success alert if password change was successful
        <?php if ($password_changed): ?>
            showSuccessAlert();
        <?php endif; ?>
    </script>
</body>
</html>
