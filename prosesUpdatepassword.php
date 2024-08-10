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
?>
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

if (isset($_POST['simpan'])) {
    // Mengambil data dari form
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $ulangi_password_baru = $_POST['ulangi_password_baru'];

    // Mengambil username pengguna dari sesi
    $username_pengguna = $_SESSION['username'];

    // Query untuk mendapatkan password terenkripsi dari database
    $query = "SELECT password FROM pengguna WHERE username=?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_db = $row['password'];

        // Memeriksa apakah password lama yang dimasukkan sesuai dengan password di database
        if (password_verify($password_lama, $password_db)) {
            // Memeriksa apakah password baru dan ulangi password baru sama
            if ($password_baru == $ulangi_password_baru) {
                // Mengenkripsi password baru dengan bcrypt
                $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

                // Query untuk mengupdate password baru ke database
                $update_query = "UPDATE pengguna SET password=? WHERE username=?";
                $stmt = $koneksi->prepare($update_query);
                $stmt->bind_param("ss", $password_hash, $username_pengguna);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Password berhasil diubah.'); window.location.href='dashboard.php';</script>";
                } else {
                    echo "<script>alert('Gagal mengubah password.'); window.location.href='updatePassword.php';</script>";
                }
            } else {
                
                echo "<script>alert('Password baru dan ulangi password baru tidak cocok.'); window.location.href='updatePassword.php';</script>";
            }
        } else {
            echo "<script>alert('Password lama yang dimasukkan salah.'); window.location.href='updatePassword.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan.'); window.location.href='updatePassword.php';</script>";
    }
    
    // Menutup koneksi database
    $stmt->close();
    $koneksi->close();
}
?>
