<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\PemasukanForm;
use App\Models\Pemasukan;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PemasukanTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public string $search = '';

    public PemasukanForm $form;

    // filter
    public string $bulan;

    public string $total;

    public function mount()
    {
        $this->bulan = date('Y-m');
        $this->total = Pemasukan::getTotalLabelAttribute($this->bulan);
    }

    #[Computed]
    public function pemasukanList()
    {
        return Pemasukan::query()
            ->when($this->search, function ($query) {
                $query->whereAny([
                    'nominal',
                ], 'like', '%'.$this->search.'%')
                    ->orWhereHas('kasPembayaran.siswa', function ($q) {
                        $q->where('nama', 'like', '%'.$this->search.'%');
                    });
            })
            // Filter berdasarkan bulan (YYYY-MM)
            ->when($this->bulan, function ($query) {
                $query->whereYear('created_at', substr($this->bulan, 0, 4))
                    ->whereMonth('created_at', substr($this->bulan, 5, 2));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    // Method untuk reset filter
    public function resetFilter()
    {
        $this->search = '';
        $this->tahun = date('Y');
        $this->bulan = date('m');
        $this->resetPage();
    }

    // Method untuk filter berdasarkan tahun saja
    public function filterTahun()
    {
        $this->resetPage();
    }

    // Method untuk filter berdasarkan bulan saja
    public function filterBulan()
    {
        $this->resetPage();
    }

    public function add()
    {
        $this->form->reset();
        $this->openModal('modal-add');
    }

    public function save()
    {
        $this->form->store();
        $this->notifySuccess('Pemasukan berhasil ditambahkan!');
        $this->closeModal('modal-add');
        $this->form->reset();
    }

    public function detail($id)
    {
        $this->form->fill($id);
        $this->openModal('modal-detail');
    }

    public function edit($id)
    {
        $this->form->fill($id);
        $this->openModal('modal-edit');
    }

    public function update()
    {
        $this->form->update();
        $this->notifySuccess('Pemasukan berhasil diperbarui!');
        $this->closeModal('modal-edit');
    }

    public function delete($id)
    {
        $this->form->fill($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data Pemasukan?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Pemasukan berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.table.pemasukan-table');
    }
}
