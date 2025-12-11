<?php

namespace App\Enums;

enum StatusPembayaran: string
{
    case LUNAS = 'Lunas';
    case BELUM = 'Belum';
    case KURANG = 'Kurang';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): ?string
    {
        return match ($this) {
            self::LUNAS => 'success',     // hijau
            self::BELUM => 'danger',      // merah
            self::KURANG => 'warning',    // kuning
            default => 'secondary'
        };
    }

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public static function getOptions(): array
    {
        return array_map(
            fn ($case) => $case->value,
            self::cases()
        );
    }
}
