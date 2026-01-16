# MediCare System - Sistema de Gerenciamento de Clínicas

O MediCare System é uma aplicação web completa para o gerenciamento de clínicas médicas, desenvolvida com foco em simplicidade, eficiência e segurança. A plataforma permite administrar pacientes, médicos, consultas, pagamentos e receitas de forma centralizada.

![MediCare System](images/dashboard.png)

## ✨ Funcionalidades Principais

- **Autenticação Segura**: Sistema de login e cadastro de usuários com senhas criptografadas.
- **Dashboard Interativo**: Painel de controle com estatísticas visuais, gráficos de desempenho (consultas, faturamento) e atalhos para ações rápidas.
- **Gerenciamento de Pacientes**: Cadastro, atualização, listagem e exclusão de pacientes (CRUD completo).
- **Gerenciamento de Médicos**: CRUD completo para médicos, incluindo informações como CRM, especialidade e status (ativo/inativo).
- **Agendamento de Consultas**: Marcação de novas consultas, com detalhes sobre paciente, médico, horário, sala e motivo.
- **Controle de Pagamentos**: Registro de pagamentos associados a consultas, com controle de status (pago, pendente, cancelado).
- **Emissão de Receitas**: Geração e gerenciamento de receitas médicas, com controle de validade.
- **Relatórios Gerenciais**: Visualização de dados consolidados sobre o desempenho da clínica e opção para exportar dados em formato CSV.
- **Busca e Ordenação**: Funcionalidades de busca e ordenação em tempo real em todas as tabelas de gerenciamento.

## 🚀 Tecnologias Utilizadas

Este projeto foi construído com uma arquitetura clássica de aplicação multi-página (MPA), utilizando tecnologias consolidadas e sem a necessidade de frameworks complexos.

- **Backend**: **PHP 8+** (Orientado a Objetos)
- **Frontend**: **HTML5**, **CSS3** e **JavaScript (Vanilla)**
- **Banco de Dados**: **MySQL** com acesso via PDO
- **Ícones**: **Font Awesome**
- **Gráficos**: **Chart.js**

## 🔧 Instalação e Configuração

Para executar o projeto localmente, siga os passos abaixo.

### Pré-requisitos

- Um ambiente de servidor web com suporte a PHP (XAMPP, WAMP, MAMP ou similar).
- Servidor de banco de dados MySQL.
- Um navegador web moderno.

### Passos

1.  **Clone o Repositório**

    ```bash
    git clone https://github.com/seu-usuario/medicare-system.git
    ```

    Ou faça o download dos arquivos e extraia-os.

2.  **Mova os Arquivos**
    Mova a pasta do projeto para o diretório raiz do seu servidor web (ex: `htdocs` no XAMPP).

3.  **Configure o Banco de Dados**

    - Inicie seu servidor MySQL.
    - Crie um novo banco de dados com o nome `clinica`.
    - Importe o arquivo `database.sql` (localizado na raiz do projeto) para criar as tabelas e inserir os dados iniciais.

4.  **Configure a Conexão**

    - Abra o arquivo `app/Core/Conexao.php`.
    - Atualize as variáveis estáticas com as suas credenciais do MySQL:
      ```php
      private static $servidor = "localhost";
      private static $banco    = "clinica";
      private static $usuario  = "seu_usuario_mysql";
      private static $senha    = "sua_senha_mysql";
      ```

5.  **Acesse a Aplicação**
    - Inicie seu servidor Apache.
    - Abra o navegador e acesse `http://localhost/nome-da-pasta-do-projeto/`.
    - Você será redirecionado para a página de autenticação.

## 📂 Estrutura de Arquivos

A estrutura do projeto é organizada para separar as responsabilidades:

```
/
├── app/
│   ├── Core/         # Conexão com o banco de dados.
│   ├── Http/
│   │   └── Controllers/ # Lógica de negócio e controle de requisições.
│   └── Models/       # Classes que representam as tabelas do banco.
│
├── public/
│   ├── css/          # Arquivos de estilo (CSS).
│   ├── js/           # Scripts do lado do cliente (JavaScript).
│   ├── partials/     # Componentes reutilizáveis (header, sidebar).
│   └── *.php         # Páginas visíveis ao usuário.
│
├── database.sql      # Script de criação do banco de dados.
└── README.md         # Este arquivo.
```

## 🤝 Contribuições

Contribuições são bem-vindas! Se você tiver sugestões para melhorar o projeto, sinta-se à vontade para criar um _fork_ e abrir um _pull request_.

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo `LICENSE` para mais detalhes.
