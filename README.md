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

####
```

```
