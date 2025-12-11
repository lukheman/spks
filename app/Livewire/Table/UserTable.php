<?php

namespace App\Livewire\Table;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use App\Traits\WithModal;
use App\Traits\WithNotify;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Pengguna')]
class UserTable extends Component
{
    use WithModal;
    use WithNotify;
    use WithPagination;

    public string $search = '';

    public UserForm $form;

    #[Computed]
    public function userList()
    {
        return User::query()
            ->when($this->search, function ($query) {
                $query->whereAny(['name', 'email', 'role'], 'like', '%'.$this->search.'%');
            })
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
        $this->notifySuccess('User berhasil ditambahkan!');

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

        $this->notifySuccess('User berhasil diperbarui!');
        $this->closeModal('modal-edit');

    }

    public function delete($id)
    {
        $this->form->fill($id);
        $this->dispatch('deleteConfirmation', message: 'Yakin untuk menghapus data User?');
    }

    #[On('deleteConfirmed')]
    public function deleteConfirmed()
    {
        $this->form->delete();
        $this->notifySuccess('User berhasil dihapus!');
    }

    public function render()
    {
        return view('livewire.table.user-table');
    }
}
