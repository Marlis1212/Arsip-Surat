<?php
session_start();

// Koneksi ke database MySQL
$koneksi = new mysqli("localhost", "root", "", "arsipsurat_madawat");
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Menambahkan data surat keluar
if (isset($_POST['simpan'])) {
    $no_urut = $_POST['no_urut'];
    $alamat_tujuan = $_POST['alamat_tujuan'];
    $tanggal = $_POST['tanggal'];
    $perihal = $_POST['perihal'];
    $no_petunjuk = $_POST['no_petunjuk'];

    $query = "INSERT INTO suratkeluar (no_urut, alamat_tujuan, tanggal, perihal, no_petunjuk) 
              VALUES ('$no_urut','$alamat_tujuan','$tanggal','$perihal','$no_petunjuk')";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil disimpan!'); window.location.href='dataSuratkeluar.php';</script>";
        exit();
    } else {
        die("Error: " . $koneksi->error);
    }
}

// Menghapus data surat keluar
if (isset($_GET['aksi']) && $_GET['aksi'] == 'HAPUS' && isset($_GET['id_suratkeluar'])) {
    $id_suratkeluar = $_GET['id_suratkeluar'];
    
    $sql = "DELETE FROM suratkeluar WHERE id_suratkeluar = '$id_suratkeluar'";
    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil dihapus!'); window.location.href='dataSuratkeluar.php';</script>";
        exit();
    } else {
        die("Error: " . $koneksi->error);
    }
}

// Mengubah data surat keluar
if (isset($_POST['ubah'])) {
    $id_suratkeluar = $_POST['id_suratkeluar'];
    $no_urut = $_POST['no_urut'];
    $alamat_tujuan = $_POST['alamat_tujuan'];
    $tanggal = $_POST['tanggal'];
    $perihal = $_POST['perihal'];
    $no_petunjuk = $_POST['no_petunjuk'];

    $query = "UPDATE suratkeluar SET no_urut='$no_urut', alamat_tujuan='$alamat_tujuan', tanggal='$tanggal', perihal='$perihal', no_petunjuk='$no_petunjuk' WHERE id_suratkeluar='$id_suratkeluar'";

    if ($koneksi->query($query) === TRUE) {
        echo "<script>alert('Data berhasil diubah!'); window.location.href='dataSuratkeluar.php';</script>";
        exit();
    } else {
        die("Error: " . $koneksi->error);
    }
}
?>
