@php
use App\Enums\StatusPembayaran;

@endphp
<div>

    <h3 class="mb-3">
        DETAIL PEMBAYARAN MINGGU {{ $minggu_ke }}
    </h3>

    <div class="modal fade" id="modal-edit" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="nama_kelas">Nominal</label>
                        <input wire:model="jumlah_bayar" type="text" class="form-control" id="nama_kelas">
                        @error('jumlah_bayar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" wire:click="update" class="btn btn-primary">
        <i class="bi bi-cash-stack"></i> Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </div>


<div class="row">
    <div class="col-6">

        <div class="card mb-3">
            <div class="card-body">
                <div><strong>Kelas:</strong> {{ $user->kelas->nama_kelas ?? '-' }}</div>
                <div><strong>Bulan:</strong> {{ $bulan }} / {{ $tahun }}</div>
                <div><strong>Nominal Mingguan:</strong> Rp 1.000</div>
            </div>
        </div>
    </div>

    {{-- total pemasukan bulan ini --}}
    <div class="col-6">
        <div class="card mb-3">
            <div class="card-body text-center">
                <h5 class="mb-2"><strong>Total Pemasukan Bulan Ini</strong></h5>

                <div class="fs-4">
    {{ $totalPendapatanBulan }}
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="card">

<div class="card-header">

    <div class="row">

        <!-- Filter Bulan -->
        <div class="col-md-2">
            <label class="form-label mb-0">Bulan</label>
            <select class="form-control" wire:model.live="bulan">
                <option value="">-- Pilih Bulan --</option>
                <option value="1">Januari</option>
                <option value="2">Februari</option>
                <option value="3">Maret</option>
                <option value="4">April</option>
                <option value="5">Mei</option>
                <option value="6">Juni</option>
                <option value="7">Juli</option>
                <option value="8">Agustus</option>
                <option value="9">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
        </div>

        <!-- Filter Tahun -->
        <div class="col-md-2">
            <label class="form-label mb-0">Tahun</label>
            <select class="form-control" wire:model.live="tahun">
                <option value="">-- Pilih Tahun --</option>
                @for ($t = 2023; $t <= now()->year + 1; $t++)
                    <option value="{{ $t }}">{{ $t }}</option>
                @endfor
            </select>
        </div>

        <!-- Filter Minggu -->
        <div class="col-md-2">
            <label class="form-label mb-0">Minggu Ke</label>
            <select class="form-control" wire:model.live="minggu_ke">
                @for ($i = 1; $i <= 4; $i++)
                    <option value="{{ $i }}">Minggu {{ $i }}</option>
                @endfor
            </select>
        </div>

<div class="col-md-2">

    <button type="button" wire:click="setor" class="btn btn-primary mt-4">
        Setor Iuran Bulan Ini
    </button>

</div>




    </div>

</div>

        <div class="card-body">
            <table class="table table-bordered m-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px">No</th>
                        <th>Nama Siswa</th>
                        <th>Dibayar</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($this->pembayaranList as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa->nama_siswa }}</td>

<td>
    <div class="form-check form-check-flat form-check-primary">
        <label class="form-check-label">
            <input
                type="checkbox"
                class="form-check-input"
                wire:click="toggleBayar({{ $item->id }})"
                {{ $item->terbayar ? 'checked' : '' }}
            >
            <i class="input-helper"></i>
        </label>
    </div>
</td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-3 text-muted">
                                <em>Tidak ada data pembayaran.</em>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

            <div class="card-footer">

@if ($this->pembayaranList instanceof \Illuminate\Pagination\LengthAwarePaginator && $this->pembayaranList->count())
    {{ $this->pembayaranList->links() }}
@endif


            </div>

    </div>

</div>
