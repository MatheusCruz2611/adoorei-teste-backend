# Documentação do Projeto

## 1 - Execução do Projeto

Para executar o projeto, siga os seguintes passos:

- Execute o projeto com Docker usando um dos seguintes comandos:
  ```sh
  1 - docker build . ou  docker buildx build . ou docker builder build .
  2 docker-compose up -d

Após esses passos o ambiente poderá ser acessado através da url: **http://localhost:8000**

## 2 - Execução dos Testes

Para executar os testes, siga os seguintes passos:

- Execute os testes usando um dos seguintes comandos:
  ```sh
  1 - docker ps
  2 - docker exec -it <container_id> php artisan test

## 3 - Execução das Migrations

Para executar as migrations, siga os seguintes passos:

- Execute os testes usando um dos seguintes comandos:
  ```sh
  1 - docker ps
  2 - docker exec -it <container_id> php artisan migrate

## 4 - Execução das Seeders

Para executar as seeders, siga os seguintes passos:

- Execute os testes usando um dos seguintes comandos:
  ```sh
  1 - docker ps
  2 - docker exec -it <container_id> php artisan db:seed

## 5 - Coleção

Você pode utilizar a coleção do Postman localizada na pasta raiz do projeto, com o nome "adoorei.postman_collection".