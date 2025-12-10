<div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0 fw-semibold">Cetak Laporan Pengeluaran</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <!-- PILIH BULAN -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">Bulan</label>
                    <select class="form-select" wire:model="bulan">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}">
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- PILIH TAHUN -->
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-medium">Tahun</label>
                    <select class="form-select" wire:model="tahun">
                        <option value="">-- Pilih Tahun --</option>
                        @foreach (range(date('Y') - 5, date('Y')) as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- TOMBOL CETAK -->
                <div class="col-md-4 mb-3 d-flex align-items-end">
                    <button class="btn btn-primary w-100"
                        wire:click="cetak"
                        wire:loading.attr="disabled">

                        <span wire:loading.remove>
                            <i class="bi bi-printer"></i> Cetak Laporan
                        </span>

                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm"></span>
                            Mencetak...
                        </span>

                    </button>
                </div>

            </div>

        </div>
    </div>

</div>
