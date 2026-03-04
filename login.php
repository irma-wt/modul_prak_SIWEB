<?php
session_start();

// Kalau sudah login, langsung redirect ke index
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — Cibaduyut Shoes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">

    <div class="login-box">
        <h4 class="login-heading">CIBADUYUT SHOES</h4>
        <p class="login-sub">Silakan login untuk melanjutkan</p>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2 px-3 mb-3" style="font-size:14px;">
                Username atau password salah.
            </div>
        <?php endif; ?>

        <form method="POST" action="controller/proses_login.php">
            <div class="mb-3">
                <label class="form-label" for="username">Username</label>
                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control"
                    placeholder="Masukkan username"
                    value="<?php echo isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : ''; ?>"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                />
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>
            <button type="submit" class="btn btn-warning w-100 mb-2 fw-semibold">Login</button>
            <a href="index.php" class="btn btn-outline-secondary w-100">← Kembali ke Beranda</a>
        </form>
    </div>

</body>
</html>