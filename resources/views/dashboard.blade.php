@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div id="app">
    <h1>Dashboard</h1>
    <div id="user-info"></div>
    <button id="logoutBtn" class="btn btn-danger">Sair</button>
</div>
@endsection

@section('scripts')
<script>
    async function fetchUserInfo() {
        const token = localStorage.getItem('token');
        if(!token) {
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch('/api/user', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if(response.status === 401) {
                localStorage.removeItem('token');
                window.location.href = '/login';
                return;
            }

            const data = await response.json();

            document.getElementById('user-info').textContent = 
                `Bem vindo, ${data.name} (${data.email})`;

        } catch (error) {
            console.error('Erro ao buscar dados do usuário:', error);
        }
    }

    document.getElementById('logoutBtn').addEventListener('click', () => {
        localStorage.removeItem('token');
        window.location.href = '/login';
    });

    fetchUserInfo();
</script>
@endsection
