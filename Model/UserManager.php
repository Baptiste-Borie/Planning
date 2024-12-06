<?php

class UserManager
{
    private MongoDB\Driver\Manager $manager;
    private string $collection;

    public function __construct(MongoDB\Driver\Manager $manager, string $database = "Planning", string $collection = "users")
    {
        $this->manager = $manager;
        $this->collection = "$database.$collection"; // Nom complet de la collection
    }

    public function create(User $user): void
    {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $document = [
            'email' => $user->getEmail(),
            'password' => $hashedPassword,
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'admin' => true,
        ];

        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->insert($document);

        $this->manager->executeBulkWrite($this->collection, $bulk);
    }

    public function findAll(): array
    {
        $query = new MongoDB\Driver\Query([]);
        $cursor = $this->manager->executeQuery($this->collection, $query);

        $users = [];
        foreach ($cursor as $document) {
            $data = (array)$document;

            // Ajouter des valeurs par défaut si nécessaire
            $data['email'] = $data['email'] ?? '';
            $data['password'] = $data['password'] ?? '';
            $data['firstName'] = $data['firstName'] ?? '';
            $data['lastName'] = $data['lastName'] ?? '';
            $data['admin'] = $data['admin'] ?? false;

            $users[] = new User($data);
        }

        return $users;
    }

    public function findOne(string $id): ?User
    {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($id)];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery($this->collection, $query);
        $document = current($cursor->toArray());

        if ($document) {
            return new User((array)$document);
        } else {
            throw new Exception("User not found");
        }
    }

    public function update(User $user): void
    {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $filter = ['_id' => new MongoDB\BSON\ObjectId($user->getId())];
        $update = [
            '$set' => [
                'email' => $user->getEmail(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'password' => $hashedPassword,
                'admin' => $user->getAdmin(),
            ],
        ];

        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->update($filter, $update);

        $this->manager->executeBulkWrite($this->collection, $bulk);
    }

    public function delete(User $user): void
    {
        $filter = ['_id' => new MongoDB\BSON\ObjectId($user->getId())];

        $bulk = new MongoDB\Driver\BulkWrite();
        $bulk->delete($filter);

        $this->manager->executeBulkWrite($this->collection, $bulk);
    }

    public function findByEmail(string $email): ?User
    {
        $filter = ['email' => $email];
        $query = new MongoDB\Driver\Query($filter);
        $cursor = $this->manager->executeQuery($this->collection, $query);
        $document = current($cursor->toArray());

        return $document ? new User((array)$document) : null;
    }
}
