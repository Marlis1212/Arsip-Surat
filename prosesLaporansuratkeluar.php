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
        <p>AGENDA SURAT KELUAR DARI TANGGAL <?php echo $_SESSION['dari_tanggal']; ?> SAMPAI TANGGAL <?php echo $_SESSION['sampai_tanggal']; ?></p>
    </div>
</div>

<?php
// Query untuk mengambil data berdasarkan tanggal yang dipilih
$query = "SELECT * FROM suratkeluar WHERE tanggal BETWEEN '".$_SESSION['dari_tanggal']."' AND '".$_SESSION['sampai_tanggal']."'";
$result = mysqli_query($koneksi, $query);

// Cetak tabel untuk menampilkan data
echo "<table>
        <tr>
            <th>No</th>
            <th>Nomor Urut</th>
            <th>Alamat Tujuan</th>
            <th>Tanggal</th>
            <th>Perihal</th>
            <th>Nomor Petunjuk</th>
        </tr>";

// Loop untuk menampilkan data dari database
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>"; // Tampilkan nomor urut otomatis
    echo "<td>" . $row['no_urut'] . "</td>";
    echo "<td>" . $row['alamat_tujuan'] . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "<td>" . $row['perihal'] . "</td>";
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




<style type="text/css">
        /* Gaya untuk tabel */
        table {
            margin-top: -10px;
            width: 100%;
            border-collapse: collapse; /* Menggabungkan batas tabel */
        }

        th {
            padding: 0px; /* Mengatur padding pada elemen th */
            background-color: #f2f2f2; /* Warna latar belakang untuk judul kolom */
            font-weight: bold;
            border: 1px solid black; /* Batas tabel tunggal */
            text-align: center;
            font-size: 12px;
        }

        td {
            padding: 1px 5px; /* Mengatur padding pada elemen td */
            border: 1px solid black; /* Batas tabel tunggal */
            text-align: left;
            font-size: 13px;
        }

        tr:nth-child(odd) {
            background-color: #f2f2f2; /* Warna latar belakang untuk baris ganjil */
        }

        /* Gaya untuk media cetak */
        @media print {
            /* Sembunyikan tombol cetak */
            .no-print {
                display: none;
            }
        }

        /* Flexbox untuk memposisikan header di tengah */
        .atas {
            display: flex;
            flex-direction: column;
            align-items: center; /* Memposisikan elemen di tengah secara horizontal */
            justify-content: center; /* Memposisikan elemen di tengah secara vertikal */
            text-align: center; /* Mengatur teks agar berada di tengah */
            margin-bottom: 20px; /* Menambahkan jarak di bawah header */
        }

        .atas .header-container {
            display: flex;
            margin-right: 350px; /* Mengatur margin kiri dan kanan otomatis untuk membuat elemen berada di tengah */
        }

        .atas .kiri {
            margin-bottom: 20px; /* Menambahkan jarak di bawah logo */
            margin-left: 300px;
        }

        .atas .logo img {
            margin-top: 5px;
            max-width: 60px; /* Atur ukuran maksimum untuk lebar gambar */
            max-height: 60px; /* Atur ukuran maksimum untuk tinggi gambar */
        }

        .atas .pem p {
            font-family: calibri;
            font-size: 13px;
            margin-bottom: -10px;
        }

        .atas .kec p {
            font-family: calibri;
            font-size: 13px;
            margin-bottom: -0px;
        }

        .atas .madawat p {
            font-family: "Elephant", fantasy;
            font-weight: bold;
            color: black;
            font-size: 17px;
            margin-top: 2px;
        }

        .atas .alamat {
            border: 2px solid black; /* Menambahkan batas pada elemen alamat */
            padding: 3px; /* Menambahkan padding di dalam kotak */
            margin-top: -15px;
            text-align: center;
            width: 100%;
        }

        .atas .alamat p {
            font-family: "Kristen ITC", sans-serif;
            font-size: 8px;
            margin: 0; /* Menghapus margin dari elemen p di dalam alamat */
            text-align: center;
        }

        .atas .agenda p {
            font-size: 12px;
            margin-top: 16px;
            margin-bottom: -5px;
        }
    </style>