<?php
error_reporting(0); // Menyembunyikan laporan error agar tidak tampil di halaman
session_start(); // Memulai sesi untuk menyimpan data pengguna yang sedang login
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat"); // Menghubungkan ke database dengan nama 'arsipsurat_madawat'

// Menghitung jumlah surat masuk
$resultSuratMasuk = $koneksi->query("SELECT COUNT(*) AS total FROM suratmasuk");
$jumlahSuratMasuk = $resultSuratMasuk->fetch_assoc()['total']; // Menyimpan jumlah surat masuk dalam variabel

// Menghitung jumlah surat keluar
$resultSuratKeluar = $koneksi->query("SELECT COUNT(*) AS total FROM suratkeluar");
$jumlahSuratKeluar = $resultSuratKeluar->fetch_assoc()['total']; // Menyimpan jumlah surat keluar dalam variabel

// Menghitung jumlah pengguna
$resultPengguna = $koneksi->query("SELECT COUNT(*) AS total FROM pengguna");
$jumlahPengguna = $resultPengguna->fetch_assoc()['total']; // Menyimpan jumlah pengguna dalam variabel
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Surat Madawat</title>
    <!-- Memuat stylesheet Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Memuat stylesheet custom -->
    <link rel="stylesheet" type="text/css" href="dataSuratmasuk.css">
    <link rel="stylesheet" type="text/css" href="logout.css">

    <script>
        // Fungsi untuk menampilkan opsi profil saat tombol profil diklik
        function showProfileOptions() {
            document.getElementById("profilelogout").style.display = "block";
        }

        // Fungsi untuk menutup opsi profil
        function closelogout() {
            document.getElementById("profilelogout").style.display = "none";
        }

        // Fungsi untuk mengarahkan pengguna ke halaman update password
        function Update() {
            window.location.href = 'updatePassword.php';
        }

        // Fungsi untuk mengarahkan pengguna ke halaman logout
        function keluar() {
            window.location.href = 'logout.php';
        }

        // Fungsi untuk mengkonfirmasi apakah pengguna ingin logout
        function confirmLogout() {
            var result = confirm("Apakah Anda yakin ingin keluar?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }
    </script>
</head>
<body>
    <!-- Sidebar -->
    <?php
    // Periksa apakah pengguna sudah login, jika belum maka arahkan ke halaman login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Mengambil data pengguna dari sesi untuk ditampilkan
    $nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
    $level_pengguna = isset($_SESSION['level']) ? $_SESSION['level'] : '';
    ?>

    <div class="sidebar">
        <div class="header">
            <div class="logo">
                <img src="image/logo.png" alt="Logo"> <!-- Logo aplikasi -->
            </div>
            <div class="nama">
                <p>ARSIP SURAT MADAWAT</p> <!-- Nama aplikasi -->
            </div>
        </div>

        <div class="headerr">
            <div class="profil">
                <img src="image/profile.png" alt="Profil"> <!-- Gambar profil pengguna -->
            </div>
            <div class="namaa">
                <p>Welcome,</p>
                <span>
                    <!-- Menampilkan nama dan level pengguna yang login -->
                    <?php echo htmlspecialchars($nama_pengguna); ?> (<?php echo htmlspecialchars($level_pengguna); ?>)
                </span>
            </div>
        </div>

        <!-- Menu Dashboard -->
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
        
        <!-- Menu Cetak Laporan -->
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

    <!-- Navbar untuk tombol profil -->
    <div class="navbar">
        <button class="profile-btn" id="profile-btn">
            <img src="image/profile.png" alt="Profil">
        </button>
    </div>

    <!-- Opsi logout dan update password -->
    <div id="profilelogout" class="logout">
        <div class="logout-content">
            <span class="close" onclick="closelogout()">&times;</span> <!-- Tombol untuk menutup opsi -->
            <form id="form-tambah">
                <button type="button" onclick="Update()">Update Password</button> <!-- Tombol untuk update password -->
                <button type="button" id="logoutButton" onclick="confirmLogout()">Logout</button> <!-- Tombol untuk logout -->
            </form>
        </div>
    </div>

    <!-- Isi Halaman Dashboard -->
    <div class="isi">
        <div class="SM">
            <p>Dashboard lurah Kelurahan Madawat</p> <!-- Judul halaman -->
        </div>

        <div class="atas">
            <div class="Smasuk">
                <div class="kiri">
                    <!-- Menampilkan jumlah surat masuk -->
                    <p><?php echo $jumlahSuratMasuk; ?></p>
                    <p>Surat Masuk</p>
                </div>
                <div class="kanan">
                    <img src="image/surat.png" alt="Profil"> <!-- Ikon surat masuk -->
                </div>
            </div>

            <div class="Skeluar">
                <div class="kiri">
                    <!-- Menampilkan jumlah surat keluar -->
                    <p><?php echo $jumlahSuratKeluar; ?></p>
                    <p>Surat Keluar</p>
                </div>
                <div class="kanan">
                    <img src="image/surat.png" alt="Profil"> <!-- Ikon surat keluar -->
                </div>
            </div>

            <div class="Pengguna">
                <div class="kiri">
                    <!-- Menampilkan jumlah pengguna -->
                    <p><?php echo $jumlahPengguna; ?></p>
                    <p>Pengguna</p>
                </div>
                <div class="kanan">
                    <img src="image/users.png" alt="Profil"> <!-- Ikon pengguna -->
                </div>
            </div>
        </div>

        <div class="bawah">
            <div class="wl">
                <p>Welcome</p> <!-- Pesan selamat datang -->
            </div>
            
            <hr>

            <div class="MD">
                <P>SELAMAT DATANG DI SISTEM KEARSIPAN SURAT</P> <!-- Pesan selamat datang utama -->
            </div>
            <div class="MDD">
                <p>Kantor Kelurahan Madawat</p> <!-- Informasi tambahan -->
            </div>
        </div>

        <div class="footerr">
            <p>Kantor KELURAHAN MADAWAT</p> <!-- Footer halaman -->
        </div>
    </div>

    <script>
        // Menambahkan event listener pada tombol profil
        document.getElementById("profile-btn").addEventListener("click", showProfileOptions);
    </script>

</body>
</html>
