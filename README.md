
# API

Projeto de desenvolvimento de uma API para integração de um Blog.
Este projeto está sendo desenvolvido em conjunto com Paulo P. Junior para exercitar as habilidades de trabalho em grupo.
Obs.: O projeto está alocado em um raspberry pi com sistema operacional Ubuntu Server.

## Autores

- [@fernando-fix](https://www.github.com/fernando-fix) - Back End
- [@paulo-pacheco-junior](https://github.com/paulo-pacheco-junior) - Front End

## Stack utilizada

**Back-end:** PHP 8.2, Laravel 10
**Front-end:** ReactJS

## Repositórios

- [FRONT](https://github.com/Paulo-Pacheco-Junior/collab-prjblog-reactjs)
- [BACK](https://github.com/fernando-fix/collab-prjBlog)

## Documentação da API

### Requisições de teste

| Requisição | Endpoint            | Parâmetros                                                      | Detalhes                               |
| :--------- | :------------------ | :-------------------------------------------------------------- | :------------------------------------- |
|`GET`       | `api/ping`          | nenhum                                                          | Verifica se serviço está funcionando   |


### Requisições de usuário

| Requisição | Endpoint            | Parâmetros                                                      | Detalhes                               |
| :--------- | :------------------ | :-------------------------------------------------------------- | :------------------------------------- |
|`GET`       | `api/users`         | nenhum                                                          | Retorna todos os usuários              |
|`GET`       | `api/users/{id}`    | id:integer                                                      | Retorna um usuário                     |
|`POST`      | `api/users`         | name:string, email:string, password:string                      | Cadastra um novo usuário               |
|`POST`      | `api/login`         | email:string, password:string                                   | Faz login com usuário existente        |
|`POST`      | `api/logout`        | nenhum                                                          | Faz logout                             |
|`POST`      | `api/me`            | nenhum                                                          | Retorna usuário logado                 |
|`POST`      | `api/refresh`       | nenhum                                                          | Gera um novo token para a sessão atual |
|`PUT`       | `api/users/{id}`    | id:integer, name:string, email:string, password:string          | Atualiza usuário                       |
|`DELETE`    | `api/users/{id}`    | id:integer                                                      | Deleta um usuário                      |

### Requisições de posts

| Requisição | Endpoint            | Parâmetros                                                      | Detalhes                               |
| :--------- | :------------------ | :-------------------------------------------------------------- | :------------------------------------- |
|`GET`       | `api/posts`         | nenhum                                                          | Retorna todos os posts cadastrados     |
|`GET`       | `api/posts/?search` | search:string                                                   | Retorna posts por título ou autor      |
|`GET`       | `api/posts/?tag`    | tag:string                                                      | Retorna posts por nome da tag          |
|`GET`       | `api/posts/{id}`    | id:integer                                                      | Retorna somente um post                |
|`POST`      | `api/posts`         | user_id:integer, title:string, content:string, tags:array       | Cadastra um novo post                  |
|`PUT`       | `api/posts/{id}`    | title:string, content:string                                    | Atualiza um post                       |
|`DELETE`    | `api/posts/{id}`    | id:integer                                                      | Deleta um post                         |

### Requisições de comentários
| Requisição | Endpoint            | Parâmetros                                                      | Detalhes                               |
| :--------- | :------------------ | :-------------------------------------------------------------- | :------------------------------------- |
|`POST`      | `api/comments`      | user_id:integer, post_id:integer, content:string                | Cadastra um novo comentário            |
|`PUT`       | `api/comments/{id}` | id:integer, title:string, content:string                        | Atualiza um comentário                 |
|`DELETE`    | `api/comments/{id}` | id:integer                                                      | Deleta um comentário                   |

### Requisições de tags

| Requisição | Endpoint            | Parâmetros                                                      | Detalhes                               |
| :--------- | :------------------ | :-------------------------------------------------------------- | :------------------------------------- |
|`GET`       | `api/tags`          | nenhum                                                          | Retorna todos as tags cadastrados      |

##

BaseUrl:
```bash
https://raspberry.prjblog-api.shop/
```
