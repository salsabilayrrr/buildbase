<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Klien - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="ms-3 me-2"> 
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Customer Service</span>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900; letter-spacing: 1px;">INPUT DATA KLIEN</h2>

        <div class="main-card p-4" style="background-color: #C2C7FF; border-radius: 30px;">
            <form action="proses_klien.php" method="POST">
                
                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">Informasi Klien</h5>
                    
                    <div class="mb-3">
                        <select name="tipe_klien" id="tipe_klien" class="form-select custom-input" required onchange="cekTipeKlien()">
                            <option value="" disabled selected>-- Pilih Tipe Klien --</option>
                            <option value="Perorangan">Perorangan</option>
                            <option value="Perusahaan">Perusahaan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="nama_perusahaan" class="form-control custom-input" placeholder="Nama Lengkap Klien / PIC *" required>
                    </div>

                    <div class="mb-3" id="input_instansi" style="display: none;">
                        <input type="text" name="nama_instansi" id="nama_instansi_field" class="form-control custom-input" placeholder="Nama Perusahaan / Instansi *">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <input type="email" name="email" class="form-control custom-input" placeholder="Email Klien *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="nomor_telepon" class="form-control custom-input" placeholder="Nomor Telepon / WA *" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <textarea name="alamat" class="form-control custom-input" placeholder="Alamat Lengkap *" rows="3" required></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="reset" class="btn btn-secondary rounded-pill px-5">Batal</button>
                    <button type="submit" name="submit_klien" class="btn btn-primary rounded-pill px-4">Simpan Data Klien</button>
                </div>
            </form>
        </div>
    </div>

    <nav id="navbar" class="bottom-nav">
        <a href="inputrfq.php" class="nav-item">
            <i class="fa-solid fa-file-circle-check text-white" style="font-size: 24px;"></i>
        </a>
        <a href="kelolarfq.php" class="nav-item">
            <i class="fa-solid fa-file-lines text-white" style="font-size: 24px;"></i>
        </a>
        <a href="../dashboard/cs.php" class="nav-item">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>
        <a href="laporannegoisasi.php" class="nav-item">
            <i class="fa-solid fa-paper-plane text-white" style="font-size: 24px;"></i>
        </a>
        <a href="dataklien.php" class="active-cycle">
            <i class="fa-solid fa-user-group" style="color: #8B93FF; font-size: 30px;"></i>
        </a>
    </nav>

    <script>
        function cekTipeKlien() {
            var tipe = document.getElementById("tipe_klien").value;
            var inputInstansi = document.getElementById("input_instansi");
            var instansiField = document.getElementById("nama_instansi_field");

            if (tipe === "Perusahaan") {
                inputInstansi.style.display = "block";
                instansiField.setAttribute("required", "required");
            } else {
                inputInstansi.style.display = "none";
                instansiField.removeAttribute("required");
                instansiField.value = "";
            }
        }
    </script>
</body>
</html>