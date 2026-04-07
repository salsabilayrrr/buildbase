<?php include '../koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Keuangan - BuildBase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
    <style>
        .main-card { background-color: #C2C7FF; border-radius: 40px; padding: 25px; }
        .input-group-custom { background: white; border-radius: 20px; padding: 15px; margin-bottom: 20px; }
        .custom-table th { background-color: #FFC2C2 !important; border: 1px solid #000; }
        .custom-table td { background-color: white !important; border: 1px solid #000; padding: 5px; }
        .eval-text { width: 100%; border-radius: 15px; border: none; padding: 15px; min-height: 100px; }
        
        /* Radio Button Style */
        .decision-option { display: none; }
        .decision-label { 
            display: block; width: 100%; background: white; border-radius: 50px; 
            padding: 10px; text-align: center; margin-bottom: 10px; font-weight: 700; cursor: pointer;
        }
        .decision-option:checked + .decision-label { background-color: #1e1b4b; color: white; }
        
        .btn-simpan { background-color: #1e1b4b; color: white; border-radius: 50px; padding: 10px 40px; border: none; font-weight: 700; }
    </style>
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="Logo" style="width: 40px;" class="ms-3 me-2"> 
            <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Finance</span>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900;">INPUT LAPORAN KEUANGAN</h2>

        <div class="main-card">
            <form id="formLaporan" action="proses_laporan_finance.php" method="POST">
                
                <h5 class="fw-bold mb-2">1. HUBUNGKAN ID BOQ</h5>
                <div class="input-group mb-3">
                    <input type="number" id="id_boq" name="id_boq" class="form-control custom-input" placeholder="Masukkan ID BoQ (Contoh: 1, 2, 3..)" required>
                    <button class="btn btn-dark rounded-pill ms-2 px-4" type="button" onclick="fetchBoQ()">Cek Data</button>
                </div>

                <div class="input-group-custom fw-bold" id="detail_proyek">
                    <p class="mb-1 text-muted">Silahkan masukkan ID BoQ dan klik Cek Data...</p>
                </div>

                <h5 class="fw-bold mb-2">2. RINCIAN EVALUASI BIAYA</h5>
                <div class="table-responsive">
                    <table class="custom-table w-100 text-center" id="tabelBiaya">
                        <thead>
                            <tr>
                                <th width="40%">Item / Material</th>
                                <th width="15%">Qty</th>
                                <th width="20%">Harga Satuan</th>
                                <th width="25%">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="item[]" class="form-control border-0 bg-transparent" placeholder="Nama item.."></td>
                                <td><input type="number" name="qty[]" class="form-control border-0 bg-transparent qty" oninput="hitungRow(this)"></td>
                                <td><input type="number" name="harga[]" class="form-control border-0 bg-transparent harga" oninput="hitungRow(this)"></td>
                                <td><input type="text" class="form-control border-0 bg-transparent subtotal" readonly value="0"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-light w-100 mt-2 border-dashed" onclick="tambahBaris(1)">+ Tambah Baris</button>
                <button type="button" class="btn btn-light w-100 mt-2 border-dashed" onclick="tambahBaris(10)">+ Tambah 10 Baris</button>

                <h5 class="fw-bold mt-4 mb-2">3. CATATAN ANALISIS</h5>
                <textarea name="catatan" class="eval-text" placeholder="Tuliskan analisis margin dan biaya di sini..." required></textarea>

                <h5 class="fw-bold mt-4 mb-2">4. KEPUTUSAN EVALUASI</h5>
                <input type="radio" name="keputusan" value="Disetujui" id="opt_setuju" class="decision-option" onclick="updateMode('setuju')" required>
                <label for="opt_setuju" class="decision-label">Rekomendasi Setuju (Simpan ke DB)</label>

                <input type="radio" name="keputusan" value="Negosiasi" id="opt_nego" class="decision-option" onclick="updateMode('nego')">
                <label for="opt_nego" class="decision-label">Perlu Negosiasi Harga (Lanjut Chat)</label>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" id="btnSubmit" name="simpan_laporan" class="btn-simpan">Simpan Laporan</button>
                </div>
            </form>
        </div>
    </div>

    
    <nav id="navbar" class="bottom-nav">
        <a href="laporankeuangan.php" class="nav-item">
            <i class="fa-solid fa-file-invoice-dollar" style="color: #8B93FF; font-size: 30px;"></i>
        </a>

        <a href="../dashboard/finance.php" class="active-cycle">
            <i class="fa-solid fa-house text-white" style="font-size: 24px;"></i>
        </a>

        <a href="laporannegoisasi.php" class="nav-item">
            <i class="fa-solid fa-handshake text-white" style="font-size: 24px;"></i>
        </a>

        <a href="profile.php" class="nav-item">
            <i class="fa-solid fa-shield-halved text-white" style="font-size: 24px;"></i>
        </a>
    </nav>

    <script>
        // Fungsi Tambah Baris (Bisa sampai 100+)
        function tambahBaris(jumlah) {
            const tbody = document.querySelector("#tabelBiaya tbody");
            for(let i=0; i<jumlah; i++) {
                let row = `<tr>
                    <td><input type="text" name="item[]" class="form-control border-0 bg-transparent"></td>
                    <td><input type="number" name="qty[]" class="form-control border-0 bg-transparent qty" oninput="hitungRow(this)"></td>
                    <td><input type="number" name="harga[]" class="form-control border-0 bg-transparent harga" oninput="hitungRow(this)"></td>
                    <td><input type="text" class="form-control border-0 bg-transparent subtotal" readonly value="0"></td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', row);
            }
        }

        // Hitung Otomatis per Baris
        function hitungRow(input) {
            let row = input.closest('tr');
            let qty = row.querySelector('.qty').value || 0;
            let harga = row.querySelector('.harga').value || 0;
            let subtotal = row.querySelector('.subtotal');
            subtotal.value = (qty * harga).toLocaleString('id-ID');
        }

        // AJAX Fetch Data BoQ
        function fetchBoQ() {
            let id = document.getElementById('id_boq').value;
            if(!id) return alert("Masukkan ID BoQ!");
            
            fetch('get_boq_details.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    let container = document.getElementById('detail_proyek');
                    if(data.status === 'success') {
                        container.innerHTML = `
                            Nama Proyek : ${data.deskripsi}<br>
                            Pelanggan : ${data.nama_perusahaan}<br>
                            Status Saat Ini : ${data.status_boq}
                        `;
                    } else {
                        container.innerHTML = `<span class="text-danger">Data tidak ditemukan!</span>`;
                    }
                });
        }

        // Switch Mode Tombol
        function updateMode(mode) {
            const btn = document.getElementById('btnSubmit');
            const form = document.getElementById('formLaporan');
            if(mode === 'nego') {
                btn.innerText = "Lanjut Negosiasi";
                btn.style.backgroundColor = "#5c7cfa";
                form.onsubmit = function(e) {
                    e.preventDefault();
                    window.location.href = "inputnegoisasi.php?id_boq=" + document.getElementById('id_boq').value;
                };
            } else {
                btn.innerText = "Simpan Laporan";
                btn.style.backgroundColor = "#1e1b4b";
                form.onsubmit = null;
            }
        }
    </script>
</body>
</html>