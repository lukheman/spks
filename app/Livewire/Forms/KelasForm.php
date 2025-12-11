<?php

namespace App\Livewire\Forms;

use App\Models\Kelas;
use Illuminate\Validation\Rule;
use Livewire\Form;

class KelasForm extends Form
{
    public ?Kelas $kelas = null;

    public string $nama_kelas = '';

    public ?int $bendahara_id = null;

    protected function rules(): array
    {
        return [
            'nama_kelas' => 'required',
            'bendahara_id' => [
                'required',
                'exists:users,id',
                Rule::unique('kelas', 'bendahara_id')->ignore($this->kelas?->id),
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_kelas.required' => 'Nama Kelas wajib diisi.',
            'bendahara_id.exists' => 'Bendahara yang dipilih tidak ditemukan dalam data pengguna.',
            'bendahara_id.unique' => 'Pengguna ini sudah menjadi bendahara di kelas lain.',
        ];
    }

    public function store()
    {
        $kela = Kelas::query()->create($this->validate());
        $this->reset();
    }

    public function update()
    {
        $this->kelas->update($this->validate());

        $this->reset();
    }

    public function delete()
    {
        $this->kelas->delete();
        $this->reset();
    }

    public function fill($id)
    {

        $this->kelas = Kelas::query()->find($id);
        $this->kelas->load('siswa');
        $this->nama_kelas = $this->kelas->nama_kelas;
        $this->bendahara_id = $this->kelas->bendahara_id;
    }
}
