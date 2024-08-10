<?php
session_start(); // Memulai sesi untuk menyimpan data pengguna yang sedang login

// Koneksi ke database MySQL
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error); // Menangani kesalahan koneksi ke database
}

// Menambahkan data surat masuk
if (isset($_POST['simpan'])) { // Mengecek apakah form simpan telah di-submit
    $no_urut = $_POST['no_urut']; // Mengambil nilai no_urut dari form
    $alamat_pengirim = $_POST['alamat_pengirim']; // Mengambil nilai alamat_pengirim dari form
    $tanggal = $_POST['tanggal']; // Mengambil nilai tanggal dari form
    $perihal = $_POST['perihal']; // Mengambil nilai perihal dari form
    $no_surat = $_POST['no_surat']; // Mengambil nilai no_surat dari form
    $no_petunjuk = $_POST['no_petunjuk']; // Mengambil nilai no_petunjuk dari form

    // Query untuk memasukkan data ke tabel suratmasuk
    $query = "INSERT INTO suratmasuk (no_urut, alamat_pengirim, tanggal, perihal, no_surat, no_petunjuk) 
              VALUES ('$no_urut','$alamat_pengirim','$tanggal','$perihal','$no_surat','$no_petunjuk')";

    if ($koneksi->query($query) === TRUE) { // Menjalankan query dan mengecek apakah berhasil
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='dataSuratmasuk.php';</script>"; // Pesan berhasil
        exit(); // Menghentikan eksekusi skrip
    } else {
        die("Error: " . $koneksi->error); // Menampilkan pesan kesalahan
    }
}

// Menghapus data surat masuk
if (isset($_GET['aksi']) && $_GET['aksi'] == 'HAPUS' && isset($_GET['id_suratmasuk'])) { // Mengecek apakah aksi adalah HAPUS dan id_suratmasuk ada
    $id_suratmasuk = $_GET['id_suratmasuk']; // Mengambil nilai id_suratmasuk dari URL
    
    // Query untuk menghapus data dari tabel suratmasuk
    $sql = "DELETE FROM suratmasuk WHERE id_suratmasuk = '$id_suratmasuk'";
    if ($koneksi->query($sql) === TRUE) { // Menjalankan query dan mengecek apakah berhasil
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='dataSuratmasuk.php';</script>"; // Pesan berhasil
        exit(); // Menghentikan eksekusi skrip
    } else {
        die("Error: " . $koneksi->error); // Menampilkan pesan kesalahan
    }
}

// Mengubah data surat masuk
if (isset($_POST['ubah'])) { // Mengecek apakah form ubah telah di-submit
    $id_suratmasuk = $_POST['id_suratmasuk']; // Mengambil nilai id_suratmasuk dari form
    $no_urut = $_POST['no_urut']; // Mengambil nilai no_urut dari form
    $alamat_pengirim = $_POST['alamat_pengirim']; // Mengambil nilai alamat_pengirim dari form
    $tanggal = $_POST['tanggal']; // Mengambil nilai tanggal dari form
    $perihal = $_POST['perihal']; // Mengambil nilai perihal dari form
    $no_surat = $_POST['no_surat']; // Mengambil nilai no_surat dari form
    $no_petunjuk = $_POST['no_petunjuk']; // Mengambil nilai no_petunjuk dari form

    // Query untuk memperbarui data di tabel suratmasuk
    $query = "UPDATE suratmasuk SET no_urut='$no_urut', alamat_pengirim='$alamat_pengirim', tanggal='$tanggal', perihal='$perihal', no_surat='$no_surat', no_petunjuk='$no_petunjuk' WHERE id_suratmasuk='$id_suratmasuk'";

    if ($koneksi->query($query) === TRUE) { // Menjalankan query dan mengecek apakah berhasil
        echo "<script>alert('Data berhasil diubah!'); window.location.href='dataSuratmasuk.php';</script>"; // Pesan berhasil
        exit(); // Menghentikan eksekusi skrip
    } else {
        die("Error: " . $koneksi->error); // Menampilkan pesan kesalahan
    }
}
?>
