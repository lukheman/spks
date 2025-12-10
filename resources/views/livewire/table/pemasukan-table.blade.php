<div>
    <h1>Pemasukan</h1>


<!-- Modal Add Form -->
<div class="modal fade" id="modal-add" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pemasukan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

<div class="modal-body">


<div class="form-group">
    <label for="tanggal">Tanggal</label>
    <input type="date" class="form-control" id="tanggal" wire:model="form.tanggal">
</div>

    <!-- PEMASUKAN EXTERNAL -->
    <input type="hidden" value="1" wire:model="form.pemasukan_external">

    <!-- NOMINAL -->
    <div class="form-group mb-3">
        <label class="fw-semibold">Nominal Pemasukan</label>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input wire:model="form.nominal" type="number" class="form-control" placeholder="Masukkan nominal...">
        </div>
        @error('form.nominal')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <!-- KETERANGAN -->
    <div class="form-group mb-3">
        <label class="fw-semibold">Keterangan</label>
        <textarea wire:model="form.keterangan" class="form-control" rows="3"
                  placeholder="Contoh: Penjualan bibit, pemasukan donasi, dll"></textarea>
        @error('form.keterangan')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>

            <div class="modal-footer">
                <button type="button" wire:click="save" class="btn btn-primary">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Form -->
<div class="modal fade" id="modal-detail" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pemasukan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                  <fieldset disabled>
                    <div class="form-group mb-3">
    <label for="kas_pembayaran_id">Kas Pembayaran Id</label>
    <input wire:model="form.kas_pembayaran_id" type="text" class="form-control" id="kas_pembayaran_id">
    @error('form.kas_pembayaran_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="nominal">Nominal</label>
    <input wire:model="form.nominal" type="text" class="form-control" id="nominal">
    @error('form.nominal')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
  </fieldset>
            </div>

        </div>
    </div>
</div>

<!-- Modal Detail Form -->
<div class="modal fade" id="modal-edit" tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Pemasukan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                    <div class="form-group mb-3">
    <label for="kas_pembayaran_id">Kas Pembayaran Id</label>
    <input wire:model="form.kas_pembayaran_id" type="text" class="form-control" id="kas_pembayaran_id">
    @error('form.kas_pembayaran_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
<div class="form-group mb-3">
    <label for="nominal">Nominal</label>
    <input wire:model="form.nominal" type="text" class="form-control" id="nominal">
    @error('form.nominal')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click="update" class="btn btn-warning">
                    Perbarui
                </button>
            </div>

        </div>
    </div>
</div>

        <div class="card">
        <div class="card-body">

<div class="row mb-4">
    <!-- Filter Bulan -->
    <div class="col-md-6">
        <label class="form-label mb-2 fw-semibold">
            <i class="bi bi-calendar-month me-1"></i>Filter Bulan
        </label>
        <div class="input-group">
            <span class="input-group-text bg-primary text-white">
                <i class="bi bi-calendar3"></i>
            </span>
            <input type="month" class="form-control" wire:model.live="bulan">
        </div>
    </div>

    <!-- Total Pemasukan -->
    <div class="col-md-6">
        <label class="form-label mb-2 fw-semibold">
            <i class="bi bi-cash-stack me-1"></i>Total Pemasukan
        </label>
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center justify-content-between p-3">
                <div>
                    <small class="text-muted d-block mb-1">
                        @if($bulan)
                            <i class="bi bi-calendar-check me-1"></i>
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $bulan)->translatedFormat('F Y') }}
                        @else
                            <i class="bi bi-calendar-x me-1"></i>
                            Semua Periode
                        @endif
                    </small>
                    <h3 class="mb-0 fw-bold text-primary">
                        {{ \App\Models\Pemasukan::getTotalLabelAttribute($bulan) }}
                    </h3>
                </div>
                <div class="bg-gradient-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        </div>

    <div class="card">

        <div class="card-header">


        <button class="btn btn-primary" wire:click="add">Tambah Pemasukan</button>

        </div>

        <div class="card-body">

            <table class="table table-bordered align-middle">
  <thead class="table-light">
    <tr>
      <th scope="col">#</th>
    <th>Tanggal</th>
    <th>Sumber Dana</th>
      <th scope="col">Nominal</th>
    </tr>
  </thead>
  <tbody>
    @forelse ($this->pemasukanList as $item)
    <tr>
      <th scope="row">{{ $loop->index + $this->pemasukanList->firstItem() }}</th>
        <td>{{$item->created_at}}</td>
    <td>{{ $item->keterangan}}</td>
      <td>{{ $item->nominal_label }}</td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center text-muted py-3">
        <em>Tidak ada data tersedia.</em>
    </td>
</tr>
@endforelse
  </tbody>
</table>
        </div>

        <div class="card-footer">

    {{ $this->pemasukanList->links()}}
        </div>


    </div>
