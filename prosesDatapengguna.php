<?php
session_start();

// Aktifkan laporan error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");

// Periksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Menambahkan data pengguna
if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Password dalam plaintext

    // Enkripsi password sebelum menyimpannya ke dalam database
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $level = $_POST['level']; // Pastikan ini mengambil data level dari form

    // Query untuk menyimpan data baru ke database
    $query = "INSERT INTO pengguna (nama, username, password, level) 
              VALUES ('$nama','$username','$password_hash','$level')";

    // Eksekusi query dan cek apakah berhasil atau tidak
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='dataPengguna.php';</script>";
        exit();
    } else {
        // Jika query tidak berhasil dieksekusi, tampilkan pesan error
        die("Error: " . mysqli_error($koneksi));
    }

}

// Menghapus data pengguna
if (isset($_GET['aksi']) && $_GET['aksi'] == 'HAPUS' && isset($_GET['id_pengguna'])) {
    // Mendapatkan ID pengguna yang akan dihapus
    $id_pengguna = $_GET['id_pengguna'];
    
    // Query untuk menghapus data berdasarkan ID
    $sql = "DELETE FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $hsl = mysqli_query($koneksi, $sql);

    // Mengecek apakah penghapusan berhasil atau tidak
    if ($hsl) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='dataPengguna.php';</script>";
        exit();
    } else {
        die("Error: " . mysqli_error($koneksi));
    }
}

// Mengubah data pengguna
if (isset($_POST['ubah'])) {
    // Mengambil nilai input dari form
    $id_pengguna = $_POST['id_pengguna'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password']; // Password dalam plaintext
    $level = $_POST['level'];

    // Enkripsi password sebelum menyimpannya ke dalam database
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk mengubah data pengguna
    $query = "UPDATE pengguna SET nama='$nama', username='$username', password='$password_hash', level='$level' WHERE id_pengguna='$id_pengguna'";

    // Eksekusi query dan cek apakah berhasil atau tidak
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil diubah!'); window.location.href='dataPengguna.php';</script>";
        exit();
    } else {
        // Jika query tidak berhasil dieksekusi, tampilkan pesan error
        die("Error: " . mysqli_error($koneksi));
    }
}
?>
