
# API

Api para integração do blog

## Stack utilizada

**Back-end:** PHP 8.2, Laravel 10

## Documentação da API

### Requisições de teste

|Requisição          | Endpoint         | Parametros                                  | Detalhes                               |
| :----------------- | :--------------- | :------------------------------------------ | :------------------------------------- |
|`GET`               | `api/ping`       | nenhum                                      | Verifica se serviço está funcionando   |
|`GET`               | `api/users`      | nenhum                                      | Retorna usuários cadastrados           |

### Requisições de usuário

|Requisição          | Endpoint         | Parametros                                              | Detalhes                               |
| :----------------- | :--------------- | :------------------------------------------------------ | :------------------------------------- |
|`POST`              | `api/users`      | name:string, email:string, password:string              | Cadastra um novo usuário               |
|`POST`              | `api/login`      | email:string, password:string                           | Faz login com usuário existente        |
|`POST`              | `api/logout`     | nenhum                                                  | Faz logout                             |
|`POST`              | `api/me`         | nenhum                                                  | Retorna usuário logado                 |
|`POST`              | `api/refresh`    | nenhum                                                  | Gera um novo token para a sessão atual |
|`PUT`               | `api/users/{id}` | id:integer, name:string, email:string, password:string  | Atualiza usuário                       |
|`DELETE`            | `api/users/{id}` | id:integer                                              | Deleta um usuário                      |

##

BaseUrl:
```bash
https://raspberry.prjblog-api.shop/
```
