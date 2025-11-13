-- Arquivo: database.sql
-- Descrição: Script para criação do banco de dados e tabelas do sistema MediCare.

-- --- CRIAÇÃO DO BANCO DE DADOS ---
CREATE DATABASE IF NOT EXISTS clinica CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados para usar
USE clinica;

-- --- TABELA DE USUÁRIOS (PARA AUTENTICAÇÃO) ---
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --- TABELA DE PACIENTES ---
CREATE TABLE IF NOT EXISTS pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    data_nascimento DATE NOT NULL,
    cpf VARCHAR(20) NOT NULL UNIQUE,
    telefone VARCHAR(25),
    email VARCHAR(255),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --- TABELA DE MÉDICOS ---
CREATE TABLE IF NOT EXISTS medicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_completo VARCHAR(255) NOT NULL,
    crm VARCHAR(50) NOT NULL UNIQUE,
    especialidade VARCHAR(100) NOT NULL,
    telefone VARCHAR(25),
    email VARCHAR(255),
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- --- TABELA DE CONSULTAS ---
CREATE TABLE IF NOT EXISTS consultas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_medico INT NOT NULL,
    id_paciente INT NOT NULL,
    inicio DATETIME NOT NULL,
    fim DATETIME NOT NULL,
    sala VARCHAR(50),
    motivo TEXT,
    status ENUM('agendada', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'agendada',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --- TABELA DE PAGAMENTOS ---
CREATE TABLE IF NOT EXISTS pagamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_consulta INT NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_pagamento DATE NOT NULL,
    forma_pagamento VARCHAR(100),
    status ENUM('pago', 'pendente', 'cancelado') DEFAULT 'pendente',
    
    FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --- TABELA DE RECEITAS ---
CREATE TABLE IF NOT EXISTS receitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_consulta INT NOT NULL,
    id_paciente INT NOT NULL,
    medicamento VARCHAR(255) NOT NULL,
    quantidade VARCHAR(100),
    posologia TEXT NOT NULL,
    data_emissao DATE NOT NULL,
    validade DATE NOT NULL,
    
    FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO usuarios (nome, email, senha) VALUES
('Ygor', 'ygor@medicare.com', '$2y$12$gsCL0mi2W4kCyd.j9TGX/uqThmhcerJDZiM49.oRfRt0f2erv7Hwa');

-- Médicos
INSERT INTO medicos (id, nome_completo, crm, telefone, especialidade, email, status) VALUES
(1, 'Dr. João da Silva Santos', 'CRM/SP 123456', '(11) 98765-4321', 'Cardiologia', 'joao.santos@medicare.com', 'ativo'),
(2, 'Dra. Ana Clara Lima', 'CRM/RJ 654321', '(21) 99876-5432', 'Dermatologia', 'ana.lima@medicare.com', 'ativo'),
(3, 'Dr. Carlos Alberto Rocha', 'CRM/MG 456789', '(31) 97654-3210', 'Neurologia', 'carlos.rocha@medicare.com', 'inativo');

-- Pacientes
INSERT INTO pacientes (id, nome_completo, data_nascimento, cpf, telefone, email) VALUES
(1, 'Maria Silva Santos', '1985-05-10', '123.456.789-00', '(11) 98765-4321', 'maria.santos@email.com'),
(2, 'João Pedro Costa', '2000-12-03', '987.654.321-11', '(21) 99876-5432', 'joao.costa@email.com'),
(3, 'Ana Beatriz Oliveira', '1992-01-25', '456.789.012-22', '(31) 97654-3210', 'ana.oliveira@email.com'),
(4, 'Lucas Martins Ferreira', '1995-07-18', '111.222.333-44', '(41) 91234-5678', 'lucas.ferreira@email.com'),
(5, 'Juliana Almeida Ribeiro', '1988-03-30', '555.666.777-88', '(51) 98877-6655', 'juliana.ribeiro@email.com');

-- Consultas
INSERT INTO consultas (id, id_medico, id_paciente, inicio, fim, status, sala, motivo) VALUES
(1, 1, 1, '2024-10-15 09:30:00', '2024-10-15 10:00:00', 'finalizada', 'Sala 1', 'Consulta de rotina'),
(2, 2, 2, '2024-10-15 10:30:00', '2024-10-15 11:00:00', 'finalizada', 'Sala 2', 'Acompanhamento dermatológico'),
(3, 1, 3, '2024-11-20 14:00:00', '2024-11-20 14:30:00', 'confirmada', 'Sala 1', 'Avaliação pré-operatória'),
(4, 2, 4, '2024-11-22 11:00:00', '2024-11-22 11:30:00', 'agendada', 'Sala 2', 'Primeira consulta'),
(5, 1, 5, '2024-11-25 16:00:00', '2024-11-25 16:30:00', 'cancelada', 'Sala 1', 'Retorno');

-- Pagamentos
INSERT INTO pagamentos (id, id_consulta, valor, data_pagamento, forma_pagamento, status) VALUES
(1, 1, 250.00, '2024-10-15', 'Cartão', 'pago'),
(2, 2, 300.00, '2024-10-15', 'PIX', 'pago'),
(3, 3, 250.00, '2024-11-20', 'Dinheiro', 'pendente');

-- Receitas
INSERT INTO receitas (id, id_consulta, id_paciente, medicamento, quantidade, posologia, data_emissao, validade) VALUES
(1, 1, 1, 'Losartana 50mg', '1 caixa', '1 comprimido ao dia por 30 dias', '2024-10-15', '2024-10-25'),
(2, 2, 2, 'Protetor Solar FPS 60', '1 frasco', 'Aplicar no rosto pela manhã', '2024-10-15', '2025-10-15');

SELECT * FROM usuarios;
