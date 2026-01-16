<?php
require_once __DIR__ . "/../Core/Conexao.php";

class Paciente
{
    private $id;
    private $nomeCompleto;
    private $dataNascimento;
    private $cpf;
    private $telefone;
    private $email;
    private $criadoEm;


    public function __construct($nomeCompleto, $dataNascimento, $cpf, $telefone, $email)
    {
        $this->nomeCompleto = $nomeCompleto;
        $this->dataNascimento = $dataNascimento;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function buscarPorId($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "SELECT * FROM pacientes WHERE id=?";
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

        $sql = "INSERT INTO pacientes (nome_completo, data_nascimento, cpf, telefone, email) 
        VALUES (?, ?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nomeCompleto, $this->dataNascimento, $this->cpf, $this->telefone, $this->email]);
        if ($comando->rowCount() > 0) {
            return "Paciente inserido com sucesso.";
        } else {
            return "Erro ao inserir paciente.";
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
            throw new Exception("Paciente com ID $id não encontrado.");
        }
        $sql = "DELETE FROM pacientes WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);

    }
    public function listar()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            return []; //ou lançar exceção, se preferir
        }
        $sql = "SELECT * FROM pacientes";
        $comando = $conectar->query($sql);
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function atualizar($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "UPDATE pacientes SET nome_completo=?, data_nascimento=?, cpf=?, telefone=?, email=? WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nomeCompleto, $this->dataNascimento, $this->cpf, $this->telefone, $this->email, $id]);
    }


}
?>