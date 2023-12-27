<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Usuario
{
    public static function cadastrar($userLogin, $senha) {
        try {
            $hash = password_hash($senha, PASSWORD_BCRYPT, ["cost"=> 11]);

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO usuario(userlogin, senha) VALUES (?, ?)");
            $stmt->execute([$userLogin, $hash]);

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

    public static function deletar($userLogin) {
        try {
            if(!Usuario::exists($userLogin)) {
                throw new Exception("Este usuário não existe!");
            }
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM usuario WHERE userlogin = ?");
            $stmt->execute([$userLogin]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function editar($oldUserLogin, $senha, $newUserLogin) {
        try {
            if(!Usuario::exists($oldUserLogin)) {
                throw new Exception("Este usuario não existe!");
            }
            if(Usuario::exists($newUserLogin)) {
                throw new Exception("Esse login de usuario já esta em uso!");
            }
            $hash = password_hash($senha, PASSWORD_BCRYPT, ["cost"=> 11]);

            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE usuario SET userLogin = :v1, senha = :v2 WHERE userLogin = :v3");
            $stmt->execute([
                "v1" => $newUserLogin,
                "v2" => $hash,
                "v3" => $oldUserLogin
                
            ]);

            $usuarioEdit = self::listar($newUserLogin);
            if($stmt->rowCount() > 0){
                return $usuarioEdit;
            }
            else{
                return null;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function listar($userLogin) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT id, userlogin FROM usuario WHERE userlogin = ?");
            $stmt->execute([$userLogin]);
            
            return $stmt->fetchAll();          
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function listartodos() {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT id, userlogin FROM usuario ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function exists($userLogin) {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT userlogin FROM usuario WHERE userlogin = ?");
            $stmt->execute([$userLogin]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
    
    public static function VerificarLogin($nome){
     
        try{
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT senha FROM usuario WHERE userlogin = ?");
            $stmt->execute([$nome]);
            
            return $stmt->FetchColumn();
        }catch(Exception $e){
            echo $e->getMessage();
            die;
        }
    }

    public static function getUserId($userLogin){
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT id FROM usuario WHERE userLogin = ?");
            $stmt->execute([$userLogin]);
            return $stmt->fetch();

        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

}