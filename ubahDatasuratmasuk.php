<?php
session_start();
error_reporting(0);
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");

$id_suratmasuk = $_GET['id_suratmasuk']; // Ambil id_suratmasuk dari URL

$sql = $koneksi->query("SELECT * FROM suratmasuk WHERE id_suratmasuk='$id_suratmasuk'");
$tampil = $sql->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arsip Surat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="tambahSuratmasuk.css">
    <link rel="stylesheet" type="text/css" href="logout.css">
    <script>
        function confirmUpdate() {
            return confirm("Apakah Anda ingin mengubah data ini?");
        }

        function toggleProfileOptions() {
            const profileOptions = document.getElementById("profilelogout");
            profileOptions.style.display = profileOptions.style.display === "block" ? "none" : "block";
        }

        function updatePassword() {
            window.location.href = 'updatePassword.php';
        }

        function logout() {
            window.location.href = 'logout.php';
        }

        function confirmLogout() {
            var result = confirm("Apakah Anda yakin ingin keluar?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }

        function closeLogout() {
            document.getElementById("profilelogout").style.display = "none";
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
        <div class="dropdown">
            <a href="#services" style="background-color: black;"><i class="fa fa-fw fa-edit"></i> Data Surat</a>
            <div class="dropdown-content" style="background-color: black;">
                <a href="dataSuratmasuk.php">Surat Masuk</a>              
                <a href="dataSuratkeluar.php">Surat Keluar</a>
            </div>
        </div>
        <div class="dropdown1">
            <a href="#clients" style="background-color: black;"><i class="fa fa-fw fa-print"></i> Cetak Laporan</a>
            <div class="dropdown-content1" style="background-color: black;">
                <a href="laporansuratmasuk.php">Laporan Surat Masuk</a>
                <a href="laporansuratkeluar.php">Laporan Surat Keluar</a>
            </div>
        </div>
        <div>
            <a href="dataPengguna.php" style="padding-top: 30px;"><i class="fa fa-fw fa-user"></i> Users</a>
        </div>
    </div>
    <div class="navbar">
        <button class="profile-btn" id="profile-btn">
            <img src="image/profile.png" alt="Profil">
        </button>
    </div>

    <!-- logout -->
    <div id="profilelogout" class="logout" style="display: none;">
        <div class="logout-content">
            <span class="close" onclick="closeLogout()">&times;</span>
            <form id="form-tambah">
                <button type="button" onclick="updatePassword()">Update Password</button>
                <button type="button" id="logoutButton" onclick="confirmLogout()">Logout</button>
            </form>
        </div>
    </div>

    <div class="isi">
        <div class="sm">
            <p>Edit Surat Masuk</p>
        </div>
        <div class="kotak">
            <div class="atas">
                <p>Form Edit Surat Masuk</p>
                <div class="kembaliSurat">
                    <a href="dataSuratmasuk.php"><button class="btn-kembali-surat"><i class="fa fa-fw fa-reply"></i> Kembali</button></a>
                </div>
            </div>
            <hr>
            <form action="prosesDatasuratmasuk.php" method="POST" enctype="multipart/form-data" onsubmit="return confirmUpdate()">
                <input type="hidden" name="id_suratmasuk" value="<?php echo $tampil['id_suratmasuk']; ?>">
                <div class="kotak1">
                    <label for="no_urut">Nomor Urut :</label>
                    <input type="text" id="no_urut" name="no_urut" value="<?php echo $tampil['no_urut']; ?>" required>
                </div>
                <div class="kotak2">
                    <label for="alamat_pengirim">Alamat Pengirim:</label>
                    <input type="text" id="alamat_pengirim" name="alamat_pengirim" value="<?php echo $tampil['alamat_pengirim']; ?>" required>
                </div>
                <div class="kotak3">
                    <label for="tanggal_surat">Tanggal :</label>
                    <input type="date" id="tanggal_surat" name="tanggal" value="<?php echo $tampil['tanggal']; ?>" required>
                </div>
                <div class="kotak4">
                    <label for="no_surat">Nomor Surat :</label>
                    <input type="text" id="no_surat" name="no_surat" value="<?php echo $tampil['no_surat']; ?>" required>
                </div>
                <div class="kotak5">
                    <label for="perihal">Perihal :</label>
                    <textarea id="perihal" name="perihal" required><?php echo $tampil['perihal']; ?></textarea>
                </div>
                <div class="kotak6">
                    <label for="no_petunjuk">Nomor Petunjuk :</label>
                    <input type="text" id="no_petunjuk" name="no_petunjuk" value="<?php echo $tampil['no_petunjuk']; ?>" required>
                </div>
                <div class="line">
                    <hr>
                </div>
                <div class="btn-container">
                    <button class="btn-reset-data" type="reset"><i class="fa fa-fw fa-refresh"></i> &nbsp; Reset</button>
                    <button class="btn-simpan-data" type="submit" name="ubah"><i class="fa fa-fw fa-save"></i> &nbsp; Ubah</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="footer">
        <p>KANTOR KELURAHAN MADAWAT</p>
    </div>

    <script>
        document.getElementById("profile-btn").addEventListener("click", toggleProfileOptions);
    </script>
</body>
</html>
