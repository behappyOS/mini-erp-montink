# Mini ERP em PHP MVC

Este é um projeto completo de mini ERP para controle de produtos, pedidos e cupons utilizando PHP puro com arquitetura MVC, MySQL, Bootstrap e integração com APIs externas.

## Funcionalidades

- Cadastro de produtos e variações
- Controle de estoque por variação
- Carrinho de compras com sessão
- Integração com API ViaCEP (consulta CEP)
- Aplicação de cupons com validação de valor mínimo e data
- Finalização de pedidos com e-mail de confirmação (PHPMailer)
- Webhook para atualização de status ou cancelamento

## Requisitos

- PHP 8.0+
- MySQL 5.7+
- Composer
- Docker (opcional)

## Instalação

### Com Docker (recomendado)

```bash
git clone https://github.com/behappyOS/mini-erp-montink.git
cd mini-erp-php
docker-compose up -d
docker exec -it mini-erp-php bash
php database/migrate.php
