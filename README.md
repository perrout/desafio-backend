# Api Backend Test

# Dependências
- Docker Compose

## Estrutura de Diretórios
- /app: (Diretório da aplicação)
- docker-compose.yml (Arquivo do Docker compose para o ambiente)
- Dockerfile (Arquivo do Docker para configuração do PHP)
- Makefile (Arquivo com atalhos para facilicar o desenvolvimento)
- README.md

## Instalação
- Clonando o projeto
```
git clone https://github.com/perrout/desafio-backend
```
- Configurações - Docker
```
cd desafio-backend/
make build
make up
```
- Configurações - API
```
make setup
```
- Url de acesso
```
http://loacalhost
```

## Rotas

| Method | URI                                           | Nome                      | Ação                               | Descrição                                   |
|--------|-----------------------------------------------|---------------------------|------------------------------------|---------------------------------------------|


## Payload
- ####POST /transaction
```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```