<div>
    <!-- Hero Section - Tema Sekolah -->
    <section class="hero text-center text-white">
        <div class="container hero-content py-5">
            <h1 class="fw-bold display-3"><br>SMK NEGERI 10 KOLAKA</h1>
            <p class="lead mb-4 fs-4">Adalah sekolah menengah yang terletak di Kabupaten Kolaka, Kecamatan Tanggetada yang dimana sekolah ini membuat kegiatan Jumat seribu (JUMSER) yang dimana yaitu pada setiap hari Jumat siswa di SMK Negeri 10 Kolaka mengumpulkan uang seribu rupiah yang dimana tujuannya untuk menumbuhkan semangat anak-anak serta belajar untuk bersedekah </p>
        </div>
    </section>

    <!-- Foto Sekolah + Transparansi Keuangan -->
    <section class="py-5 bg-light">
        <div class="container">

<!-- Foto Sekolah – Galeri Mini -->
<div class="row mb-5 g-4">
    <div class="col-lg-8 mx-auto">
        <h2 class="text-center section-title mb-4">Potret Sekolah Kami</h2>

        <div class="row g-3">
            <!-- Foto 1 -->
            <div class="col-6 col-md-3">
                <img src="{{ asset('images/sekolah/foto1.jpeg') }}"
                     alt="Gedung Sekolah Depan"
                     class="img-fluid rounded-3 shadow-sm w-100 h-100"
                     style="object-fit: cover; height: 200px;">
            </div>
            <!-- Foto 2 -->
            <div class="col-6 col-md-3">
                <img src="{{ asset('images/sekolah/foto2.jpeg') }}"
                     alt="Lapangan Upacara"
                     class="img-fluid rounded-3 shadow-sm w-100 h-100"
                     style="object-fit: cover; height: 200px;">
            </div>
            <!-- Foto 3 -->
            <div class="col-6 col-md-3">
                <img src="{{ asset('images/sekolah/foto3.jpeg') }}"
                     alt="Kelas Belajar"
                     class="img-fluid rounded-3 shadow-sm w-100 h-100"
                     style="object-fit: cover; height: 200px;">
            </div>
            <!-- Foto 4 -->
            <div class="col-6 col-md-3">
                <img src="{{ asset('images/sekolah/foto4.jpeg') }}"
                     alt="Kegiatan Ekstrakurikuler"
                     class="img-fluid rounded-3 shadow-sm w-100 h-100"
                     style="object-fit: cover; height: 200px;">
            </div>
        </div>

    </div>
</div>

            <!-- Log Pemasukan & Pengeluaran (Transparansi Keuangan) -->
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <h2 class="text-center section-title mb-5">Transparansi Keuangan Sekolah</h2>

                    <div class="row g-4">
                        <!-- Pemasukan -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-success text-white text-center py-3">
                                    <h4 class="mb-0"><i class="fas fa-arrow-down me-2"></i> PEMASUKAN BULAN INI</h4>
                                </div>
                                <div class="card-body text-success">
                                    <h2 class="text-center fw-bold">{{ $totalPemasukanBulan}}</h2>
                                    <hr>
                                    <ul class="list-unstyled">
                @foreach ($this->pemasukanBulanList as $item)
                                        <li><strong>{{ $item->keterangan}}</strong> : {{ $item->nominal_label }}</li>

                @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Pengeluaran -->
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-header bg-danger text-white text-center py-3">
                                    <h4 class="mb-0"><i class="fas fa-arrow-up me-2"></i> PENGELUARAN BULAN INI</h4>
                                </div>
                                <div class="card-body text-danger">
                                    <h2 class="text-center fw-bold">{{ $totalPengeluaranBulan}}</h2>
                                    <hr>
                                    <ul class="list-unstyled">
                @foreach ($this->pengeluaranBulanList as $item)
                                        <li><strong>{{ $item->keterangan}}</strong> : {{ $item->nominal_label }}</li>

                @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
