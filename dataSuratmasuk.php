<?php
    // Matikan semua laporan error
    error_reporting(0);

    // Mulai sesi
    session_start();

    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");

    // Periksa koneksi ke database
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Periksa apakah pengguna sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    // Ambil data dari sesi
    $nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
    $level_pengguna = isset($_SESSION['level']) ? $_SESSION['level'] : '';
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
        // Tampilkan opsi profil
        function showProfileOptions() {
            document.getElementById("profilelogout").style.display = "block";
        }

        // Tutup opsi profil
        function closelogout() {
            document.getElementById("profilelogout").style.display = "none";
        }

        // Arahkan ke halaman update password
        function Update() {
            window.location.href = 'updatePassword.php';
        }

        // Arahkan ke halaman logout
        function keluar() {
            window.location.href = 'logout.php';
        }

        // Konfirmasi logout
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
        <!-- Header sidebar -->
        <div class="header">
            <div class="logo">
                <img src="image/logo.png" alt="Logo">
            </div>
            <div class="nama">
                <p>ARSIP SURAT MADAWAT</p>
            </div>
        </div>

        <!-- Info profil pengguna -->
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

        <!-- Menu sidebar -->
        <a href="dashboard.php" style="background-color: black;"><i class="fa fa-fw fa-home"></i> Dashboard</a>
        <div class="dropdown">
            <a href="#services" style="background-color: black ;"><i class="fa fa-fw fa-edit"></i> Data Surat</a>
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

    <!-- Navbar untuk profil -->
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
            <p>Surat Masuk</p>
        </div>
        <div class="kotak">
            <div class="atas">
                <p>Data Surat Masuk</p>
                <div class="tambahSurat">
                    <a href="tambahSuratmasuk.php">
                        <button class="btn-tambah-surat"><i class="fa fa-fw fa-plus"></i>Tambah Surat Masuk</button>
                    </a>
                </div>
            </div>

            <hr>
            <div class="container">
                <!-- Form pencarian -->
                <div class="search-bar">
                    <form method="post" action="dataSuratmasuk.php">
                        <input type="text" name="keyword" size="30" autocomplete="off" placeholder="Cari data ...">
                        <button type="submit" name="cari"><i class="fa fa-fw fa-search"></i></button>
                    </form>
                </div>

                <!-- Tabel data surat masuk -->
                <div class="table-container">
                    <div class="tbl"> 
                        <table border="3">
                            <tr>
                                <th>No</th>
                                <th>Nomor Urut</th>
                                <th>Alamat Pengirim</th>
                                <th>Tanggal, <br> Perihal</th>
                                <th>Nomor Surat, <br> Nomor Petunjuk</th>
                                <!-- <th>File Surat</th> -->
                                <th>Aksi</th>
                            </tr>

                            <?php
                            $no = 1;
                            // Proses pencarian jika tombol cari ditekan
                            if (isset($_POST['cari'])) {
                                $keyword = $_POST['keyword'];
                                $sql = $koneksi->query("SELECT * FROM suratmasuk WHERE no_urut LIKE '%$keyword%' OR alamat_pengirim LIKE '%$keyword%'");
                            } else {
                                $sql = $koneksi->query("SELECT * FROM suratmasuk");
                            }

                            // Menampilkan data dalam tabel
                            while ($data = $sql->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['no_urut']; ?></td>
                                <td><?php echo $data['alamat_pengirim']; ?></td>
                                <td><?php echo $data['tanggal']; ?>, <br> <?php echo $data['perihal']; ?></td>
                                <td><?php echo $data['no_surat']; ?>, <br> <?php echo $data['no_petunjuk']; ?></td>
                                <!-- <td><?php echo $data['file']; ?></td> -->
                                <td>
                                    <!-- Tombol untuk mengubah dan menghapus data surat masuk -->
                                    <a href="ubahDataSuratmasuk.php?aksi=UBAH&id_suratmasuk=<?php echo $data['id_suratmasuk']; ?>">
                                        <button class="btn-ubah"><i class="fa fa-fw fa-edit"></i></button>
                                    </a>
                                    <a href="prosesDataSuratmasuk.php?aksi=HAPUS&id_suratmasuk=<?php echo $data['id_suratmasuk']; ?>" onclick="return confirm('Anda yakin ingin menghapus data ini?')">
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

        <!-- Footer -->
        <div class="footer">
            <p>KANTOR KELURAHAN MADAWAT</p>
        </div>
    </div>

    <!-- Script untuk menampilkan menu profil -->
    <script>
            // Menambahkan event listener pada tombol dengan ID "profile-btn"
            // Ketika tombol diklik, fungsi showProfileOptions() akan dipanggil
        document.getElementById("profile-btn").addEventListener("click", showProfileOptions);
    </script>

</body>
</html>
