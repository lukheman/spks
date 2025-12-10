<div class="card shadow-sm border-0">
    <div class="card-body">

        <h5 class="card-title mb-2">Saldo Saat Ini</h5>

        <h2 class="fw-bold text-success">
            Rp {{ number_format($saldo, 0, ',', '.') }}
        </h2>

        <p class="text-muted mb-0" style="font-size: 14px;">
            Terakhir diperbarui: {{ $updated_at }}
        </p>

    </div>
</div>
