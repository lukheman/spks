<?php

namespace App\Livewire\Table;

use App\Models\KasMingguan;
use App\Models\KasPembayaran;
use App\Models\Pemasukan;
use App\Models\User;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class DetailKasMingguan extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public ?int $jumlah_bayar;

    public int $mingguanId;

    public ?KasPembayaran $selectedKasPembayaran = null;

    public ?User $user;

    // filter
    public string $tahun = '2025';

    public string $bulan;

    public string $minggu_ke;

    public string $totalPendapatanBulan;

    public function mount()
    {
        $this->user = auth()->user();
        $this->user->load('kelas');

        $this->mingguanId = 1;

        // Ambil data dari database
        $mingguan = KasMingguan::query()->findOrFail(1);

        // Isi otomatis
        $this->tahun = $mingguan->tahun ?? date('Y');
        $this->bulan = $mingguan->bulan ?? date('m');
        $this->minggu_ke = $mingguan->minggu_ke ?? 1;

        $this->totalPendapatanBulan = KasPembayaran::totalPendapatanPerBulanLabel($this->user->kelas->id, $this->bulan, $this->tahun);
    }

    public function setor()
    {
        Pemasukan::query()->create([

            'tanggal' => now(),
            'nominal' => KasPembayaran::totalPendapatanPerBulan($this->user->kelas->id, $this->bulan, $this->tahun),
            'keterangan' => $this->user->kelas->nama_kelas,

        ]);

        $this->notifySuccess('Berhasil menyetor pemasukan ke bendahara osis');
    }

    public function toggleBayar($id)
    {
        $pembayaran = KasPembayaran::findOrFail($id);

        // Toggle true/false
        $pembayaran->terbayar = ! $pembayaran->terbayar;
        $pembayaran->save();

        $this->notifySuccess('Status pembayaran diperbarui');
    }

    #[Computed]
    public function dataMingguan()
    {
        return KasMingguan::findOrFail($this->mingguanId);
    }

    #[Computed]
    public function pembayaranList()
    {
        $kelasId = $this->user->kelas->id;

        // Cari ID kas_mingguan yang sesuai filter
        $mingguan = KasMingguan::query()
            ->where('tahun', $this->tahun)
            ->where('bulan', $this->bulan)
            ->when($this->minggu_ke, fn ($q) => $q->where('minggu_ke', $this->minggu_ke)
            )
            ->first();

        if (! $mingguan) {
            return collect(); // Jika tidak ada data, return collection kosong
        }

        return KasPembayaran::query()
            ->with('siswa')
            ->where('kas_mingguan_id', $mingguan->id)
            ->whereHas('siswa', fn ($q) => $q->where('kelas_id', $kelasId)
            )
            ->orderBy('siswa_id')
            ->paginate(10);
    }

    public function edit($id)
    {

        $this->selectedKasPembayaran = KasPembayaran::findOrFail($id);
        $this->jumlah_bayar = $this->selectedKasPembayaran->jumlah_bayar;
        $this->openModal('modal-edit');

    }

    public function update()
    {

        $this->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:0'],
        ], [
            'jumlah_bayar.required' => 'Jumlah bayar wajib diisi.',
            'jumlah_bayar.numeric' => 'Jumlah bayar harus berupa angka.',
            'jumlah_bayar.min' => 'Jumlah bayar tidak boleh kurang dari 0.',
        ]);

        $this->selectedKasPembayaran->jumlah_bayar = $this->jumlah_bayar;
        $this->selectedKasPembayaran->save();

        $this->notifySuccess('Berhasil menyimpan perubahan');
        $this->closeModal('modal-edit');

    }

    public function render()
    {
        return view('livewire.table.detail-kas-mingguan');
    }
}
