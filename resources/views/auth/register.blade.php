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
                    <form method="POST" action="{{ route('users') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome:</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha:</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary py-2">
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