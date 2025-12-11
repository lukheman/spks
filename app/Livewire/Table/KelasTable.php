<?php

namespace App\Livewire\Table;

use App\Enums\Role;
use App\Livewire\Forms\KelasForm;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Kelas')]
class KelasTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public string $search = '';

    public KelasForm $form;

    #[Computed]
    public function kelasList()
    {
        return Kelas::query()
            ->when($this->search, function ($query) {
                $query->whereAny(['nama_kelas'], 'like', '%'.$this->search.'%');
            })
            ->paginate(10);
    }

    #[Computed]
    public function bendaharaList()
    {
        return User::query()->where('role', Role::BENDAHARA_KELAS)->get();
    }

    #[Computed]
    public function siswaList()
    {
        if (! $this->form->kelas) {
            return collect();
        }

        return Siswa::where('kelas_id', $this->form->kelas->id)
            ->orderBy('nama_siswa')
            ->paginate(10);
    }

    public function showSiswaList($id)
    {

        $this->form->fill($id);
        $this->openModal('modal-siswa-list');

    }

    public function add()
    {
        $this->form->reset();
        $this->openModal('modal-add');
    }

    public function save()
    {

        $this->form->store();
        $this->notifySuccess('Kelas berhasil ditambahkan!');

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

        $this->notifySuccess('Kelas berhasil diperbarui!');
        $this->closeModal('modal-edit');

    }

    public function delete($id)
    {
        $this->form->fill($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data Kelas?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('Kelas berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.table.kelas-table');
    }
}
