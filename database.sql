-- Exclui as tabelas se elas já existirem para evitar conflitos
DROP TABLE IF EXISTS `receitas`;
DROP TABLE IF EXISTS `pagamentos`;
DROP TABLE IF EXISTS `consultas`;
DROP TABLE IF EXISTS `pacientes`;
DROP TABLE IF EXISTS `medicos`;
DROP TABLE IF EXISTS `usuarios`;

-- Tabela de Usuários do Sistema
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Pacientes
CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(255) NOT NULL,
  `data_nascimento` date NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Médicos
CREATE TABLE `medicos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_completo` varchar(255) NOT NULL,
  `crm` varchar(20) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `especialidade` varchar(100) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') NOT NULL DEFAULT 'ativo',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `crm` (`crm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Consultas
CREATE TABLE `consultas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_medico` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `inicio` datetime NOT NULL,
  `fim` datetime NOT NULL,
  `status` enum('agendada','confirmada','cancelada','finalizada') NOT NULL,
  `sala` varchar(50) DEFAULT NULL,
  `motivo` text DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `id_medico` (`id_medico`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `consultas_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id`),
  CONSTRAINT `consultas_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Pagamentos
CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_consulta` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data_pagamento` date NOT NULL,
  `forma_pagamento` varchar(50) NOT NULL,
  `status` enum('pago','pendente','vencido') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_consulta` (`id_consulta`),
  CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Receitas
CREATE TABLE `receitas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_consulta` int(11) NOT NULL,
  `id_paciente` int(11) NOT NULL,
  `medicamento` varchar(255) NOT NULL,
  `quantidade` varchar(100) NOT NULL,
  `posologia` text NOT NULL,
  `data_emissao` date NOT NULL,
  `validade` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_consulta` (`id_consulta`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `receitas_ibfk_1` FOREIGN KEY (`id_consulta`) REFERENCES `consultas` (`id`),
  CONSTRAINT `receitas_ibfk_2` FOREIGN KEY (`id_paciente`) REFERENCES `pacientes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserindo dados de exemplo
-- Usuário Padrão (senha: senha123)
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'Ygor', 'ygor@medicare.com', '$2y$10$XQ.E9.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3.eZ3u');

-- Médicos
INSERT INTO `medicos` (`id`, `nome_completo`, `crm`, `telefone`, `especialidade`, `email`, `status`) VALUES
(1, 'Dr. João da Silva Santos', 'CRM/SP 123456', '(11) 98765-4321', 'Cardiologia', 'joao.santos@medicare.com', 'ativo'),
(2, 'Dra. Ana Clara Lima', 'CRM/RJ 654321', '(21) 99876-5432', 'Dermatologia', 'ana.lima@medicare.com', 'ativo'),
(3, 'Dr. Carlos Alberto Rocha', 'CRM/MG 456789', '(31) 97654-3210', 'Neurologia', 'carlos.rocha@medicare.com', 'inativo');

-- Pacientes
INSERT INTO `pacientes` (`id`, `nome_completo`, `data_nascimento`, `cpf`, `telefone`, `email`) VALUES
(1, 'Maria Silva Santos', '1985-05-10', '123.456.789-00', '(11) 98765-4321', 'maria.santos@email.com'),
(2, 'João Pedro Costa', '2000-12-03', '987.654.321-11', '(21) 99876-5432', 'joao.costa@email.com'),
(3, 'Ana Beatriz Oliveira', '1992-01-25', '456.789.012-22', '(31) 97654-3210', 'ana.oliveira@email.com'),
(4, 'Lucas Martins Ferreira', '1995-07-18', '111.222.333-44', '(41) 91234-5678', 'lucas.ferreira@email.com'),
(5, 'Juliana Almeida Ribeiro', '1988-03-30', '555.666.777-88', '(51) 98877-6655', 'juliana.ribeiro@email.com');

-- Consultas
INSERT INTO `consultas` (`id`, `id_medico`, `id_paciente`, `inicio`, `fim`, `status`, `sala`, `motivo`) VALUES
(1, 1, 1, '2024-10-15 09:30:00', '2024-10-15 10:00:00', 'finalizada', 'Sala 1', 'Consulta de rotina'),
(2, 2, 2, '2024-10-15 10:30:00', '2024-10-15 11:00:00', 'finalizada', 'Sala 2', 'Acompanhamento dermatológico'),
(3, 1, 3, '2024-11-20 14:00:00', '2024-11-20 14:30:00', 'confirmada', 'Sala 1', 'Avaliação pré-operatória'),
(4, 2, 4, '2024-11-22 11:00:00', '2024-11-22 11:30:00', 'agendada', 'Sala 2', 'Primeira consulta'),
(5, 1, 5, '2024-11-25 16:00:00', '2024-11-25 16:30:00', 'cancelada', 'Sala 1', 'Retorno');

-- Pagamentos
INSERT INTO `pagamentos` (`id`, `id_consulta`, `valor`, `data_pagamento`, `forma_pagamento`, `status`) VALUES
(1, 1, 250.00, '2024-10-15', 'Cartão', 'pago'),
(2, 2, 300.00, '2024-10-15', 'PIX', 'pago'),
(3, 3, 250.00, '2024-11-20', 'Dinheiro', 'pendente');

-- Receitas
INSERT INTO `receitas` (`id`, `id_consulta`, `id_paciente`, `medicamento`, `quantidade`, `posologia`, `data_emissao`, `validade`) VALUES
(1, 1, 1, 'Losartana 50mg', '1 caixa', '1 comprimido ao dia por 30 dias', '2024-10-15', '2025-01-15'),
(2, 2, 2, 'Protetor Solar FPS 60', '1 frasco', 'Aplicar no rosto pela manhã', '2024-10-15', '2025-10-15');