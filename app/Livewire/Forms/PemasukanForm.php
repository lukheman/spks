<?php

namespace App\Livewire\Forms;

use App\Models\Pemasukan;
use Livewire\Form;

class PemasukanForm extends Form
{
    public ?Pemasukan $pemasukan = null;

    public $tanggal;

    public bool $pemasukan_external = false;

    public float $nominal = 0.0;

    public string $keterangan = '';

    protected function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'pemasukan_external' => 'required|boolean',
            'nominal' => 'required|numeric|min:1',
            'keterangan' => 'required|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ];
    }

    public function store()
    {
        Pemasukan::create($this->validate());

        $this->reset();
    }

    public function update()
    {
        $data = $this->validate();

        $this->pemasukan->update($data);

        $this->reset();
    }

    public function delete()
    {
        $this->pemasukan->delete();
        $this->reset();
    }

    public function fill($id)
    {
        $this->pemasukan = Pemasukan::find($id);

        $this->tanggal = $this->pemasukan->tanggal;
        $this->pemasukan_external = $this->pemasukan->pemasukan_external;
        $this->nominal = $this->pemasukan->nominal;
        $this->keterangan = $this->pemasukan->keterangan;
    }
}
