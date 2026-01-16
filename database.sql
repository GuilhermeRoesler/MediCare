-- Criação do Banco de Dados
CREATE DATABASE IF NOT EXISTS clinica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clinica;

-- --------------------------------------------------------

-- Tabela de Usuários (para Login)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Pacientes
CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Médicos
CREATE TABLE IF NOT EXISTS medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(100) NOT NULL,
    crm VARCHAR(20) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    especialidade VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Consultas
CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NOT NULL,
    id_paciente INT NOT NULL,
    inicio DATETIME NOT NULL,
    fim DATETIME NOT NULL,
    status ENUM('agendada', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'agendada',
    sala VARCHAR(20),
    motivo TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
);

-- Tabela de Pagamentos
CREATE TABLE IF NOT EXISTS pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_consulta INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_pagamento DATE NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL, -- Ex: pix, cartao, dinheiro
    status ENUM('pago', 'pendente', 'cancelado') DEFAULT 'pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE
);

-- Tabela de Receitas
CREATE TABLE IF NOT EXISTS receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_consulta INT NOT NULL,
    id_paciente INT NOT NULL,
    medicamento VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    posologia VARCHAR(255) NOT NULL,
    data_emissao DATE NOT NULL,
    validade DATE NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
);

-- --------------------------------------------------------
-- POPULAÇÃO INICIAL (MOCK DATA)
-- --------------------------------------------------------

-- 1. Usuário Admin
-- Senha do admin é: 123456
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@medicare.com', '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm');

-- 2. Médicos
INSERT INTO medicos (nome_completo, crm, telefone, especialidade, email, status) VALUES 
('Dr. Roberto Silva', 'CRM/SP 123456', '(11) 99988-7766', 'Cardiologia', 'roberto@medicare.com', 'ativo'),
('Dra. Ana Souza', 'CRM/SP 654321', '(11) 98877-6655', 'Pediatria', 'ana@medicare.com', 'ativo'),
('Dr. Carlos Mendes', 'CRM/SP 112233', '(11) 97766-5544', 'Ortopedia', 'carlos@medicare.com', 'ativo'),
('Dra. Fernanda Lima', 'CRM/SP 998877', '(11) 96655-4433', 'Dermatologia', 'fernanda@medicare.com', 'ativo'),
('Dr. João Pereira', 'CRM/SP 445566', '(11) 95544-3322', 'Clínico Geral', 'joao@medicare.com', 'inativo');

-- 3. Pacientes
INSERT INTO pacientes (nome_completo, data_nascimento, cpf, telefone, email, criado_em) VALUES 
('Maria Oliveira', '1985-04-12', '111.222.333-44', '(11) 91111-2222', 'maria@email.com', DATE_SUB(NOW(), INTERVAL 60 DAY)),
('José Santos', '1990-08-25', '222.333.444-55', '(11) 92222-3333', 'jose@email.com', DATE_SUB(NOW(), INTERVAL 45 DAY)),
('Pedro Alves', '2015-02-10', '333.444.555-66', '(11) 93333-4444', 'pai_pedro@email.com', DATE_SUB(NOW(), INTERVAL 30 DAY)),
('Lucia Ferreira', '1978-11-05', '444.555.666-77', '(11) 94444-5555', 'lucia@email.com', DATE_SUB(NOW(), INTERVAL 15 DAY)),
('Marcos Costa', '1995-06-30', '555.666.777-88', '(11) 95555-6666', 'marcos@email.com', DATE_SUB(NOW(), INTERVAL 5 DAY));

-- 4. Consultas (Histórico e Futuras para gerar gráficos)
-- Passadas (Finalizadas)
INSERT INTO consultas (id_medico, id_paciente, inicio, fim, status, sala, motivo) VALUES 
(1, 1, DATE_SUB(NOW(), INTERVAL 2 MONTH), DATE_ADD(DATE_SUB(NOW(), INTERVAL 2 MONTH), INTERVAL 1 HOUR), 'finalizada', '101', 'Check-up cardiológico'),
(2, 3, DATE_SUB(NOW(), INTERVAL 1 MONTH), DATE_ADD(DATE_SUB(NOW(), INTERVAL 1 MONTH), INTERVAL 30 MINUTE), 'finalizada', '102', 'Dor de garganta'),
(3, 2, DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 15 DAY), INTERVAL 45 MINUTE), 'finalizada', '103', 'Dor no joelho'),
(1, 4, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 5 DAY), INTERVAL 1 HOUR), 'finalizada', '101', 'Retorno exames');

-- Futuras (Agendadas/Confirmadas)
INSERT INTO consultas (id_medico, id_paciente, inicio, fim, status, sala, motivo) VALUES 
(4, 5, DATE_ADD(NOW(), INTERVAL 1 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 1 DAY), INTERVAL 30 MINUTE), 'confirmada', '104', 'Consulta dermatológica'),
(1, 2, DATE_ADD(NOW(), INTERVAL 3 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 3 DAY), INTERVAL 1 HOUR), 'agendada', '101', 'Avaliação de rotina'),
(2, 3, DATE_ADD(NOW(), INTERVAL 5 DAY), DATE_ADD(DATE_ADD(NOW(), INTERVAL 5 DAY), INTERVAL 30 MINUTE), 'agendada', '102', 'Vacinação');

-- 5. Pagamentos
INSERT INTO pagamentos (id_consulta, valor, data_pagamento, forma_pagamento, status) VALUES 
(1, 350.00, DATE_SUB(NOW(), INTERVAL 2 MONTH), 'cartao', 'pago'),
(2, 200.00, DATE_SUB(NOW(), INTERVAL 1 MONTH), 'pix', 'pago'),
(3, 300.00, DATE_SUB(NOW(), INTERVAL 15 DAY), 'dinheiro', 'pago'),
(4, 350.00, DATE_SUB(NOW(), INTERVAL 5 DAY), 'cartao', 'pendente');

-- 6. Receitas
INSERT INTO receitas (id_consulta, id_paciente, medicamento, quantidade, posologia, data_emissao, validade) VALUES 
(2, 3, 'Amoxicilina 250mg', 1, '5ml a cada 8 horas por 7 dias', DATE_SUB(NOW(), INTERVAL 1 MONTH), DATE_ADD(DATE_SUB(NOW(), INTERVAL 1 MONTH), INTERVAL 10 DAY)),
(3, 2, 'Ibuprofeno 600mg', 1, '1 comprimido a cada 12h se houver dor', DATE_SUB(NOW(), INTERVAL 15 DAY), DATE_ADD(DATE_SUB(NOW(), INTERVAL 15 DAY), INTERVAL 30 DAY));