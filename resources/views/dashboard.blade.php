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
                                        <td>{{ $order['order_date'] }}</td>
                                        <td>{{ $order['delivery_date'] }}</td>
                                        <td>{{ $order['status'] }}</td>
                                        <td>
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
                    <input type="hidden" id="modalOrderId">
                    <p><strong>Cliente:</strong></p>
                    <input type="text" id="modalCustomerName" class="form-control">
                    <p><strong>Data do Pedido:</strong></p>
                    <input type="date" id="modalOrderDate" class="form-control">
                    <p><strong>Data de Entrega:</strong></p>
                    <input type="date" id="modalDeliveryDate" class="form-control">
                    <p><strong>Status:</strong></p>
                    <select name="status" id="modalStatus" class="form-control">
                        <option value="pending">Pendente</option>
                        <option value="delivered">Entregue</option>
                        <option value="cancelled">Cancelado</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveOrderBtn">Salvar</button>
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
            });

            document.getElementById('saveOrderBtn').addEventListener('click', async function () {
                const id = document.getElementById('modalOrderId').value;
                const customerName = document.getElementById('modalCustomerName').value;
                const orderDate = document.getElementById('modalOrderDate').value;
                const deliveryDate = document.getElementById('modalDeliveryDate').value;
                const status = document.getElementById('modalStatus').value;

                const payload = {
                    customer_name: customerName,
                    order_date: orderDate,
                    delivery_date: deliveryDate,
                    status: status
                };

                try {
                    const response = await fetch(`/api/v1/orders/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await response.json();

                    if (response.ok && data.status) {
                        alert('Pedido atualizado com sucesso!');
                        var modal = bootstrap.Modal.getInstance(document.getElementById('orderModal'));
                        modal.hide();
                        
                        location.reload();
                    } else {
                        alert('Erro ao atualizar pedido: ' + (data.message || 'Erro desconhecido'));
                    }
                } catch (error) {
                    alert('Erro na comunicação com o servidor');
                    console.error(error);
                }
            });
        });
    </script>
@endsection