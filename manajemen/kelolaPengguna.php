<?php
session_start();
include "../koneksi.php";

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'manager'){
    header("Location: ../index.php");
    exit;
}

$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Data Pengguna - Manajemen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/styleKelolaPenggunaManager.css">
</head>
<body>

<div class="device-wrapper">
    <div class="device-screen">
        
        <header class="dashboard-header">
            <div class="header-left">
                <img src="../assets/img/logo.png" class="header-logo" alt="Logo">
                <span class="header-title">Manajemen</span>
            </div>
            <a href="../logout.php" class="btn-logout-pill">
                <div class="logout-icon-box">
                    <img src="../assets/img/logout.png" alt="Logout">
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </header>

        <main class="scroll-content">
            <div class="container text-center pt-4">
                
            <div class="header-title-container">
                <div class="icon-top-box">
                    <img src="../assets/img/user.png" alt="User Icon" width="60">
                </div>
                <h2 class="main-page-title">Kelola Data Pengguna</h2>
            </div>

                <div class="add-user-section mb-4">
                    <a href="inputUser.php" class="btn-add-link">
                        <img src="../assets/img/tambahUser.png" alt="Add" width="65">
                    </a>
                </div>

                <div class="search-container mb-4">
                    <input type="text" id="searchInput" placeholder="Ketik Nama Pengguna..." class="search-input">
                    <span class="search-icon">🔍</span>
                </div>

                <h3 class="section-subtitle">Daftar Pengguna Aktif</h3>

                <div class="table-responsive px-2">
                <table class="table table-bordered custom-table" id="userTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Peran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                                <div class="action-icons">
                                    <a href="edit_user.php?id=<?php echo $row['id']; ?>">
                                        <img src="../assets/img/edit.png" alt="Edit">
                                    </a>
                                    <a href="proses_hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus?')">
                                        <img src="../assets/img/sampah.png" alt="Delete">
                                    </a>
                                    <a href="reset_pass.php?id=<?php echo $row['id']; ?>">
                                        <img src="../assets/img/key.png" alt="Key">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </main>

        <nav class="bottom-nav" id="navbar">
            <div class="nav-item">
                <a href="persetujuanProduksi.php">
                    <img src="../assets/img/berkas.png" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <a href="penolakan.php">
                    <img src="../assets/img/arsip.jpg" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <a href="../dashboard/manager.php">
                    <img src="../assets/img/home.png" class="nav-icon-side">
                </a>
            </div>
            <div class="nav-item">
                <div class="active-extra-circle">
                    <a href="kelolaPengguna.php">
                        <img src="../assets/img/akun.jpg" class="nav-icon-active">
                    </a>
                </div>
            </div>
        </nav>

    </div>
</div>

<script>
    const footer = document.getElementById('navbar');
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('userTable');
    const tr = table.getElementsByTagName('tr');

    // --- SEARCHING (NAMA & ROLE) ---
    searchInput.addEventListener('input', function() {
        const filter = this.value.toLowerCase();
        for (let i = 1; i < tr.length; i++) {
            const tdNama = tr[i].getElementsByTagName('td')[0];
            const tdRole = tr[i].getElementsByTagName('td')[1];
            if (tdNama || tdRole) {
                const textNama = (tdNama.textContent || tdNama.innerText).toLowerCase();
                const textRole = (tdRole.textContent || tdRole.innerText).toLowerCase();
                tr[i].style.display = (textNama.includes(filter) || textRole.includes(filter)) ? "" : "none";
            }
        }
    });

    const toggleFooter = (isVisible) => {
        if (!footer) return;
        if (isVisible) {
            footer.classList.remove('hidden-footer');
        } else {
            footer.classList.add('hidden-footer');
        }
    };

    searchInput.addEventListener('focus', () => toggleFooter(false));
    searchInput.addEventListener('blur', () => {
        
        setTimeout(() => toggleFooter(true), 150);
    });

    const originalHeight = window.innerHeight;
    
    if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', () => {
            if (window.visualViewport.height < originalHeight - 150) {
                toggleFooter(false);
            } else {
                toggleFooter(true);
            }
        });
    }

    window.addEventListener('scroll', () => {
        if (document.activeElement === searchInput) {
            toggleFooter(false);
        }
    });
</script>

</body>
</html>