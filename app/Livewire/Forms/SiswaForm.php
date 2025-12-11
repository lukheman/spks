<?php

namespace App\Livewire\Forms;

use App\Models\Siswa;
use Livewire\Form;

class SiswaForm extends Form
{
    public ?Siswa $siswa = null;

    public string $nama_siswa = '';

    public ?int $kelas_id;

    protected function rules(): array
    {
        return [
            'nama_siswa' => 'required',
            'kelas_id' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'nama_siswa.required' => 'Nama Siswa wajib diisi.',
            'kelas_id.required' => 'Kelas Id wajib diisi.',
        ];
    }

    public function store()
    {
        $siswa = Siswa::query()->create($this->validate());
        $this->reset();
    }

    public function update()
    {
        $this->siswa->update($this->validate());

        $this->reset();
    }

    public function delete()
    {
        $this->siswa->delete();
        $this->reset();
    }

    public function fill($id)
    {

        $this->siswa = Siswa::query()->find($id);
        $this->nama_siswa = $this->siswa->nama_siswa;
        $this->kelas_id = $this->siswa->kelas_id;

    }
}
