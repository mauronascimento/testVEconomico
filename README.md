Teste Valor Econômico
==============

Fluxo para instalação da API.

### Pré Requisitos
1. SO utilizado -> Ubuntu 18.04;
2. Versão do Docker -> 18.09.0;
3. Versão do docker-compose -> 1.21.2;

### Instalação

1. Crie no ambiente local a estrutura '/home/projects' com `$ cd /home && mkdir projects1`;
2. Altere a permissão com usuário sudo para 755 com `chmod -R 755 /home/projects`;
3. Faça o clone deste projeto com `git clone https://github.com/mauronascimento/testVEconomico.git` dentro do diretório criado;
4. Entre na pasta '/home/projects/testVEconomico/Code' e rode o comando `docker-compose up`;

> **Observação:** A utilização de usuário sudo pode variar de acordo com as configurações da máquina local.

### Autenticação da aplicação

- A aplicação foi projetada para ter dois tipos de autenticação : WEB(basic Auth) e entre aplicações(tunel key e secret key).

- Ambos se encontram em 'Code/conf/conf.ini' .

#### Exemplo

![screen shot](https://raw.githubusercontent.com/mauronascimento/testVEconomico/master/Docs/images/example.png)

### Testando a aplicação

1. Abra o browser e visite a página `http://localhost:8080`;
2. Se autentique conforme citado acima;

### Exemplos de requisiçoes

- curl -X GET "http://localhost:8080/allnews" -H  "accept: application/xml"
- curl -X GET "http://localhost:8080/allnews" -H  "accept: application/json"
- curl -X GET "http://localhost:8080/amounthour" -H  "accept: application/xml"
- curl -X GET "http://localhost:8080/amounthour" -H  "accept: application/json"
- curl -X GET "http://localhost:8080/newkeyword/{keyword}" -H  "accept: application/xml"
- curl -X GET "http://localhost:8080/newkeyword/{keyword}" -H  "accept: application/json"
- curl -X GET "http://localhost:8080/fordate/{initialDate}/{endDate}" -H  "accept: application/xml"
- curl -X GET "http://localhost:8080/fordate/{initialDate}/{endDate}" -H  "accept: application/json"
