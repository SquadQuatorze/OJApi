# OJApi
Criação de API que servirá a plataforma de estudos intuitiva com foco em desenvolvimento de carreiras


## Documentação da API

### Usuarios

#### Cria um usuário novo

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
| 200 | Cadastro realizado com sucesso | |
