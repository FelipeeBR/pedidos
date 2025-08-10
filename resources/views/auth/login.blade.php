@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
    <div class="row d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="card-title text-center mb-0">Login</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input id="email" type="email" class="form-control" name="email" required autofocus>
                        <div id="email-error" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        <div id="password-error" class="invalid-feedback"></div>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="button" id="btn-login" class="btn btn-primary py-2">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="text-decoration-none">Crie uma conta</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('btn-login').addEventListener('click', async function () {
        document.getElementById('email-error').textContent = '';
        document.getElementById('password-error').textContent = '';

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if(!email || !password) {
            alert('Preencha e-mail e senha.');
            return;
        }

        try {
            const response = await fetch('/api/v1/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ email, password }),
            });

            const data = await response.json();

            if(response.ok && data.status) {
               
                localStorage.setItem('token', data.token);
                localStorage.setItem('user', JSON.stringify(data.user));

                window.location.href = '/dashboard';
            } else {
                alert(data.error || 'Falha no login');
            }
        } catch (error) {
            alert('Erro na comunicação com o servidor');
        }
    });
</script>
@endsection
