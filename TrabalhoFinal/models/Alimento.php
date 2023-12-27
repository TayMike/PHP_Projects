<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Alimento
{
    public static function cadastrar($nome, $dataColheita) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO alimento(nome, dataColheita) VALUES (?, ?)");
            $stmt->execute([$nome, $dataColheita]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deletar($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM alimento WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function editar($id, $nome, $dataColheita) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE alimento SET nome = :v1, dataColheita = :v2 WHERE id = :v3");
            $stmt->execute([
                "v1" => $nome,
                "v2" => $dataColheita,
                "v3" => $id
                
            ]);

            $alimentoEdit = self::listar($id);
            if($stmt->rowCount() > 0){
                return $alimentoEdit;
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
            $stmt = $conexao->prepare("SELECT * FROM alimento WHERE id = ?");
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
            $stmt = $conexao->prepare("SELECT * FROM alimento ORDER BY id");
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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM alimento WHERE id = ?");
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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM alimento");
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
