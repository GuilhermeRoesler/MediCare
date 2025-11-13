<?php
require_once __DIR__ . "/../Core/Conexao.php";
class Receita
{
    private $id;
    private $idConsulta;
    private $idPaciente;
    private $medicamento;
    private $quantidade;
    private $posologia;
    private $dataEmissao;
    private $validade;
    
    public function __construct($idConsulta, $idPaciente, $medicamento, $quantidade, $posologia, $dataEmissao, $validade)
    {
        $this->idConsulta = $idConsulta;
        $this->idPaciente = $idPaciente;
        $this->medicamento = $medicamento;
        $this->quantidade = $quantidade;
        $this->posologia = $posologia;
        $this->dataEmissao = $dataEmissao;
        $this->validade = $validade;
        
    }

    public function emitir()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "INSERT INTO receitas (id_consulta, id_paciente, medicamento, quantidade, posologia, data_emissao, validade) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idConsulta, $this->idPaciente, $this->medicamento, $this->quantidade, $this->posologia, $this->dataEmissao, $this->validade]);
        if ($comando->rowCount() > 0) {
            return "Receita emitida com sucesso.";
        } else {
            return "Erro ao emitir receita.";
        }
    }

    public function excluir($id)
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $sql = "DELETE FROM receitas WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);
        if ($comando->rowCount() > 0) {
            return "Receita excluída com sucesso.";
        } else {
            return "Erro ao excluir receita.";
        }
    }

    public function listar()
    {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "SELECT 
                    r.id,
                    r.id_consulta,
                    p.nome_completo as paciente_nome,
                    m.nome_completo as medico_nome,
                    r.medicamento,
                    r.data_emissao,
                    r.validade,
                    CASE 
                        WHEN r.validade < CURDATE() THEN 'Vencida'
                        ELSE 'Válida'
                    END as status
                FROM receitas r
                JOIN consultas c ON r.id_consulta = c.id
                JOIN pacientes p ON c.id_paciente = p.id
                JOIN medicos m ON c.id_medico = m.id
                ORDER BY r.data_emissao DESC";
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
        $sql = "SELECT * FROM receitas WHERE id=?";
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

        $sql = "UPDATE receitas SET id_consulta=?, id_paciente=?, medicamento =?, quantidade =?, posologia =?,  data_emissao=?, validade=? WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idConsulta, $this->idPaciente, $this->medicamento, $this->quantidade, $this->posologia, $this->dataEmissao, $this->validade, $id]);
        if ($comando->rowCount() > 0) {
            return "Receita atualizada com sucesso.";
        } else {
            return "Erro ao atualizar receita.";
        }
    }
}