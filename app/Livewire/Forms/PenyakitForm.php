<?php

namespace App\Livewire\Forms;

use App\Models\Penyakit;
use Illuminate\Support\Facades\Storage;
use Livewire\Form;

class PenyakitForm extends Form
{
    public ?Penyakit $penyakit = null;

    public string $kode = '';

    public $nama = '';

    public $deskripsi = '';

    public $solusi = '';

    public $photo;

    protected function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string|min:5',
            'photo' => ['nullable', 'image', 'max:2048'], // Max 2MB
            'solusi' => 'required|string|min:5',
        ];
    }

    protected function messages(): array
    {
        return [
            'kode.required' => 'Kode penyakit wajib diisi.',
            'kode.string' => 'Kode penyakit harus berupa teks.',
            'kode.max' => 'Kode penyakit tidak boleh lebih dari 50 karakter.',
            'kode.unique' => 'Kode penyakit sudah terdaftar, gunakan kode lain.',

            'nama.required' => 'Nama penyakit wajib diisi.',
            'nama.string' => 'Nama penyakit harus berupa teks.',
            'nama.max' => 'Nama penyakit tidak boleh lebih dari 255 karakter.',

            'photo.image' => 'File yang diunggah harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',

            'deskripsi.required' => 'Deskripsi penyakit wajib diisi.',
            'deskripsi.string' => 'Deskripsi penyakit harus berupa teks.',
            'deskripsi.min' => 'Deskripsi penyakit harus memuat minimal 5 karakter.',

            'solusi.required' => 'Solusi penyakit wajib diisi.',
            'solusi.string' => 'Solusi penyakit harus berupa teks.',
            'solusi.min' => 'Solusi penyakit harus memuat minimal 5 karakter.',

        ];
    }

    public function store()
    {

        $penyakit = Penyakit::create($this->validate());

        if ($this->photo) {
            // Store new photo
            $path = $this->photo->store('photos', 'public');
            $penyakit->update([
                'photo' => $path,
            ]);
        }

        $this->reset();
    }

    public function update()
    {

        $this->validate();

        $this->penyakit->update([

            'kode' => $this->kode,
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'solusi' => $this->solusi,

        ]);

        if ($this->photo) {
            // Delete old photo if exists
            if ($this->penyakit->photo) {
                Storage::disk('public')->delete($this->penyakit->photo);
            }
            // Store new photo
            $path = $this->photo->store('photos', 'public');
            $this->penyakit->update([
                'photo' => $path,
            ]);

        }

        $this->reset();
    }

    public function delete()
    {
        $this->penyakit->delete();
        $this->reset();
    }
}
