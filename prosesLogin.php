<?php
session_start();

// Aktifkan laporan error
ini_set('display_errors', 1); // Menampilkan error
ini_set('display_startup_errors', 1); // Menampilkan error saat startup
error_reporting(E_ALL); // Menampilkan semua jenis error

// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");

// Periksa koneksi
if ($koneksi->connect_error) {
    // Jika koneksi gagal, tampilkan pesan error
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (isset($_POST['login'])) {
    // Ambil data dari form
    $username = $_POST['username']; // Ambil username dari input form
    $password = $_POST['password']; // Ambil password dari input form

    // Lindungi dari serangan SQL Injection
    $username = $koneksi->real_escape_string($username); // Lindungi username dari SQL Injection

    // Query untuk mencari user dengan username yang cocok
    $query = "SELECT * FROM pengguna WHERE BINARY username=?";
    $stmt = $koneksi->prepare($query); // Siapkan query
    $stmt->bind_param("s", $username); // Bind parameter username ke query
    $stmt->execute(); // Jalankan query
    $result = $stmt->get_result(); // Ambil hasil query

    // Inisialisasi variabel error
    $error = "";

    // Periksa apakah user ditemukan
    if ($result->num_rows > 0) {
        // Jika ada user dengan username yang cocok
        $row = $result->fetch_assoc(); // Ambil data pengguna

        // Periksa apakah password cocok menggunakan password_verify()
        if (password_verify($password, $row['password'])) {
            // Jika password cocok
            $_SESSION['username'] = $username; // Simpan username di session
            $_SESSION['nama'] = $row['nama']; // Simpan nama di session
            $_SESSION['level'] = $row['level']; // Simpan level di session
            // arahkan ke halaman setelah login berhasil
            header("Location: dashboard.php");
            exit(); // Hentikan eksekusi script setelah redirect
        } else {
            // Jika password tidak cocok
            $error = "password salah"; // Pesan error untuk password salah
        }
    } else {
        // Jika username tidak ditemukan atau password salah
        $error = "Username dan password salah"; // Pesan error jika username tidak ditemukan
    }

    // Redirect ke halaman login dengan pesan error
    header("Location: login.php?error=" . urlencode($error)); // Kirim pesan error ke halaman login
    exit(); // Hentikan eksekusi script setelah redirect
}

// Tutup koneksi
$koneksi->close(); // Tutup koneksi database
?>
