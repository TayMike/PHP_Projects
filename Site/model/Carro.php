<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Carro
{
    public static function add($nome, $marca, $ano, $idPessoa)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO carros(nome, marca, ano, idPessoa) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $marca, $ano, $idPessoa]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    
    public static function exists($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM carros WHERE id=?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function getAll()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM carros ORDER BY id");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function getOne($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM carros WHERE id=?");
            $stmt->execute([$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function edit($id, $nome, $marca, $ano, $idPessoa)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE carros SET nome=?, marca=?, ano=?, idPessoa=? WHERE id=?");
            $stmt->execute([$nome, $marca, $ano, $idPessoa, $id]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function delete($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM carros WHERE id=?");
            $stmt->execute([$id]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function deleteFK($idPessoa)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM carros WHERE idPessoa=?");
            $stmt->execute([$idPessoa]);
            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function getNumber()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM carros");
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
