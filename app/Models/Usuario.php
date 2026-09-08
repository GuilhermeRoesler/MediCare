<?php
require_once __DIR__ . "/../Core/Conexao.php";

class Usuario {
    private $nome;
    private $email;
    private $senha;
    private $perfil;

    public function __construct($nome, $email, $senha, $perfil = 'recepcao') {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->perfil = in_array($perfil, ['admin', 'recepcao'], true) ? $perfil : 'recepcao';
    }

    public function cadastrar() {
        $conectar = Conexao::getConexao();
        $senhaHash = password_hash($this->senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
        $comando = $conectar->prepare($sql);
        $comando->execute([$this->nome, $this->email, $senhaHash, $this->perfil]);

        return $comando->rowCount() > 0;
    }

    public static function login($email, $senha) {
        $conectar = Conexao::getConexao();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $comando = $conectar->prepare($sql);
        $comando->execute([$email]);
        $usuario = $comando->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            if (!isset($usuario['perfil'])) {
                $usuario['perfil'] = 'admin';
            }
            return $usuario;
        }

        return false;
    }
}
