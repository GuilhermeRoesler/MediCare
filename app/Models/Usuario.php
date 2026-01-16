<?php
require_once __DIR__ . "/../Core/Conexao.php";

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha;

    public function __construct($nome, $email, $senha) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
    }

    public function cadastrar() {
        $conectar = Conexao::getConexao();
        
        // Criptografa a senha antes de salvar
        $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nome, $this->email, $senhaHash]);

        return $comando->rowCount() > 0;
    }

    public static function login($email, $senha) {
        $conectar = Conexao::getConexao();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$email]);
        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario; // Retorna os dados do usuário em caso de sucesso
        }

        return false; // Retorna falso em caso de falha
    }
}
?>