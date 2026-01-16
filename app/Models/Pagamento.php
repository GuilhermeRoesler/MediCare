<?php
require_once __DIR__ . "/../Core/Conexao.php";

class Pagamento
{
    private $id;
    private $idConsulta;
    private $valor;
    private $dataPagamento;
    private $formaPagamento;
    private $status;

    public function __construct($idConsulta, $valor, $dataPagamento, $formaPagamento, $status)
    {
        $this->idConsulta = $idConsulta;
        $this->valor = $valor;
        $this->dataPagamento = $dataPagamento;
        $this->formaPagamento = $formaPagamento;
        $this->status = $status;
    }

    public function registrar()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "INSERT INTO pagamentos (id_consulta, valor, data_pagamento, forma_pagamento, status) 
        VALUES (?, ?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idConsulta, $this->valor, $this->dataPagamento, $this->formaPagamento, $this->status]);
        if ($comando->rowCount() > 0) {
            return "Pagamento registrado com sucesso.";
        } else {
            return "Erro ao registrar pagamento.";
        }
    }

    public function excluir($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $sql = "DELETE FROM pagamentos WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);
        if ($comando->rowCount() > 0) {
            return "Pagamento excluído com sucesso.";
        } else {
            return "Erro ao excluir pagamento.";
        }
    }

    public function listar()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "SELECT 
                    pg.id,
                    pg.id_consulta,
                    p.nome_completo as paciente_nome,
                    m.nome_completo as medico_nome,
                    pg.valor,
                    pg.data_pagamento,
                    pg.forma_pagamento,
                    pg.status
                FROM pagamentos pg
                JOIN consultas c ON pg.id_consulta = c.id
                JOIN pacientes p ON c.id_paciente = p.id
                JOIN medicos m ON c.id_medico = m.id
                ORDER BY pg.data_pagamento DESC";
        $comando = $conectar->prepare($sql);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $sql = "SELECT * FROM pagamentos WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "UPDATE pagamentos SET id_consulta=?, valor=?, data_pagamento=?, forma_pagamento=?, status=? WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idConsulta, $this->valor, $this->dataPagamento, $this->formaPagamento, $this->status, $id]);
        if ($comando->rowCount() > 0) {
            return "Pagamento atualizado com sucesso.";
        } else {
            return "Erro ao atualizar pagamento.";
        }
    }
}