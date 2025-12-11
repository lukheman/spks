<?php

namespace App\Enums;

enum Role: string
{
    case BENDAHARA_KELAS = 'Bendahara Kelas';
    case BENDAHARA_OSIS = 'Bendahara Osis';
    case PEMBINA_OSIS = 'Pembina Osis';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::BENDAHARA_KELAS => 'primary',
            self::BENDAHARA_OSIS => 'success',
            self::PEMBINA_OSIS => 'warning',
            default => 'secondary'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    /**
     * getOptions: role yang bisa dipilih untuk registrasi (jika perlu).
     * Misalnya pembina tidak bisa buat akun sendiri.
     */
    public static function getOptions(): array
    {
        return array_map(
            fn ($case) => $case->value,
            self::cases()
        );
    }

    /**
     * senders: role yang boleh melakukan transaksi/pencatatan.
     */
    public static function senders(): array
    {
        return [
            self::BENDAHARA_KELAS->value,
            self::BENDAHARA_OSIS->value,
        ];
    }
}
