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
    quantidade INT,
    posologia TEXT NOT NULL,
    data_emissao DATE NOT NULL,
    validade DATE NOT NULL,
    
    FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE
) ENGINE=InnoDB;