<?php

namespace App\Livewire\Forms;

use App\Enums\Role;
use App\Models\User;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    public string $name = '';

    public string $email = '';

    public ?Role $role = null;

    protected function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Name wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'role.required' => 'Role wajib diisi.',
        ];
    }

    public function store()
    {
        $user = User::query()->create($this->validate());
        $this->reset();
    }

    public function update()
    {
        $this->user->update($this->validate());

        $this->reset();
    }

    public function delete()
    {
        $this->user->delete();
        $this->reset();
    }

    public function fill($id)
    {

        $this->user = User::query()->find($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;

    }
}
