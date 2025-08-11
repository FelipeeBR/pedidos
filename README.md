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


