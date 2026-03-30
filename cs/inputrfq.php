<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data RFQ - Customer Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/styleInputRFQCS.css">
</head>
<body>

    <nav class="navbar-custom">
        <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="ms-3 me-2"> <span class="fw-black fs-4 text-dark" style="font-weight: 800;">Customer Service</span>
        </div>
        <div class="me-3">
            <a href="#" class="logout-btn">
                <div class="icon-circle">
                    <i class="fa-solid fa-right-from-bracket logout-icon-fa"></i>
                </div>
                <span class="logout-text">Logout</span>
            </a>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        <h2 class="text-center fw-black mb-4" style="font-weight: 900; letter-spacing: 1px;">
            INPUT DATA REQUEST FOR QUATATION (RFQ)
        </h2>

        <div class="main-card p-4">
            <form>
                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">1. Informasi Proyek</h5>
                    <div class="mb-3">
                        <input type="text" class="form-control custom-input" placeholder="Nama Klien *">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control custom-input" placeholder="Judul Proyek *">
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" class="form-control custom-input" placeholder="Tanggal*">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control custom-input" placeholder="Tenggat *">
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control custom-input" placeholder="Email Klien *">
                    </div>
                </div>

                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">2. Detail Kebutuhan Barang</h5>
                    <div class="table-responsive">
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No</th>
                                    <th style="width: 30%;">Nama Barang</th>
                                    <th style="width: 20%;">Satuan</th>
                                    <th style="width: 15%;">Jumlah</th>
                                    <th style="width: 25%;">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>[Input...]</td>
                                    <td>[Drop...]</td>
                                    <td>...</td>
                                    <td>...</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-white w-100 mt-2 tambah-baris-btn">
                        <i class="fa-solid fa-circle-plus me-2 fs-4"></i> Tambah Baris
                    </button>
                </div>

                <div class="form-section mb-4">
                    <h5 class="fw-bold mb-3">3. Dokumen Pendukung</h5>
                    <div class="input-group custom-upload">
                        <input type="text" class="form-control" placeholder="[ Upload File RFQ Asli (PDF/Doc) * ]" readonly>
                        <span class="input-group-text">[ Browse ]</span>
                    </div>
                    <p class="text-danger mt-2 fw-bold">*Wajib diisi</p>
                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-5 py-2 fw-bold" style="background-color: #6c757d;">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-bold" style="background-color: #3b5bdb; border: none;">Kirim Ke Estimator</button>
                </div>
            </form>
        </div>
    </div>

    <nav class="bottom-nav">
        <a href="#" class="home-button">
            <i class="fa-solid fa-file-circle-plus fs-1 text-primary"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-file-lines fs-2 text-white"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-house fs-2 text-white"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-share-nodes fs-2 text-white"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fa-solid fa-users-gear fs-2 text-white"></i>
        </a>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>