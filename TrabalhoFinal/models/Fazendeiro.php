<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Fazendeiro
{
    public static function cadastrar($nome, $dataCadastro) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO fazendeiro(nome, dataCadastro) VALUES (?, ?)");
            $stmt->execute([$nome, $dataCadastro]);

            $linhasAlteradas = $stmt->rowCount();
            if($linhasAlteradas > 0){
               $idCadastro = $conexao->lastInsertId();
               $cadastro = self::listar($idCadastro);
               return $cadastro;
            }
            else{
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deletar($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM fazendeiro WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function editar($id, $nome, $dataCadastro) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE fazendeiro SET nome = :v1, dataCadastro = :v2 WHERE id = :v3");
            $stmt->execute([
                "v1" => $nome,
                "v2" => $dataCadastro,
                "v3" => $id
                
            ]);

            $fazendeiroEdit = self::listar($id);
            if($stmt->rowCount() > 0){
                return $fazendeiroEdit;
            }
            else{
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function listar($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM fazendeiro WHERE id = ?");
            $stmt->execute([$id]);
            $linhas_alteradas = $stmt->rowCount();

            if($linhas_alteradas > 0) {
                $resultado = $stmt->fetchAll()[0];
                return $resultado;
            } else {
                return null;
            }
            
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function listartodos() {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM fazendeiro ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function exists($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM fazendeiro WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function getNumber() {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM fazendeiro");
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
