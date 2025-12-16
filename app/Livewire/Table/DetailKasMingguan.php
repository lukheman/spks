<?php

namespace App\Livewire\Table;

use App\Models\KasMingguan;
use App\Models\KasPembayaran;
use App\Models\Pemasukan;
use App\Models\Siswa;
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

    public function updatedBulan($bulan) {

        $this->totalPendapatanBulan = KasPembayaran::totalPendapatanPerBulanLabel($this->user->kelas->id, $bulan, $this->tahun);
    }

    public function updatedTahun($tahun) {

        $this->totalPendapatanBulan = KasPembayaran::totalPendapatanPerBulanLabel($this->user->kelas->id, $this->bulan, $tahun);
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

        $pembayaran = KasPembayaran::query()
            ->where('kas_mingguan_id', $this->mingguanId)
            ->where('siswa_id', $id)
            ->firstOrFail();

        $pembayaran->terbayar = !$pembayaran->terbayar;
        $pembayaran->save();

        $this->notifySuccess('Status pembayaran diperbarui');
        $this->totalPendapatanBulan = KasPembayaran::totalPendapatanPerBulanLabel($this->user->kelas->id, $this->bulan, $this->tahun);

        $siswa = Siswa::query()->with('kelas')->find($id);

        // catat ke pemasukan
        Pemasukan::create([
            'tanggal' => now(),
            'nominal' => 1000,
            'keterangan' => "{$siswa->nama_siswa} - {$siswa->kelas->nama_kelas}"
        ]);
    }

    #[Computed]
    public function dataMingguan()
    {
        return KasMingguan::findOrFail($this->mingguanId);
    }

#[Computed]
public function siswaList()
{
    return Siswa::query()
        ->where('kelas_id', $this->user->kelas->id)
        ->with(['kasPembayaran' => function ($query) {
            $query->where('kas_mingguan_id', $this->mingguanId);
        }])
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
