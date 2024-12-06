<?php
class Connection
{
    private PDO $db;
    public function __construct()
    {
        try {
            new MongoDB\Driver\Manager('mongodb+srv://root:root@cluster0.aqghb.mongodb.net/');
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
    public function getDb(): PDO
    {
        return $this->db;
    }
}
