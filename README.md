
# API

Api para integração do blog

## Stack utilizada

**Back-end:** PHP 8.2, Laravel 10

## Documentação da API

### Requisições de teste

|Requisição          | Endpoint         | Parametros                                  | Detalhes                               |
| :----------------- | :--------------- | :------------------------------------------ | :------------------------------------- |
|`GET`               | `api/ping`       | nenhum                                      | Verifica se serviço está funcionando   |


### Requisições de usuário

|Requisição          | Endpoint         | Parametros                                              | Detalhes                               |
| :----------------- | :--------------- | :------------------------------------------------------ | :------------------------------------- |
|`GET`               | `api/users`      | nenhum                                                  | Retorna todos os usuários              |
|`GET`               | `api/users/{id}` | id:integer                                              | Retorna um usuário                     |
|`POST`              | `api/users`      | name:string, email:string, password:string              | Cadastra um novo usuário               |
|`POST`              | `api/login`      | email:string, password:string                           | Faz login com usuário existente        |
|`POST`              | `api/logout`     | nenhum                                                  | Faz logout                             |
|`POST`              | `api/me`         | nenhum                                                  | Retorna usuário logado                 |
|`POST`              | `api/refresh`    | nenhum                                                  | Gera um novo token para a sessão atual |
|`PUT`               | `api/users/{id}` | id:integer, name:string, email:string, password:string  | Atualiza usuário                       |
|`DELETE`            | `api/users/{id}` | id:integer                                              | Deleta um usuário                      |

### Requisições de posts

|Requisição          | Endpoint         | Parametros                                              | Detalhes                               |
| :----------------- | :--------------- | :------------------------------------------------------ | :------------------------------------- |
|`GET`               | `api/posts`      | nenhum                                                  | Retorna todos os posts cadastrados     |
|`GET`               | `api/posts/{id}` | id:integer                                              | Retorna somente um post                |
|`POST`              | `api/posts`      | title:string, content:text , tag_name:string            | Cadastra um novo post                  |
|`PUT`               | `api/posts/{id}` | title:string, content:text                              | Atualiza um post                       |
|`DELETE`            | `api/posts/{id}` | id:integer                                              | Deleta um post                         |

##

BaseUrl:
```bash
https://raspberry.prjblog-api.shop/
```
