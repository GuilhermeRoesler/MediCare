<?php

class Conexao
{
    private static $servidor;
    private static $banco;
    private static $usuario;
    private static $senha;

    /**
     * Carrega as variáveis do arquivo .env localizado na raiz do projeto
     */
    private static function carregarEnv()
    {
        // Se as variáveis já foram carregadas, não faz nada
        if (self::$servidor !== null) {
            return;
        }

        // Caminho para o arquivo .env (voltando de app/Core/ para a raiz)
        $caminhoEnv = __DIR__ . '/../../.env';

        if (file_exists($caminhoEnv)) {
            // Lê o arquivo para um array, ignorando novas linhas no final
            $linhas = file($caminhoEnv, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($linhas as $linha) {
                // Ignora comentários (#) e linhas que não são de configuração
                if (strpos(trim($linha), '#') === 0 || strpos($linha, '=') === false) {
                    continue;
                }

                // Separa a chave e o valor
                list($chave, $valor) = explode('=', $linha, 2);
                $chave = trim($chave);
                $valor = trim($valor);

                // Remove aspas simples ou duplas se existirem
                $valor = trim($valor, "\"'");

                // Atribui às propriedades estáticas
                switch ($chave) {
                    case 'DB_HOST':
                        self::$servidor = $valor;
                        break;
                    case 'DB_NAME':
                        self::$banco    = $valor;
                        break;
                    case 'DB_USER':
                        self::$usuario  = $valor;
                        break;
                    case 'DB_PASS':
                        self::$senha    = $valor;
                        break;
                }
            }
        } else {
            // Fallback: valores padrão caso o .env não exista (opcional)
            self::$servidor = "localhost";
            self::$banco    = "clinica";
            self::$usuario  = "root";
            self::$senha    = "";
        }
    }

    public static function getConexao()
    {
        // Carrega as configurações antes de tentar conectar
        self::carregarEnv();

        try {
            $conectar = new PDO("mysql:host=" . self::$servidor . ";dbname=" . self::$banco, self::$usuario, self::$senha);
            // Define o modo de erro para Exception, facilitando a depuração
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Garante charset UTF-8
            $conectar->exec("set names utf8mb4");

            return $conectar;
        } catch (PDOException $e) {
            // Em produção, evite mostrar $e->getMessage() diretamente ao usuário
            die("Erro crítico de conexão com o banco de dados. Verifique o arquivo .env.");
        }
    }
}
