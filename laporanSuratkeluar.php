<?php
    error_reporting(0);
    session_start();
    $koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Surat Madawat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="dataSuratmasuk.css">
    <link rel="stylesheet" type="text/css" href="logout.css">

        <script>
        function showProfileOptions() {
            document.getElementById("profilelogout").style.display = "block";
        }
 
        function closelogout() {
            document.getElementById("profilelogout").style.display = "none";
        }

        function Update() {
            window.location.href = 'updatePassword.php';
        }

        function keluar() {
            window.location.href = 'logout.php';
        }

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
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data dari sesi
$nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
$level_pengguna = isset($_SESSION['level']) ? $_SESSION['level'] : '';
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

        <!-- logout -->
    <div id="profilelogout" class="logout">
        <div class="logout-content">
            <span class="close" onclick="closelogout()">&times;</span>
            <form id="form-tambah">
                <button type="button" onclick="Update()">Update Password</button>
                <button type="button" id="logoutButton" onclick="confirmLogout()">Logout</button>
            </form>
        </div>
    </div>
    

    <div class="isi">
        <div class="sm">
            <p>Buku Agenda</p>
        </div>
        <div class="kotak">
            <div class="atas">
                <p>Cetak Laporan Surat Keluar</p>
            </div>

            <hr>

            <form method="POST" action="prosesLaporansuratkeluar.php">
                <div class="kotak1">
                    <label for="dari_tanggal">Dari Tanggal :</label>
                    <input type="date" name="dari_tanggal" id="dari_tanggal">
                </div> 
                <div class="kotak2">
                    <label for="sampai_tanggal">Sampai Tanggal :</label>
                    <input type="date" name="sampai_tanggal" id="sampai_tanggal">
                </div>
                <div class="btn-container">
                    <button class="btn-cetak-data" type="submit" name="cetak"><i class="fa fa-fw fa-print"></i> &nbsp Cetak </button>
                    <button class="btn-reset-data" type="reset"><i class="fa fa-fw fa-refresh"></i> &nbsp Refresh </button>  
                </div>
            </form>

        </div>

        <div class="footer">
            <p>KANTOR KELURAHAN MADAWAT</p>
        </div>
    </div>

    <script>
        document.getElementById("profile-btn").addEventListener("click", showProfileOptions);
    </script>
</body>
</html>
  