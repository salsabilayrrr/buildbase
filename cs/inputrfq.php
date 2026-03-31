<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data RFQ - BuildBase</title>
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
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">INPUT DATA RFQ</h2>

        <div class="main-card p-4">
            <form action="proses_rfq.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">1. Informasi Proyek</h5>
                    <div class="mb-3">
                        <input type="text" name="nama_perusahaan" class="form-control custom-input" placeholder="Nama Perusahaan / Klien *" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="deskripsi" class="form-control custom-input" placeholder="Deskripsi Proyek / Judul Proyek *" rows="2" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="date" name="tanggal_rfq" class="form-control custom-input" required>
                        </div>
                        <div class="col">
                            <input type="email" name="email_pelanggan" class="form-control custom-input" placeholder="Email Klien *" required>
                        </div>
                    </div>
                </div>

                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">2. Detail Kebutuhan Barang</h5>
                    <div class="table-responsive">
                        <table class="custom-table" id="tabelBarang">
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 45%;">Nama Barang</th>
                                    <th style="width: 20%;">Satuan</th>
                                    <th style="width: 10%;">Jumlah</th>
                                    <th style="width: 20%;">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" name="nama_barang[]" class="form-control border-0 bg-transparent" placeholder="Input Nama..."></td>
                                    <td>
                                        <select name="satuan[]" class="form-select border-0 bg-transparent">
                                            <option value="Pcs">Pcs</option>
                                            <option value="Unit">Unit</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Meter">Meter</option>
                                        </select>
                                    </td>
                                    <td><input type="number" name="jumlah[]" class="form-control border-0 bg-transparent" placeholder="0"></td>
                                    <td><input type="text" name="catatan[]" class="form-control border-0 bg-transparent"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" onclick="tambahBanyakBaris(10)" class="btn btn-light btn-sm mt-2 border"> +10 Baris </button>
                    <button type="button" id="btnTambah" class="btn btn-white w-100 mt-2 tambah-baris-btn border">
                        <i class="fa-solid fa-circle-plus me-2 fs-4"></i> Tambah 1 Baris
                    </button>
                </div>

                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">3. Dokumen Pendukung (PDF)</h5>
                    <div class="mb-3">
                        <input type="file" name="file_rfq" id="file_rfq" class="form-control custom-input" accept=".pdf" required>
                        <small class="text-muted">Format wajib: PDF (untuk disimpan ke sistem)</small>
                    </div>
                    <p class="text-danger mt-2 fw-bold">*Wajib diisi</p>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="reset" class="btn btn-secondary rounded-pill px-5">Batal</button>
                    <button type="submit" name="submit_rfq" class="btn btn-primary rounded-pill px-4">Kirim Ke Estimator</button>
                </div>
            </form>
        </div>
    </div>

   <nav id="navbar" class="bottom-nav">
    <a href="inputrfq.php" class="active-cycle">
        <i class="fa-solid fa-file-circle-check"></i>
    </a>

    <a href="daftar_rfq.php" class="nav-item">
        <i class="fa-solid fa-file-lines"></i>
    </a>

    <a href="../dashboard/cs.php" class="nav-item">
        <i class="fa-solid fa-house"></i>
    </a>

    <a href="status.php" class="nav-item">
        <i class="fa-solid fa-paper-plane"></i>
    </a>

    <a href="pelanggan.php" class="nav-item">
        <i class="fa-solid fa-user-group"></i>
    </a>
</nav>

    <script>
        // Fitur Tambah Baris
        let rowCount = 1;
        const tableBody = document.querySelector("#tabelBarang tbody");

        document.getElementById("btnTambah").addEventListener("click", function() {
            tambahBanyakBaris(1);
        });

        function tambahBanyakBaris(jumlah) {
            let fragment = document.createDocumentFragment();
            for (let i = 0; i < jumlah; i++) {
                rowCount++;
                let tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${rowCount}</td>
                    <td><input type="text" name="nama_barang[]" class="form-control border-0 bg-transparent"></td>
                    <td>
                        <select name="satuan[]" class="form-select border-0 bg-transparent">
                            <option value="Pcs">Pcs</option>
                            <option value="Unit">Unit</option>
                            <option value="Kg">Kg</option>
                            <option value="Meter">Meter</option>
                        </select>
                    </td>
                    <td><input type="number" name="jumlah[]" class="form-control border-0 bg-transparent"></td>
                    <td><input type="text" name="catatan[]" class="form-control border-0 bg-transparent"></td>
                `;
                fragment.appendChild(tr);
            }
            tableBody.appendChild(fragment);
        }
    </script>
</body>
</html>