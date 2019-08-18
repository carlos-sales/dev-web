<?php

class Database
{
    private $ip;
    private $user;
    private $password;
    private $database;

    private $connection;
    private $transaction = false;

    private $query;
    private $error;

    function __construct()
    {
        $this->ip = '18.220.186.241';
        $this->user = 'avaliacao';
        $this->password = 'd+/dSr7EwV6u<Zz[';
        $this->database = 'avaliacao';
    }

    function __destruct()
    {
        $this->close();
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function connect()
    {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->ip};dbname={$this->database}",
                $this->user,
                $this->password,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_AUTOCOMMIT => 0
                )
            );
        } catch (PDOException $e) {
            return false;
        }

        return true;
    }

    public function close()
    {
        if ($this->connection) {
            $this->connection = false;
        }
    }

    public function createTransaction()
    {
        if (!$this->transaction && $this->connection) {
            $this->transaction = $this->connection->beginTransaction();
        }
        return $this->transaction;
    }

    public function commit()
    {
        if ($this->transaction) {
            $this->connection->commit();
            $this->transaction = false;
        }
    }

    public function rollback()
    {
        if ($this->transaction) {
            $this->connection->rollBack();
            $this->transaction = false;
        }
    }

    public function sqlQuery($SQL, $force_transaction = true)
    {
        $this->query = $SQL;

        if ($this->connection) {

            if ($force_transaction) {
                $this->rollback();
                $this->createTransaction();
            }

            if ($this->transaction) {
                try {
                    $query = $this->connection->query($this->query);
                    if ($query !== false) {
                        return $query;
                    } else {
                        $error = $this->connection->errorInfo();
                        $this->setError($error[0] . ' - ' . $error[2]);
                        $this->rollback();
                        $this->close();
                        return false;
                    }
                } catch (PDOException $e) {
                    $this->setError($e->getMessage());
                }
            }
        }

        return false;
    }

    public function sqlQueryArray($SQL, $force_transaction = true)
    {
        $this->createTransaction();

        $this->query = $SQL;

        $query = $this->sqlQuery($SQL, $force_transaction);

        if ($query) {
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }
}
