<!DOCTYPE html>
<html>
<head>
    <title>Arsip Surat Madawat</title>
</head>
<body>

<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");

// Inisialisasi nomor urut
$no = 1;

if (isset($_POST['cetak'])) {
    $dari_tanggal = $_POST['dari_tanggal'];
    $sampai_tanggal = $_POST['sampai_tanggal'];

    // Simpan tanggal dalam sesi
    $_SESSION['dari_tanggal'] = $dari_tanggal;
    $_SESSION['sampai_tanggal'] = $sampai_tanggal;
}
?>

<div class="atas">
    <div class="header-container">
        <div class="kiri">
            <div class="logo">
                <img src="image/logo.png" alt="Logo">
            </div>
        </div>
        <div class="kanan">
            <div class="pem">
                <p>PEMERINTAH KABUPATEN SIKKA</p>
            </div>

            <div class="kec">
                <p>KECAMATAN ALOK</p>
            </div>

            <div class="madawat">
                <p>KELURAHAN MADAWAT</p>
            </div>
        </div>
    </div>
    <div class="alamat">
        <p>JL.MELATI - TELP. (0382) 22871 MAUMERE 86112</p>
    </div>
    <div class="agenda">
        <p>AGENDA SURAT MASUK DARI TANGGAL <?php echo $_SESSION['dari_tanggal']; ?> SAMPAI TANGGAL <?php echo $_SESSION['sampai_tanggal']; ?></p>
    </div>
</div>

<?php
// Query untuk mengambil data berdasarkan tanggal yang dipilih
$query = "SELECT * FROM suratmasuk WHERE tanggal BETWEEN '".$_SESSION['dari_tanggal']."' AND '".$_SESSION['sampai_tanggal']."'";
$result = mysqli_query($koneksi, $query);

// Cetak tabel untuk menampilkan data
echo "<table>
        <tr>
            <th>No</th>
            <th>Nomor Urut</th>
            <th>Alamat Pengirim</th>
            <th>Tanggal</th>
            <th>Perihal</th>
            <th>Nomor Surat</th>
            <th>Nomor Petunjuk</th>
        </tr>";

// Loop untuk menampilkan data dari database
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>"; // Tampilkan nomor urut otomatis
    echo "<td>" . $row['no_urut'] . "</td>";
    echo "<td>" . $row['alamat_pengirim'] . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "<td>" . $row['perihal'] . "</td>";
    echo "<td>" . $row['no_surat'] . "</td>";
    echo "<td>" . $row['no_petunjuk'] . "</td>";
    echo "</tr>";
}

// Tutup tabel
echo "</table>";

// Tutup koneksi database
mysqli_close($koneksi);
?>

</body>
</html>
