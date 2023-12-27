<?php

require_once(__DIR__ . "/../config/Conexao.php");
require_once(__DIR__ . "/../config/utils.php");
require_once(__DIR__ . "/../models/Usuario.php");


class Session {
    public static function exists($sessionId) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM sessao where sessaoId = ? ");
            $stmt->execute([$sessionId]);

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo $e->getMessage();
            die;
        }
    }
    public static function isLoggedIn($sessionId) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare('SELECT (sessaoId) FROM sessao WHERE sessaoId = ?');
            $stmt->execute([$sessionId]);
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
    public static function isUserLoggedIn($userId) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare('SELECT (userId) FROM sessao WHERE userId = ?');
            $stmt->execute([$userId]);
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

    public static function logout($sessionId) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM sessao where sessaoId = ? ");
            $stmt->execute([$sessionId]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function createSession($userId) {
        try {
            do {
                $sessionId = bin2hex(random_bytes(10));
            } while (Session::exists($sessionId));

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO sessao(sessaoId, userID) Values (?, ?) ");
            $stmt->execute([$sessionId, $userId]);

            $linhasAlteradas = $stmt->rowCount();
            return $linhasAlteradas;
    
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function listar($id) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM sessao WHERE sessaoId = ?");
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

    public static function getUser($sessionId) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT (userid) FROM sessao WHERE sessaoId = ? ");
            $stmt->execute([$sessionId]);
            $linhas_alteradas = $stmt->rowCount();

            if($linhas_alteradas > 0) {
                $UsuarioId = $stmt->fetchAll()[0]["userId"];
                $Usuario = Usuario::listar($UsuarioId);
                return $Usuario;
            }
            else {
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
    
}

?>