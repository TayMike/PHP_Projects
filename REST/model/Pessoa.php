<?php
require_once(__DIR__ . "/../config/Conexao.php");

class Pessoa
{
    public static function add($nome, $data)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("INSERT INTO pessoas(nome,dataNascimento) VALUES (?, ?)");
            $stmt->execute([$nome, $data]);

            return $stmt->rowCount();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function getAll()
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("SELECT * FROM pessoas ORDER BY id");
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
            $stmt = $conexao->prepare("SELECT * FROM pessoas WHERE id=?");
            $stmt->execute([$id]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function edit($id, $nome, $dataNascimento)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("UPDATE pessoas SET nome=?, dataNascimento=? WHERE id=?");
            $stmt->execute([$nome, $dataNascimento, $id]);
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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM pessoas WHERE id=?");
            $stmt->execute([$id]);

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    public static function delete($id)
    {
        try {
            $conexao = Conexao::getConexao();
            $stmt = $conexao->prepare("DELETE FROM pessoas WHERE id=?");
            $stmt->execute([$id]);

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
            $stmt = $conexao->prepare("SELECT COUNT(*) FROM pessoas");
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
