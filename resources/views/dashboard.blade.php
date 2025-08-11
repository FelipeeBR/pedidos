@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div>
        <nav class="navbar text-white bg-primary">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <span class="mb-0 h1">Pedidos</span>

                <div>
                    Bem-vindo, {{ auth()->user()->name }} ({{ auth()->user()->email }})
                    <form method="POST" action="{{ route('logout') }}" class="d-inline ms-3">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Sair</button>
                    </form>
                </div>
            </div>
        </nav>

        @if(session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Cliente</th>
                        <th>Data de Criação</th>
                        <th>Data de Entrega</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>{{ $order['id'] }}</td>
                            <td>{{ $order['customer_name'] }}</td>
                            <td>{{ $order['order_date'] }}</td>
                            <td>{{ $order['delivery_date'] }}</td>
                            <td>{{ $order['status'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhum pedido encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
