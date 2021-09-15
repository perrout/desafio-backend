# Api Backend Test
Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar **somente** ao fluxo de transferência entre dois usuários.

Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários. 

- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.

- Validar se o usuário tem saldo antes da transferência.

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia. 

- No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (http://o4d9z.mocklab.io/notify). 

- Este serviço deve ser RESTFul.

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

| Method | URI                               | Nome                      | Ação                                       | Descrição                                   |
|--------|-----------------------------------|---------------------------|--------------------------------------------|---------------------------------------------|
| POST   | /api/transaction                  | transaction               | Transaction\TransactionController@trasnfer | Realiza transferências entre carteiras      |


## Payload
- ####POST /transaction
```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```