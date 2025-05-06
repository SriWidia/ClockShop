<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="./css/output.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="h-screen flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600">

  <div class="w-full max-w-3xl bg-white shadow-2xl rounded-lg overflow-hidden flex flex-col md:flex-row">

    <div class="md:w-1/2 bg-gradient-to-r from-blue-700 to-indigo-600 flex flex-col items-center justify-center text-white p-8">
      <img src="./image/logo/2.png" alt="Logo" class="w-32 mb-4">
      <h2 class="text-3xl font-bold">Selamat Datang</h2>
      <p class="text-sm text-gray-200 text-center mt-2">Masuk untuk mengakses akun Anda.</p>
    </div>

    <div class="md:w-1/2 p-8 flex flex-col justify-center">
      <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Login</h2>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg text-center mb-4">
          <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Username</label>
          <input type="text" name="username" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
        </div>
        <div class="mb-6">
          <label class="block text-sm font-medium text-gray-700">Password</label>
          <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
        </div>
        <button type="submit" class="w-full bg-indigo-500 text-white py-3 px-4 rounded-lg hover:bg-indigo-600 transition-all duration-300">
          Login
        </button>
      </form>
</div>

  </div>

</body>
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.pushState(null, null, location.href);
};
</script>
</html>
