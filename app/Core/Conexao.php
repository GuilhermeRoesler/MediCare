<?php

class Conexao
{
    private static $servidor;
    private static $banco;
    private static $usuario;
    private static $senha;

    private static function carregarEnv()
    {
        if (self::$servidor !== null) {
            return;
        }

        $caminhoEnv = __DIR__ . '/../../.env';

        if (file_exists($caminhoEnv)) {
            $linhas = file($caminhoEnv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($linhas as $linha) {
                if (strpos(trim($linha), '#') === 0 || strpos($linha, '=') === false) {
                    continue;
                }

                list($chave, $valor) = explode('=', $linha, 2);
                $chave = trim($chave);
                $valor = trim($valor);
                $valor = trim($valor, "\"'");

                switch ($chave) {
                    case 'DB_HOST':
                        self::$servidor = $valor;
                        break;
                    case 'DB_NAME':
                        self::$banco = $valor;
                        break;
                    case 'DB_USER':
                        self::$usuario = $valor;
                        break;
                    case 'DB_PASS':
                        self::$senha = $valor;
                        break;
                }
            }
        }

        // Variáveis de ambiente (Docker / hospedagem) têm prioridade
        self::$servidor = getenv('DB_HOST') ?: (self::$servidor ?? 'localhost');
        self::$banco = getenv('DB_NAME') ?: (self::$banco ?? 'clinica');
        self::$usuario = getenv('DB_USER') ?: (self::$usuario ?? 'root');
        $envPass = getenv('DB_PASS');
        self::$senha = ($envPass !== false && $envPass !== '') ? $envPass : (self::$senha ?? '');
    }

    public static function getConexao()
    {
        self::carregarEnv();

        try {
            $conectar = new PDO(
                'mysql:host=' . self::$servidor . ';dbname=' . self::$banco . ';charset=utf8mb4',
                self::$usuario,
                self::$senha
            );
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conectar->exec('set names utf8mb4');

            return $conectar;
        } catch (PDOException $e) {
            die('Erro crítico de conexão com o banco de dados. Verifique o arquivo .env ou as variáveis de ambiente.');
        }
    }
}
