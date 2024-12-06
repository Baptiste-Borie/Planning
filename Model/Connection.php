<?php
class Connection
{
    private MongoDB\Driver\Manager $manager;

    public function __construct()
    {
        try {
            $this->manager = new MongoDB\Driver\Manager('mongodb+srv://root:root@cluster0.aqghb.mongodb.net/');
        } catch (Exception $e) {
            die("Erreur de connexion à MongoDB : " . $e->getMessage());
        }
    }

    public function getManager(): MongoDB\Driver\Manager
    {
        return $this->manager;
    }
}
