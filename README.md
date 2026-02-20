# Projeto Grupo SIX - Teste Backend 

Este projeto foi desenvolvido utilizando **Laravel 12**.

---

## ✅ Requisitos

- PHP 8.3+
- Composer
- MySQL ou compatível
- Extensões PHP necessárias para o Laravel

---

## 🚀 Instalação

Siga rigorosamente os passos abaixo para configurar o ambiente.

---

### 1️⃣ Clonar o repositório

```bash
git clone https://github.com/guiluizin/orders-api-test.git
cd orders-api-test
```

---

### 2️⃣ Realizar pull na branch desejada

```bash
git switch -c main origin/main
```

---

### 3️⃣ Instalar dependências do PHP

```bash
composer install
```

---

### 4️⃣ Configurar arquivo de ambiente

Copie o arquivo de exemplo:

```bash
cp .env.example .env
```

---

### 5️⃣ Gerar chave da aplicação

```bash
php artisan key:generate
```

---

### 6️⃣ Configurar banco de dados

Edite o arquivo `.env` e configure as variáveis:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

⚠️ Certifique-se de que o banco de dados já foi criado.

---

### 7️⃣ Rodar as migrations

```bash
php artisan migrate
```

---

### 8️⃣ Executar leitura da API

Execute o comando responsável por ler a API e alimentar o banco:

```bash
php artisan six:run
```

---

### 9️⃣ Processar filas (Queue)

Execute o worker da fila até que todos os itens sejam processados:

```bash
php artisan queue:work --stop-when-empty
```

---

### 🔟 Criar usuário do Painel

```bash
php artisan make:filament-user
```

Siga as instruções no terminal para criar o usuário.

---

## ▶️ Iniciar o servidor local

```bash
php artisan serve
```

Acesse:

```
http://127.0.0.1:8000
```

---

## 🧹 (Opcional) Limpar cache

Caso necessário:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## ✅ Finalização

Após concluir todos os passos acima, o sistema estará pronto para uso.