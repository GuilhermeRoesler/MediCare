-- Criar banco
DROP DATABASE IF EXISTS clinica;
CREATE DATABASE clinica;
USE clinica;

-- Paciente
CREATE TABLE IF NOT EXISTS pacientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_completo VARCHAR(255) NOT NULL,
  data_nascimento DATE,
  cpf VARCHAR(14) UNIQUE,
  telefone VARCHAR(20),
  email VARCHAR(255)
);

-- Médico
CREATE TABLE IF NOT EXISTS medicos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome_completo VARCHAR(255) NOT NULL,
  crm VARCHAR(50) UNIQUE,
  telefone VARCHAR(20),
  especialidade VARCHAR(255),
  email VARCHAR(255),
  status BOOLEAN DEFAULT TRUE
);

-- Consulta
CREATE TABLE IF NOT EXISTS consultas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_paciente INT NOT NULL,
  id_medico INT NOT NULL,
  inicio DATETIME NOT NULL,
  fim DATETIME NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'agendada',
  sala VARCHAR(50),
  motivo TEXT,
  CHECK (fim > inicio),
  FOREIGN KEY (id_paciente) REFERENCES pacientes(id) ON DELETE CASCADE,
  FOREIGN KEY (id_medico) REFERENCES medicos(id) ON DELETE CASCADE
);

-- Pagamento
CREATE TABLE IF NOT EXISTS pagamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_consulta INT NOT NULL,
  valor DECIMAL(10,2) NOT NULL,
  data_pagamento date,
  forma_pagamento VARCHAR(50),
  status VARCHAR(20) NOT NULL DEFAULT 'pendente',
  FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE
);

-- Receita
CREATE TABLE IF NOT EXISTS receitas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_consulta INT NOT NULL,
  id_paciente INT NOT NULL,
  medicamento VARCHAR(50),
  quantidade INT,
  posologia VARCHAR(50),
  data_emissao DATE,
  validade DATE,
  FOREIGN KEY (id_consulta) REFERENCES consultas(id) ON DELETE CASCADE
);

-- Pacientes
INSERT INTO pacientes (nome_completo, data_nascimento, cpf, telefone, email) VALUES
('Maria Silva', '1990-05-15', '111.222.333-44', '51999990001', 'maria@example.com'),
('João Souza', '1985-10-20', '555.666.777-88', '51999990002', 'joao@example.com'),
('Ana Costa', '2000-03-10', '999.888.777-66', '51999990003', 'ana@example.com'),
('Pedro Alves', '1975-12-01', '123.456.789-00', '51999990004', 'pedro@example.com'),
('Laura Martins', '1998-07-22', '321.654.987-11', '51999990005', 'laura@example.com');

-- Médicos
INSERT INTO medicos (nome_completo, crm, telefone, email, status) VALUES
('Dr. Carlos Mendes', 'CRM12345', '51988880001', 'carlos@clinica.com', TRUE),
('Dra. Fernanda Lima', 'CRM67890', '51988880002', 'fernanda@clinica.com', TRUE),
('Dr. Roberto Souza', 'CRM54321', '51988880003', 'roberto@clinica.com', TRUE);

-- Consultas
INSERT INTO consultas (id_paciente, id_medico, inicio, fim, status, sala, motivo) VALUES
-- Dr. Carlos Mendes (id=1)
(1, 1, '2025-09-06 09:00:00', '2025-09-06 09:30:00', 'agendada', '101', 'Consulta de rotina'),
(2, 1, '2025-09-07 10:00:00', '2025-09-07 10:45:00', 'agendada', '102', 'Dor de cabeça'),
(3, 1, '2025-09-12 16:00:00', '2025-09-12 16:20:00', 'agendada', '104', 'Exame de sangue'),
(4, 1, '2025-09-01 08:30:00', '2025-09-01 09:10:00', 'concluída', '105', 'Consulta ortopédica'),
(5, 1, '2025-09-03 11:00:00', '2025-09-03 11:30:00', 'concluída', '106', 'Acompanhamento cardiológico'),
(1, 1, '2025-09-04 15:00:00', '2025-09-04 15:30:00', 'concluída', '107', 'Revisão de exames'),
(2, 1, '2025-09-05 09:00:00', '2025-09-05 09:40:00', 'agendada', '108', 'Avaliação geral'),


-- Dra. Fernanda Lima (id=2)
(3, 2, '2025-09-08 14:00:00', '2025-09-08 14:30:00', 'agendada', '201', 'Check-up geral'),
(4, 2, '2025-08-20 08:00:00', '2025-08-20 08:20:00', 'concluída', '202', 'Retorno pós cirurgia'),
(5, 2, '2025-09-02 09:30:00', '2025-09-02 10:00:00', 'concluída', '203', 'Consulta de rotina'),
(1, 2, '2025-09-03 10:00:00', '2025-09-03 10:20:00', 'concluída', '204', 'Dor nas costas'),
(2, 2, '2025-09-04 11:00:00', '2025-09-04 11:40:00', 'concluída', '205', 'Revisão ginecológica'),
(3, 2, '2025-09-05 16:00:00', '2025-09-05 16:20:00', 'agendada', '206', 'Acompanhamento pós-exame'),
(4, 2, '2025-09-06 17:00:00', '2025-09-06 17:30:00', 'agendada', '207', 'Exame clínico'),

-- Dr. Roberto Souza (id=3)
(5, 3, '2025-09-10 15:00:00', '2025-09-10 15:40:00', 'agendada', '301', 'Exame de rotina'),
(1, 3, '2025-09-02 11:00:00', '2025-09-02 11:30:00', 'concluída', '302', 'Consulta dermatológica'),
(2, 3, '2025-08-29 09:30:00', '2025-08-29 10:00:00', 'concluída', '303', 'Acompanhamento pressão');

-- Pagamentos
INSERT INTO pagamentos (id_consulta, valor, forma_pagamento, status) VALUES
(1, 150.00, 'Cartão de Crédito', 'pago'),
(2, 200.00, 'Dinheiro', 'pendente'),
(3, 180.00, 'Pix', 'pago'),
(4, 220.00, 'Cartão de Débito', 'pago'),
(5, 130.00, 'Dinheiro', 'pendente');

-- Receitas


-- View: consultas futuras
CREATE OR REPLACE VIEW vw_consultas_futuras AS
SELECT c.id, c.inicio AS inicio, c.fim AS fim, c.status, c.sala,
       p.nome_completo AS paciente,
       m.nome_completo AS medico,
       m.id AS id_medico
FROM consultas c
JOIN pacientes p ON p.id = c.id_paciente
JOIN medicos m ON m.id = c.id_medico
WHERE c.inicio >= NOW();

-- View: total de consultas por médico
CREATE OR REPLACE VIEW vw_total_consultas_por_medico AS
SELECT m.id AS id_medico, m.nome_completo,
       COUNT(c.id) AS total_consultas
FROM medicos m
LEFT JOIN consultas c ON c.id_medico = m.id
GROUP BY m.id, m.nome_completo
ORDER BY total_consultas DESC;

-- View: métricas de duração
CREATE OR REPLACE VIEW vw_metricas_duracao_por_medico AS
SELECT m.id, m.nome_completo,
       SUM(TIMESTAMPDIFF(MINUTE, c.inicio, c.fim)) AS minutos_totais,
       AVG(TIMESTAMPDIFF(MINUTE, c.inicio, c.fim)) AS minutos_medios
FROM medicos m
JOIN consultas c ON c.id_medico = m.id
GROUP BY m.id, m.nome_completo;

-- View: médicos com mais de 5 consultas nos últimos 30 dias
CREATE OR REPLACE VIEW vw_medicos_ativos_30d AS
SELECT m.id, m.nome_completo, COUNT(c.id) AS total
FROM medicos m
JOIN consultas c ON c.id_medico = m.id
WHERE c.inicio >= NOW() - INTERVAL 30 DAY
GROUP BY m.id, m.nome_completo
HAVING COUNT(c.id) > 5;

-- Testes
SELECT * FROM vw_consultas_futuras;
SELECT * FROM vw_total_consultas_por_medico;
SELECT * FROM vw_metricas_duracao_por_medico;
SELECT * FROM vw_medicos_ativos_30d;
select*from consultas;
select*from pacientes;
select*from medicos;
select*from receitas;