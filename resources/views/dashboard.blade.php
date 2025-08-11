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
            <div class="container">
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="container mt-3">   
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="container">
            <div class="text-end mt-5">
                <button class="btn btn-success btn-sm btn-view-order" 
                    data-bs-toggle="modal" 
                    data-bs-target="#orderModal"
                    data-id=""
                    data-customer=""
                    data-orderdate=""
                    data-deliverydate=""
                    data-status=""
                >
                    Novo Pedido
                </button>
            </div>
            <div class="col-12 mt-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Pedidos</h3>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome do Cliente</th>
                                    <th>Data do Pedido</th>
                                    <th>Data de Entrega</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr>
                                        <td>{{ $order['id'] }}</td>
                                        <td>{{ $order['customer_name'] }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order['order_date'])->timezone('America/Sao_Paulo')->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order['delivery_date'])->timezone('America/Sao_Paulo')->format('d/m/Y') }}</td>
                                        <td>
                                            @if ($order['status'] === 'pending')
                                                <span class="badge bg-warning">Pendente</span>
                                            @elseif ($order['status'] === 'delivered')
                                                <span class="badge bg-success">Entregue</span>
                                            @elseif ($order['status'] === 'cancelled')
                                                <span class="badge bg-danger">Cancelado</span>
                                            @endif
                                        </td>
                                        <td class="d-flex flex-row project-actions text-right">
                                            <div class="mx-1">
                                                <button 
                                                    class="btn btn-primary btn-sm btn-view-order" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#orderModal"
                                                    data-id="{{ $order['id'] }}"
                                                    data-customer="{{ $order['customer_name'] }}"
                                                    data-orderdate="{{ $order['order_date'] }}"
                                                    data-deliverydate="{{ $order['delivery_date'] }}"
                                                    data-status="{{ $order['status'] }}"
                                                >
                                                    Editar
                                                </button>
                                            </div>
                                            <div class="mx-1">
                                                <form action="{{ route('dashboard.orders.destroy', $order['id']) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este pedido?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-view-order">Excluir</button>
                                                </form>
                                            </div>
                                        </td>
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
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Detalhes do Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="orderUpdateForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="modalOrderId" name="order_id">
    
                        <p><strong>Cliente:</strong></p>
                        <input type="text" id="modalCustomerName" name="customer_name" class="form-control" required>
    
                        <p><strong>Data do Pedido:</strong></p>
                        <input type="date" id="modalOrderDate" name="order_date" class="form-control" required>
    
                        <p><strong>Data de Entrega:</strong></p>
                        <input type="date" id="modalDeliveryDate" name="delivery_date" class="form-control">
    
                        <p><strong>Status:</strong></p>
                        <select name="status" id="modalStatus" class="form-control">
                            @foreach(App\Http\Enums\OrderStatus::cases() as $status)
                                <option value="{{ $status->value }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var orderModal = document.getElementById('orderModal');

            orderModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;

                var id = button.getAttribute('data-id');
                var customer = button.getAttribute('data-customer');
                var orderDate = button.getAttribute('data-orderdate');
                var deliveryDate = button.getAttribute('data-deliverydate');
                var status = button.getAttribute('data-status');

                document.getElementById('modalOrderId').value = id;
                document.getElementById('modalCustomerName').value = customer;
                document.getElementById('modalOrderDate').value = orderDate;
                document.getElementById('modalDeliveryDate').value = deliveryDate;
                document.getElementById('modalStatus').value = status;

                var form = document.getElementById('orderUpdateForm');

                if(id) {
                    form.action = `/dashboard/orders/${id}`;
                    form.method = 'POST';

                    if(!form.querySelector('input[name="_method"]')) {
                        var methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);
                    }
                } else {
                    form.action = '/dashboard/orders';
                    form.method = 'POST';

                    var methodInput = form.querySelector('input[name="_method"]');
                    if(methodInput) methodInput.remove();
                }
            });
        });
    </script>
@endsection