<?php

namespace App\Livewire\Forms;

use App\Models\Pengeluaran;
use Livewire\Form;

class PengeluaranForm extends Form
{
    public ?Pengeluaran $pengeluaran = null;

    public $tanggal;

    public float $nominal = 0.0;

    public string $keterangan = '';

    protected function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'nominal' => 'required',
            'keterangan' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'nominal.required' => 'Nominal wajib diisi.',
            'keterangan.required' => 'Keterangan wajib diisi.',
        ];
    }

    public function store()
    {
        $pengeluaran = Pengeluaran::query()->create($this->validate());
        $this->reset();
    }

    public function update()
    {
        $this->pengeluaran->update($this->validate());

        $this->reset();
    }

    public function delete()
    {
        $this->pengeluaran->delete();
        $this->reset();
    }

    public function fill($id)
    {

        $this->pengeluaran = Pengeluaran::query()->find($id);
        $this->nominal = $this->pengeluaran->nominal;
        $this->tanggal = $this->pengeluaran->tanggal;
        $this->keterangan = $this->pengeluaran->keterangan;

    }
}
