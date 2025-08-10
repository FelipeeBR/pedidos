@extends('layouts.app')

@section('title', 'Criar conta')

@section('content')
<div class="container">
    <div class="row d-flex align-items-center justify-content-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0 py-4">
                    <h4 class="card-title text-center mb-0">Criar conta</h4>
                </div>
                <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome:</label>
                            <input id="name" type="text" class="form-control" name="name"  required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input id="email" type="email" class="form-control" name="email"  required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha:</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm-password" class="form-label">Confirmar Senha:</label>
                            <input id="confirm-password" type="password" class="form-control" name="confirm-password" required>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="button" id="btn-register" class="btn btn-primary py-2">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Criar conta
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="text-decoration-none">Entrar na minha conta</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.getElementById('btn-register').addEventListener('click', async function () {
            
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirmPassword = document.getElementById('confirm-password').value.trim();

            if(!email || !password || !confirmPassword) {
                alert('Preencha todos os campos.');
                return;
            }

            if(password !== confirmPassword) {
                alert('As senhas não são identicas.');
                return;
            }

            try {
                const response = await fetch('/api/v1/users', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name, email, password }),
                });
                const data = await response.json();

                if(data.status) {
                    alert(data.message);
                    window.location.href = '/login';
                } else {
                    let errorMessages = "";
                    for(let field in data.errors) {
                        data.errors[field].forEach(error => {
                            errorMessages += `- ${error}\n`;
                        });
                    }
                    alert(errorMessages);
                }
            } catch (error) {
                alert('Erro na comunicação com o servidor');
            }
        });
    </script>
@endsection