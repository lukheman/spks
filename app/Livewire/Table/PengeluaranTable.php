<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\PengeluaranForm;
use App\Models\Pengeluaran;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PengeluaranTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public string $search = '';

    public PengeluaranForm $form;

    // filter
    public string $bulan;

    public string $total;

    public function mount()
    {
        $this->bulan = date('Y-m');
        $this->total = Pengeluaran::getTotalLabelAttribute($this->bulan);
    }

    #[Computed]
    public function pengeluaranList()
    {
        return Pengeluaran::query()
            ->when($this->search, function ($query) {
                $query->whereAny(['nominal', 'keterangan'], 'like', '%'.$this->search.'%');
            })
                // Filter berdasarkan bulan (YYYY-MM)
            ->when($this->bulan, function ($query) {
                $query->whereYear('created_at', substr($this->bulan, 0, 4))
                    ->whereMonth('created_at', substr($this->bulan, 5, 2));
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function add()
    {
        $this->form->reset();
        $this->openModal('modal-add');
    }

    public function save()
    {

        $this->form->store();
        $this->notifySuccess('Pengeluaran berhasil ditambahkan!');

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

        $this->notifySuccess('Pengeluaran berhasil diperbarui!');
        $this->closeModal('modal-edit');

    }

    public function delete($id)
    {
        $this->form->fill($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data Pengeluaran?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Pengeluaran berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.table.pengeluaran-table');
    }
}
