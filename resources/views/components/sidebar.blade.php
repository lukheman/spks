@php
    use App\Enums\Role;
    $user = auth()->user();
    $role = $user->role;
@endphp

<div id="sidebar">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="">JUMSER</a>
                </div>
                <!-- theme toggle, biarin aja -->
            </div>
        </div>

<div class="sidebar-menu">
    <ul class="menu">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-md">
                <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : asset('./assets/compiled/jpg/2.jpg') }}">
            </div>
            <p class="font-bold ms-3 mb-0">{{ $user->name }} - {{ $user->role}}</p>
        </div>
        <hr>

        <x-nav-link icon="bi-person-circle"
            href="{{ route('profile')}}"
            :active="request()->routeIs('profile')">
            Profil
        </x-nav-link>

        <li class="sidebar-title">Navigasi Utama</li>

        <x-nav-link icon="bi-speedometer2"
            href="{{ route('dashboard')}}"
            :active="request()->routeIs('dashboard')">
            Beranda
        </x-nav-link>

        @if ($role === Role::BENDAHARA_KELAS)
            <x-nav-link icon="bi-calendar-week"
                href="{{ route('kas.mingguan.detail')}}"
                :active="request()->routeIs('kas.mingguan.detail')">
                Kas Mingguan
            </x-nav-link>
        @endif

        @if ($role === Role::PEMBINA_OSIS)

            <x-nav-link icon="bi-people"
                href="{{ route('user-table')}}"
                :active="request()->routeIs('user-table')">
                Pengguna
            </x-nav-link>

            <x-nav-link icon="bi-building"
                href="{{ route('siswa-table')}}"
                :active="request()->routeIs('siswa-table')">
                Siswa
            </x-nav-link>

            <x-nav-link icon="bi-building"
                href="{{ route('saldo')}}"
                :active="request()->routeIs('saldo')">
                    Saldo
            </x-nav-link>



        @endif

        @if ($role === Role::BENDAHARA_OSIS)
            <x-nav-link icon="bi-building"
                href="{{ route('kelas-table')}}"
                :active="request()->routeIs('kelas-table')">
                Kelas
            </x-nav-link>

            <x-nav-link icon="bi-arrow-up-circle"
                href="{{ route('pemasukan-table')}}"
                :active="request()->routeIs('pemasukan-table')">
                Pemasukan
            </x-nav-link>

            <x-nav-link icon="bi-arrow-down-circle"
                href="{{ route('pengeluaran-table')}}"
                :active="request()->routeIs('pengeluaran-table')">
                Pengeluaran
            </x-nav-link>

        <li class="sidebar-title">Laporan</li>

            <x-nav-link icon="bi-building"
                href="{{ route('laporan-pemasukan')}}"
                :active="request()->routeIs('laporan-pemasukan')">
                Laporan Pemasukan
            </x-nav-link>

            <x-nav-link icon="bi-building"
                href="{{ route('laporan-pengeluaran')}}"
                :active="request()->routeIs('laporan-pengeluaran')">
                Laporan Pengeluaran
            </x-nav-link>
        @endif

        <li class="sidebar-title">Akun</li>

        <x-nav-link icon="bi-box-arrow-right"
            href="{{ route('logout')}}">
            Keluar
        </x-nav-link>
    </ul>
</div>
    </div>
</div>
