
# 🚚 DeliveryFlow API

## 🌟 Overview
The **DeliveryFlow API** is a RESTful API built with Laravel, designed to manage and track deliveries within a sprint. It ensures that all tasks and features are completed and delivered on time by providing a robust backend for tracking progress and managing tasks.

## 🚀 Features
- 🗂️ **Sprint Management:** Create, update, and delete sprints.
- 📝 **Task Management:** Manage tasks within a sprint, including creation, updating, and deletion.
- 🔄 **Delivery Tracking:** Track the status and progress of deliveries within a sprint.
- 🔒 **User Authentication:** Secure access to the API with user authentication and authorization.
- 📄 **Documentation:** Includes basic setup and usage guidelines.

## 🛠️ Installation

### Prerequisites
- 🐘 Docker and Docker Compose installed

### Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/deliveryflow-api.git
   ```

2. **Navigate to the project directory:**
   ```bash
   cd deliveryflow-api
   ```

3. **Copy the `.env` file and set your environment variables:**
   ```bash
   cp .env.example .env
   ```
   Update your `.env` file with the appropriate database and other configurations.

4. **Build and start the Docker containers:**
   ```bash
   docker-compose up --build -d
   ```

5. **Run database migrations inside the Docker container:**
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Access the application:**
    - Open your browser and navigate to `http://localhost:8000`

## 🤝 Contributing
Contributions are welcome! Please fork this repository, make your changes, and submit a pull request.

## 📜 License
This project is licensed under the MIT License. See the `LICENSE` file for more details.

---

# 🚚 DeliveryFlow API

## 🌟 Visão Geral
A **DeliveryFlow API** é uma API RESTful construída com Laravel, projetada para gerenciar e rastrear entregas durante uma sprint. Ela ajuda a garantir que todas as tarefas e funcionalidades sejam concluídas e entregues no prazo, fornecendo um backend robusto para acompanhar o progresso e gerenciar as tarefas.

## 🚀 Funcionalidades
- 🗂️ **Gestão de Sprints:** Crie, atualize e exclua sprints.
- 📝 **Gestão de Tarefas:** Gerencie tarefas dentro de uma sprint, incluindo criação, atualização e exclusão.
- 🔄 **Rastreamento de Entregas:** Acompanhe o status e o progresso das entregas durante uma sprint.
- 🔒 **Autenticação de Usuário:** Acesso seguro à API com autenticação e autorização de usuários.
- 📄 **Documentação:** Inclui instruções básicas de configuração e uso.

## 🛠️ Instalação

### Pré-requisitos
- 🐘 Docker e Docker Compose instalados

### Passos

1. **Clone o repositório:**
   ```bash
   git clone https://github.com/gabrieltorresdev/deliveryflow-api.git
   ```

2. **Navegue até o diretório do projeto:**
   ```bash
   cd deliveryflow-api
   ```

3. **Copie o arquivo `.env` e defina suas variáveis de ambiente:**
   ```bash
   cd src && cp .env.example .env && cd ..
   ```
   Atualize o arquivo `.env` com as configurações de banco de dados e outras apropriadas.

4. **Construa e inicie os containers Docker:**
   ```bash
   make start
   ```
    *ou*
   ```bash
   docker compose up --build -d
   ```
5. **Execute as migrações do banco de dados dentro do container Docker:**
   ```bash
   make shell-app
   php artisan migrate
   ```
   *ou*
    ```bash
   docker compose exec app php artisan migrate
   ```

6. **Acesse a aplicação:**
    - Abra o seu navegador e vá para `http://localhost:8000`

## 📜 Licença
Este projeto é licenciado sob a Licença MIT. Consulte o arquivo `LICENSE` para mais detalhes.