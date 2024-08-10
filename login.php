<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

    <form action="prosesLogin.php" method="POST">
        <div class="kotak1">
            <input type="text" name="username" placeholder="Username" class="input-control" required>
        </div>
        <div class="kotak2">
            <input type="password" name="password" placeholder="Password" class="input-control" required>
        </div>
        <?php if (isset($_GET['error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        <div class="btn-container">
            <button class="btn-reset-data" type="reset">Reset</button>
            <button class="btn-login-data" type="submit" name="login">Login</button>
        </div>
    </form>

    <div class="bawah">
        <p>SISTEM ARSIP SURAT MASUK DAN SURAT KELUAR KANTOR KELURAHAN MADAWAT</p>
        <h1>(INFORMASI ARSIP)</h1>
    </div>
</body>
</html>
