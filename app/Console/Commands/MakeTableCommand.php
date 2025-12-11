<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class MakeTableCommand extends Command
{
    protected $signature = 'table {name}';

    protected $description = 'Generate a Livewire table component and its view using stubs';

    private function generateTable(array $columnList, string $varName)
    {
        $colCount = count($columnList) + 2;

        // Header kolom
        $thead = "      <th scope=\"col\">#</th>\n";
        foreach ($columnList as $column) {
            $thead .= '      <th scope="col">'.Str::title(str_replace('_', ' ', $column))."</th>\n";
        }
        $thead .= "      <th class=\"float-end\">Aksi</th>\n";

        // Body kolom
        $tbody = "    @forelse (\$this->{$varName}List as \$item)\n";
        $tbody .= "    <tr>\n";
        $tbody .= "      <th scope=\"row\">{{ \$loop->index + \$this->{$varName}List->firstItem() }}</th>\n";
        foreach ($columnList as $column) {
            $tbody .= "      <td>{{ \$item->{$column} }}</td>\n";
        }

        $tbody .= <<<HTML
          <td class="float-end">
              <button type="button" class="btn btn-sm btn-info" wire:click="detail({{ \$item->id }})">
                <i class="bi bi-eye"></i> Detail
              </button>
              <button type="button" class="btn btn-sm btn-warning" wire:click="edit({{ \$item->id }})">
                <i class="bi bi-pencil"></i> Edit
              </button>
              <button type="button" class="btn btn-sm btn-danger" wire:click="delete({{ \$item->id }})">
                <i class="bi bi-trash"></i> Hapus
              </button>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="{$colCount}" class="text-center text-muted py-3">
                <em>Tidak ada data tersedia.</em>
            </td>
        </tr>
        @endforelse
        HTML;

        // Gabungkan jadi HTML table utuh
        return <<<HTML
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
    {$thead}    </tr>
      </thead>
      <tbody>
    {$tbody}
      </tbody>
    </table>
    HTML;
    }

    private function generateForm(array $columnList)
    {
        $html = '';

        foreach ($columnList as $column) {
            // Ubah nama label: "kode_penyakit" -> "Kode Penyakit"
            $label = Str::title(str_replace('_', ' ', $column));

            // Tentukan type input berdasarkan nama kolom
            $type = 'text';
            if (Str::contains($column, ['email'])) {
                $type = 'email';
            } elseif (Str::contains($column, ['password'])) {
                $type = 'password';
            } elseif (Str::contains($column, ['tanggal', 'date'])) {
                $type = 'date';
            } elseif (Str::contains($column, ['jumlah', 'harga', 'umur'])) {
                $type = 'number';
            }

            $html .= <<<HTML
            <div class="form-group mb-3">
                <label for="{$column}">{$label}</label>
                <input wire:model="form.{$column}" type="{$type}" class="form-control" id="{$column}">
                @error('form.{$column}')
                    <small class="text-danger">{{ \$message }}</small>
                @enderror
            </div>

            HTML;
        }

        return trim($html);
    }

    // fungsi untuk generate field pada livewire form component
    private function generateFields(array $columnList, string $table): string
    {
        $result = '';

        foreach ($columnList as $column) {
            // Ambil tipe kolom dari schema
            $dbType = Schema::getColumnType($table, $column);

            // Peta tipe kolom database → tipe PHP
            $typeMap = [
                'string' => 'string',
                'text' => 'string',
                'char' => 'string',
                'date' => 'string',
                'datetime' => 'string',
                'integer' => 'int',
                'bigint' => 'int',
                'smallint' => 'int',
                'boolean' => 'bool',
                'float' => 'float',
                'decimal' => 'float',
                'double' => 'float',
            ];

            // Gunakan string jika tidak dikenali
            $phpType = $typeMap[$dbType] ?? 'string';

            // Tambahkan ke hasil
            $result .= "    public {$phpType} \${$column} = '';\n";
        }

        return trim($result);
    }

    private function generateRules(array $columnList): string
    {
        // TODO: buat default validation menjadi lebih bagus
        $lines = [];

        foreach ($columnList as $column) {
            $lines[] = "            '{$column}' => 'required',";
        }

        // Gabungkan tiap baris jadi satu string
        return implode("\n", $lines);
    }

    private function generateMessages(array $columnList): string
    {
        $messages = [];

        foreach ($columnList as $column) {
            // Ubah nama kolom jadi label manusiawi
            $label = Str::title(str_replace('_', ' ', $column));

            // Tambahkan pesan required
            $messages[] = "            '{$column}.required' => '{$label} wajib diisi.',";
        }

        return implode("\n", $messages);
    }

    private function generateAssignments(array $columnList, string $varName): string
    {
        $lines = [];

        foreach ($columnList as $column) {
            $lines[] = "        \$this->{$column} = \$this->{$varName}->{$column};";
        }

        return implode("\n", $lines);
    }

    private function getColumnListing(string $name): array
    {
        // Nama tabel diasumsikan bentuk jamak dari nama model
        $table = Str::snake(Str::singular($name));

        // Ambil semua kolom dari tabel
        $columns = Schema::getColumnListing($table);

        // Hapus kolom yang tidak diinginkan
        $fieldToDelete = [
            'id',
            'created_at',
            'updated_at',
            'deleted_at',
            'email_verified_at',
            'remember_token',
            'password',
        ];

        return array_values(array_diff($columns, $fieldToDelete));
    }

    public function handle()
    {
        $name = $this->argument('name'); // contoh: user
        $filesystem = new Filesystem;

        // Nama class (UserTable)
        $class = Str::studly(Str::singular($name));

        // Path stub
        $componentStubPath = base_path('stubs/livewire-table.stub');
        $viewStubPath = base_path('stubs/livewire-table.view.stub');
        $formStubPath = base_path('stubs/livewire-table.form.stub');

        // Path output
        $formPath = app_path("Livewire/Forms/{$class}Form.php");
        $componentPath = app_path("Livewire/Table/{$class}Table.php");
        $viewPath = resource_path('views/livewire/table/'.Str::kebab($class).'-table.blade.php');

        // Data dinamis
        $model = Str::studly(Str::singular($name));
        $varName = Str::camel($model);
        $view = 'livewire.table.'.Str::kebab($class).'-table';

        $columnList = $this->getColumnListing($name);

        $table = $this->generateTable($columnList, $varName);
        $form = $this->generateForm($columnList);

        $fields = $this->generateFields($columnList, Str::singular($name));
        $rules = $this->generateRules($columnList);
        $messages = $this->generateMessages($columnList);

        $assignments = $this->generateAssignments($columnList, $varName);

        // ===== Generate Form Component ======
        $formStub = $filesystem->get($formStubPath);

        $formContent = str_replace(
            ['[class]', '[varName]', '[fields]', '[rules]', '[messages]', '[assignments]'],
            [$class, $varName, $fields, $rules, $messages, $assignments],
            $formStub
        );

        $filesystem->ensureDirectoryExists(dirname($formPath));
        $filesystem->put($formPath, $formContent);

        $this->info("✅ Livewire form created: {$formPath}");

        // ===== Generate Component =====
        $componentStub = $filesystem->get($componentStubPath);

        $componentContent = str_replace(
            ['[class]', '[view]', '[model]', '[varName]'],
            [$class, $view, $model, $varName],
            $componentStub
        );

        $componentContent = str_replace('[columnList]', "['".implode("', '", $columnList)."']", $componentContent);

        $filesystem->ensureDirectoryExists(dirname($componentPath));
        $filesystem->put($componentPath, $componentContent);

        $this->info("✅ Livewire component created: {$componentPath}");

        // ===== Generate View =====
        $viewStub = $filesystem->get($viewStubPath);

        $viewContent = str_replace(
            ['[model]', '[varName]', '[table]', '[form]'],
            [$model, $varName, $table, $form],
            $viewStub
        );

        $filesystem->ensureDirectoryExists(dirname($viewPath));

        $filesystem->put($viewPath, $viewContent);
        $this->info("🪶 Livewire view created: {$viewPath}");

        // if (! $filesystem->exists($viewPath)) {
        //     $filesystem->put($viewPath, $viewContent);
        //     $this->info("🪶 Livewire view created: {$viewPath}");
        // } else {
        //     $this->warn("⚠️ View already exists: {$viewPath}");
        // }

        $this->info('🎉 Done!');
    }
}
