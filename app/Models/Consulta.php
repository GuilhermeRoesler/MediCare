<?php
require_once __DIR__ . "/../Core/Conexao.php";
class Consulta {        
   private $id;
    private $idMedico;
    private $idPaciente;
    private $inicio;
    private $fim;
    private $status;
    private $sala;
    private $motivo;
    private $criadoEm;
    
    public function __construct($idMedico, $idPaciente, $inicio, $fim, $status, $sala, $motivo) {
        $this->idMedico = $idMedico;
        $this->idPaciente = $idPaciente;
        $this->inicio = $inicio;
        $this->fim = $fim;
        $this->status = $status;
        $this->sala = $sala;
        $this->motivo = $motivo;
    }
    public function marcar() {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "INSERT INTO consultas (id_medico, id_paciente, inicio, fim, status, sala, motivo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idMedico, $this->idPaciente, $this->inicio, $this->fim, $this->status, $this->sala, $this->motivo]);
    }
    public function cancelar($id) {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
        $registro = $this->buscarPorId($id);
        if (!$registro) {
            throw new Exception("Consulta com ID $id não encontrada.");
        }
        $sql = "DELETE FROM consultas WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);

    }
    public function buscarPorId($id) {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "SELECT * FROM consultas WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch(PDO::FETCH_ASSOC);
    }

    public function listar() {
         $conectar = Conexao::getConexao();
         if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }
         $sql = "SELECT 
                    c.id, 
                    p.nome_completo as paciente_nome, 
                    m.nome_completo as medico_nome, 
                    c.inicio, 
                    c.fim, 
                    c.status, 
                    c.sala, 
                    c.motivo 
                 FROM consultas c
                 JOIN pacientes p ON c.id_paciente = p.id
                 JOIN medicos m ON c.id_medico = m.id
                 ORDER BY c.inicio DESC";
         $comando = $conectar->query($sql);
         return $comando->fetchAll(PDO::FETCH_ASSOC);
     }

     public function atualizar($id) {
        $conectar = Conexao::getConexao();
        if (!$conectar) {
            throw new Exception("Não foi possível conectar ao banco de dados.");
        }

        $sql = "UPDATE consultas SET id_medico=?, id_paciente=?, inicio=?, fim=?, status=?, sala=?, motivo=? WHERE id=?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->idMedico, $this->idPaciente, $this->inicio, $this->fim, $this->status, $this->sala, $this->motivo, $id]);

    }
}