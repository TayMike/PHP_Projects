<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Plantacao
{
    public static function cadastrar($idAlimento, $idFazendeiro, $dataPlantacao) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO plantacao(idAlimento, idFazendeiro, dataPlantacao) VALUES (?, ?, ?)");
            $stmt->execute([$idAlimento, $idFazendeiro, $dataPlantacao]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deletar($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM plantacao WHERE id = ?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function editar($id, $idAlimento, $idFazendeiro, $dataPlantacao) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE plantacao SET idAlimento = :v1, idFazendeiro = :v2, dataPlantacao = :v3 WHERE id = :v4");
            $stmt->execute([
                "v1" => $idAlimento,
                "v2" => $idFazendeiro,
                "v3" => $dataPlantacao,
                "v4" => $id
                
            ]);

            $plantacaoEdit = self::listar($id);
            if($stmt->rowCount() > 0){
                return $plantacaoEdit;
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
            $stmt = $conexao->prepare("SELECT * FROM plantacao WHERE id = ?");
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
            $stmt = $conexao->prepare("SELECT * FROM plantacao ORDER BY id");
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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM plantacao WHERE id = ?");
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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM plantacao");
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deletarFazendeiro($idFazendeiro){
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM plantacao WHERE idFazendeiro = ?");
            $stmt->execute([$idFazendeiro]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deletarAlimento($idAlimento){
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM plantacao WHERE idAlimento = ?");
            $stmt->execute([$idAlimento]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }


}
