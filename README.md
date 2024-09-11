

## Como rodar o projeto baixado
Instalar as dependências do PHP
```
composer install
```

Instalar as dependências do Node.js
```
npm install
```

Duplicar o arquivo ".env.example" e renomear para ".env"
Alterar no arquivo .env o nome da base de dados para "ic". Exemplo: DB_DATABASE=ic

Gerar a chave
```
php artisan key:generate
```

Executar as migration
```
php artisan migrate
```

Executar as seed
```
php artisan db:seed
```

Iniciar o projeto criado com Laravel
```
php artisan serve
```

Executar as bibliotecas Node.js
```
npm run dev
```

Acessar o conteúdo padrão do Laravel
```
http://127.0.0.1:8000/
```


```
