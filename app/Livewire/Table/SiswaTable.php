<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\SiswaForm;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Kelas')]
class SiswaTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public string $search = '';

    public SiswaForm $form;

    public $selectedKelasId = null;

    public function pilihKelas($kelasId = null)
    {
        $this->selectedKelasId = $kelasId;
        $this->resetPage();
    }

    #[Computed]
    public function siswaList()
    {
        return Siswa::query()
            ->when($this->search, function ($query) {
                $query->whereAny(['nama_siswa', 'kelas_id'], 'like', '%'.$this->search.'%');
            })
            ->where('kelas_id', $this->selectedKelasId)
            ->paginate(10);
    }

    #[Computed]
    public function kelasList()
    {
        return Kelas::query()->withCount('siswa')->get();
    }

    public function add()
    {
        $this->form->reset();
        $this->openModal('modal-add');
    }

    public function save()
    {

        $this->form->kelas_id = $this->selectedKelasId;
        $this->form->store();
        $this->notifySuccess('Siswa berhasil ditambahkan!');

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

        $this->notifySuccess('Siswa berhasil diperbarui!');
        $this->closeModal('modal-edit');

    }

    public function delete($id)
    {
        $this->form->fill($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data Siswa?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Siswa berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.table.siswa-table');
    }
}
