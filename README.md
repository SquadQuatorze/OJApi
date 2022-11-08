# OJApi
Criação de API que servirá a plataforma de estudos intuitiva com foco em desenvolvimento de carreiras


## Documentação da API

### 🔗 Link API

https://geraldoalves.dev/OJ

### Usuarios

#### Cria um novo usuário

#### Resquest

```http
  POST /usuarios
```

| Parâmetro   | Tipo de Dados      | Descrição                           |
| :---------- | :--------- | :---------------------------------- |

Request Body

##### application/json

```javascript
{
  "email": "email@email.com",
  "password": "abcd1234",
  "nome": "Usuário"
}
```

##### application/x-www-form-url-encoded

email = **string**  
password = **string**  
nome = **string**

#### Response

| code   | Descrição      | Tipo retorno                           |
| :---------- | :--------- | :---------------------------------- |
| 200 | Cadastro realizado com sucesso | text/html |
| 200 | Email já cadastrado | text/html |

#### Recupera usuários cadastrados

#### Resquest

```http
  GET /usuarios
```

| Parâmetro   | Tipo de Dados      | Descrição                           |
| :---------- | :--------- | :---------------------------------- |

#### Response

| code   | Descrição      | Tipo retorno                           |
| :---------- | :--------- | :---------------------------------- |
| 200 | Lista com todos os usuários cadastrados | JSON |
