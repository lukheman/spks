<!-- Login Section -->
<section class="login-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-5">
                        <h2 class="text-center section-title">Login</h2>
                        <x-flash-message />
                        <form wire:submit="submit">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username atau Email</label>
                                <input wire:model="email" type="text" class="form-control" id="username" name="username" placeholder="Masukkan username atau email" required>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input wire:model="password" type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">Login</button>
                            </div>
                        </form>
                        <!-- <p class="text-center mt-3 mb-0"> -->
                        <!-- Belum punya akun? <a href="/register" class="text-success">Daftar sekarang</a> -->
                        <!-- </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
