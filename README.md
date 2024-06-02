
# API

Api para integração do blog

## Stack utilizada

**Back-end:** PHP 8.2, Laravel 10

## Documentação da API

|Type                | Route          | Parameters                                  |
| :----------------- | :------------- | :------------------------------------------ |
|`GET`               | `api/ping`     | none                                        |
|`POST`              | `api/register` | name:string, email:string, password:string  |
|`POST`              | `api/login`    | email:string, password:string               |
|`POST`              | `api/logout`   | none                                        |
|`POST`              | `api/me`       | none                                        |
|`POST`              | `api/refresh`  | none                                        |
|`POST`              | `api/users`    | none                                        |

##

BaseUrl:
```bash
https://raspberry.prjblog-api.shop/
```
