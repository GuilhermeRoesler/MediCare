<?php
require_once __DIR__ . "/../Core/Conexao.php";
class Medico
{
    private $id;
    private $nomeCompleto;
    private $crm;
    private $telefone;
    private $especialidade; 
    private $email;
    private $status;
    private $criadoEm;

    public function __construct($nomeCompleto, $crm, $telefone, $especialidade, $email, $status)
    {
        $this->nomeCompleto = $nomeCompleto;
        $this->crm = $crm;
        $this->especialidade = $especialidade;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->status = $status;
    }

    public function buscarPorId($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "SELECT * FROM medicos WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function inserir()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "INSERT INTO medicos (nome_completo, crm, telefone, especialidade, email, status) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nomeCompleto, $this->crm, $this->telefone, $this->especialidade, $this->email, $this->status]);
        if ($comando->rowCount() > 0) {
            return "Médico inserido com sucesso.";
        } else {
            return "Erro ao inserir médico.";
        }
    }

    public function excluir($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $registro = $this->buscarPorId($id);
        if (!$registro) {
            throw new Exception("Médico com ID $id não encontrado.");
        }
        $sql = "DELETE FROM medicos WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);

    }
    public function listar()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $sql = "SELECT * FROM medicos ORDER BY nome_completo ASC";
        $comando = $conectar->query($sql);
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $registro = $this->buscarPorId($id);
        if (!$registro) {
            throw new Exception("Médico com ID $id não encontrado.");
        }
        $sql = "UPDATE medicos SET nome_completo=?, crm=?, telefone=?, especialidade=?, email=?, status=? WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nomeCompleto, $this->crm, $this->telefone, $this->especialidade, $this->email, $this->status, $id]);
    }
}