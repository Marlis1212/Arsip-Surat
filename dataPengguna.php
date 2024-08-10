<?php
session_start(); // Memulai sesi untuk melacak login pengguna

// Cek apakah pengguna sudah login, jika tidak, arahkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari sesi
$nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
$level_pengguna = isset($_SESSION['level']) ? $_SESSION['level'] : '';

// Buat koneksi ke database
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
        // Fungsi untuk menampilkan opsi profil
        function showProfileOptions() {
            document.getElementById("profilelogout").style.display = "block";
        }

        // Fungsi untuk menutup opsi profil
        function closelogout() {
            document.getElementById("profilelogout").style.display = "none";
        }

        // Fungsi untuk mengarahkan ke halaman update password
        function Update() {
            window.location.href = 'updatePassword.php';
        }

        // Fungsi untuk mengarahkan ke halaman logout
        function keluar() {
            window.location.href = 'logout.php';
        }

        // Konfirmasi logout dengan dialog
        function confirmLogout() {
            var result = confirm("Apakah Anda yakin ingin keluar?");
            if (result) {
                window.location.href = 'logout.php';
            }
        }
    </script>
    
</head>
<body>
    <!-- Sidebar navigasi -->
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
                    <!-- untuk tampilkan nama pengguna dan level pengguna yang login -->
                   <?php echo htmlspecialchars($nama_pengguna); ?> (<?php echo htmlspecialchars($level_pengguna); ?>)
                </span>
            </div>
        </div>

        <!-- Menu sidebar -->
        <a href="dashboard.php" style="background-color: black;"><i class="fa fa-fw fa-home"></i> Dashboard</a>
        <div class="dropdown">
            <a href="#services" style="background-color: black ;"><i class="fa fa-fw fa-edit"></i> Data Surat </a>
            <div class="dropdown-content" style="background-color: black ;">
                <a href="dataSuratmasuk.php">Surat Masuk</a>
                <a href="dataSuratkeluar.php">Surat Keluar</a>
            </div>
        </div>
        <div class="dropdown1">
            <a href="#clients" style="background-color: black ;"><i class="fa fa-fw fa-print"></i> Cetak Laporan</a>
            <div class="dropdown-content1" style="background-color: black ;">
                <a href="laporansuratmasuk.php">Laporan Surat Masuk</a>
                <a href="laporansuratkeluar.php">Laporan Surat Keluar</a>
            </div>
        </div>
        <div>
            <a href="dataPengguna.php" style="padding-top: 30px;"><i class="fa fa-fw fa-user"></i> Users</a>
        </div>
    </div>

    <!-- Tombol profil -->
    <div class="navbar">
        <button class="profile-btn" id="profile-btn">
            <img src="image/profile.png" alt="Profil">
        </button>
    </div>

    <!-- Opsi logout -->
    <div id="profilelogout" class="logout">
        <div class="logout-content">
            <span class="close" onclick="closelogout()">&times;</span>
            <form id="form-tambah">
                <button type="button" onclick="Update()">Update Password</button>
                <button type="button" id="logoutButton" onclick="confirmLogout()">Logout</button>
            </form>
        </div>
    </div>

    <!-- Konten utama -->
    <div class="isi">
        <div class="sm">
            <p>Admin</p>
        </div>
        <div class="kotak">
            <div class="atas">
                <p>Data Users</p>
                <div class="tambahSurat">
                    <a href="tambahPengguna.php"> <button class="btn-tambah-surat"><i class="fa fa-fw fa-plus"></i>Tambah Pengguna</button></a>
                </div>
            </div>

            <hr>
            <div>
                <div class="container">
                    <div class="search-bar">
                        <form method="post" action="dataPengguna.php">
                            <input type="text" name="keyword" size="30" autocomplete="off" placeholder="Cari data ...">
                            <button type="submit" name="cari"><i class="fa fa-fw fa-search"></i></button>
                        </form>
                    </div>
                    
                    <div class="table-container">
                        <div class="tbl"> 
                            <table border="3">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Level</th>
                                    <th>Aksi</th>
                                </tr>

                                <?php
                                $no = 1;
                                // Jika ada pencarian, lakukan query dengan keyword
                                if (isset($_POST['cari'])) {
                                    $keyword = $_POST['keyword'];
                                    $sql = $koneksi->query("SELECT * FROM pengguna WHERE nama LIKE '%$keyword%' OR username LIKE '%$keyword%' OR level LIKE '%$keyword%'");
                                } else {
                                    // Jika tidak ada pencarian, tampilkan semua data pengguna
                                    $sql = $koneksi->query("SELECT * FROM pengguna");
                                }

                                // Tampilkan data pengguna
                                while ($data = $sql->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['nama']; ?></td>
                                    <td><?php echo $data['username']; ?></td>
                                    <td><?php echo $data['level']; ?></td>
                                    <td>
                                        <!-- Tombol untuk mengubah dan menghapus data surat keluar -->
                                        <a href="ubahDatapengguna.php?aksi=UBAH&id_pengguna=<?php echo $data['id_pengguna']; ?>">
                                            <button class="btn-ubah"><i class="fa fa-fw fa-edit"></i></button>
                                        </a>

                                        <a href="prosesDatapengguna.php?aksi=HAPUS&id_pengguna=<?php echo $data['id_pengguna']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                                            <button class="btn-hapus"><i class="fa fa-fw fa-trash"></i></button>
                                        </a>
                                        
                                    </td>
                                </tr>
                            <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>KANTOR KELURAHAN MADAWAT</p>
    </div>

    <script>
            // Menambahkan event listener pada tombol dengan ID "profile-btn"
            // Ketika tombol diklik, fungsi showProfileOptions() akan dipanggil
        document.getElementById("profile-btn").addEventListener("click", showProfileOptions);
    </script>
</body>
</html>
