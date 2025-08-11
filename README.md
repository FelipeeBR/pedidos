# Desafio para desenvolvedor na Softsul Sistemas

## Nome: Felipe Mendes Neves

### Instruções:
Clonar o repositorio: 
```
https://github.com/FelipeeBR/pedidos.git
```
No wsl, crie um atalho para os comandos sail:

```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail' 
```

Utilize o comando para criar os conteiners em segundo plano:

```
sail up -d
```

E aplique as migrations com:

```
sail artisan migrate
```
## Acesse: http://localhost:80
## Testes na API:

#### POST /users
- Criar um novo usuario:
    - /api/v1/users
```
{
  "name": "Pedro",
  "email": "pedro@example.com",
  "password": "senha123"
}
```
- Fazer login de usuario:
    - /api/v1/login
```
{
  "email": "pedro@example.com",
  "password": "senha123"
}
```

Coloque o token no Bearer Token (caso queira testar no Insomnia / Postman)

### Rotas da API pedido (caso queira testar no Insomnia / Postman):

#### GET /orders
- Listar todos os pedidos
    - /api/v1/orders
```
{
    "version": "v1",
    "status": true,
    "orders": [
        {
            "id": 3,
            "customer_name": "Eduardo Ruan Manoel Novaes",
            "order_date": "2025-08-06",
            "delivery_date": "2025-08-09",
            "status": "pending",
            "user_id": 2,
            "created_at": "2025-08-11T00:24:21.000000Z",
            "updated_at": "2025-08-11T03:33:23.000000Z"
        },
    ]
}
```
- Listar pedido por id:
    - /api/v1/orders/3
```
{
    "version": "v1",
    "status": true,
    "order": {
        "id": 3,
        "customer_name": "Eduardo Ruan Manoel Novaes",
        "order_date": "2025-08-06",
        "delivery_date": "2025-08-09",
        "status": "pending",
        "user_id": 2,
        "created_at": "2025-08-11T00:24:21.000000Z",
        "updated_at": "2025-08-11T03:33:23.000000Z"
    }
}
```
#### POST /orders
- Criar novo pedido
    - /api/v1/orders/
```
{
    "version": "v1",
    "status": true,
    "order": {
        "customer_name": "Manoel Novaes",
        "order_date": "2025-08-01 20:34:00",
        "delivery_date": "2025-08-09 20:34:00",
        "status": "pending",
        "user_id": 2,
        "updated_at": "2025-08-11T04:10:51.000000Z",
        "created_at": "2025-08-11T04:10:51.000000Z",
        "id": 7
    },
    "message": "Pedido criado com sucesso"
}
```
#### PUT /orders
- Atualizar pedido
    - /api/v1/orders/7
```
{
    "version": "v1",
    "status": true,
    "order": {
        "id": 7,
        "customer_name": "Manoel Novaes",
        "order_date": "2025-08-01 20:34:00",
        "delivery_date": "2025-08-09 20:34:00",
        "status": "cancelled",
        "user_id": 2,
        "created_at": "2025-08-11T04:10:51.000000Z",
        "updated_at": "2025-08-11T04:13:31.000000Z"
    },
    "message": "Pedido atualizado com sucesso"
}
```

#### DELETE /orders
- Excluir pedido
    -/api/v1/orders/7
```
{
    "version": "v1",
    "status": true,
    "message": "Pedido excluido com sucesso"
}
```

### Imagens
![Captura de tela 2025-08-11 003939](https://github.com/user-attachments/assets/ac3cbb8a-df6d-4352-9d61-5ac290d24fe4)![Captura de tela 2025-08-11 004010](https://github.com/user-attachments/assets/a4b56660-797f-4339-906a-1302215dc4a2)


