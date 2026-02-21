<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuildBase - Customer Service Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleDashboardCs.css">
</head>
<body>
    <header class="navbar-custom">
    <div class="flex items-center"> <img src="../assets/img/logo.png" alt="BuildBase" class="w-20 h-20">
        <span class="text-2xl font-black text-black tracking-tighter -ml-2">BuildBase</span>
    </div>

    <a href="../index.php" class="logout-btn">
        <div class="icon-circle">
            <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
        </div>
        <span class="logout-text">Logout</span>
    </a>
    </header>

    <main class="p-6 space-y-6">
        <h1 class="halo-text text-3xl text-center mt-4">Halo Customer Service</h1>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-light-purple p-4 rounded-[30px] shadow-md flex flex-col items-center">
                <img src="../assets/img/cs2.png" alt="RFQ" class="w-16 h-18 mb-2">
                <p class="font-black text-black text-xs text-center">5 RFQ Masuk</p>
            </div>
            <div class="bg-light-purple p-4 rounded-[30px] shadow-md flex flex-col items-center">
                <img src="../assets/img/cs1.png" alt="Estimator" class="w-16 h-18 mb-2">
                <p class="font-black text-black text-xs text-center leading-tight">2 Diteruskan ke Estimator</p>
            </div>
        </div>

        <button class="bg-btn-purple w-full py-4 rounded-2xl flex items-center justify-center space-x-3 shadow-md active:scale-95 transition">
            <div class="bg-white w-8 h-8 rounded-lg flex items-center justify-center">
                <i class="fa-solid fa-plus text-[#B2B9FF] text-xl"></i>
            </div>
            <span class="font-black text-black text-lg">Tambahkan RFQ Baru</span>
        </button>

        <div class="flex space-x-2">
            <div class="bg-light-purple flex-grow flex items-center px-5 py-3 rounded-2xl shadow-inner">
                <input type="text" placeholder="Ketik Nama Proyek/Klien..." class="bg-transparent w-full outline-none placeholder-indigo-800 text-sm font-bold text-indigo-900">
                <i class="fa-solid fa-magnifying-glass text-white text-2xl"></i>
            </div>
            <button class="bg-light-purple px-4 rounded-2xl shadow-md">
                <i class="fa-solid fa-chevron-down text-black"></i>
            </button>
        </div>

        <div class="space-y-3">
            <h2 class="font-black text-center text-black tracking-tight text-lg uppercase">Daftar Request For Quotation (RFQ)</h2>
            <div class="overflow-hidden rounded-lg">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>PT. Maju</td>
                            <td>12-11-2025</td>
                            <td>Baru</td>
                            <td><i class="fa-solid fa-pencil text-white"></i></td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Bpk. Budi</td>
                            <td>13-11-2025</td>
                            <td>Proses</td>
                            <td><i class="fa-solid fa-pencil text-white"></i></td>
                        </tr>
                        <tr><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td></tr>
                        <tr><td>...</td><td>...</td><td>...</td><td>...</td><td>...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <nav id="navbar" class="bottom-nav">
        <i class="fa-solid fa-file-circle-plus text-white text-3xl"></i>
        <i class="fa-solid fa-file-lines text-white text-3xl"></i>
        <div class="home-button">
            <i class="fa-solid fa-house text-[#8B93FF] text-3xl"></i>
        </div>
        <i class="fa-solid fa-paper-plane text-white text-3xl"></i>
        <i class="fa-solid fa-user-group text-white text-3xl"></i>
    </nav>

    <script>
        // SCRIPT AGAR NAVBAR TENGGELAM SAAT MENGETIK
        const navbar = document.getElementById('navbar');
        const inputs = document.querySelectorAll('input');

        inputs.forEach(input => {
            input.addEventListener('focus', () => {
                // Sembunyikan navbar (tenggelam)
                navbar.style.transform = 'translateY(100px)';
            });
            input.addEventListener('blur', () => {
                // Tampilkan kembali navbar
                navbar.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>