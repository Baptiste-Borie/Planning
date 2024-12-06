<?php

class UserManager
{
    private PDO $db;
    private String $table;
    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->table = "users";
    }
    public function create(User $user): void
    {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $req = $this->db->prepare("INSERT INTO $this->table(password, email, firstName, lastName, address, postalCode, city, admin) VALUES(:password, :email, :firstname, :lastname, :address, :postalCode, :city, :admin)");
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':password', $hashedPassword);
        $req->bindValue(':firstname', $user->getFirstName());
        $req->bindValue(':lastname', $user->getLastName());
        $req->bindValue(':admin', 0);
        $req->execute();
    }

    public function findAll(): array
    {
        $users = [];
        $req = $this->db->query("SELECT * FROM users ORDER BY id");
        while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new User($donnees);
        }
        return $users;
    }
    public function findOne(int $id): User
    {
        $req = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        if ($donnees) {
            return new User($donnees);
        } else {
            throw new Exception("User not found");
        }
    }

    public function update(User $user): void
    {
        $hashedPassword = password_hash($user->getPassword(), PASSWORD_BCRYPT);

        $req = $this->db->prepare("UPDATE users SET 
                email = :email,
                lastName = :lastName,
                firstName = :firstName,
                address = :address,
                postalCode = :postalCode,
                city = :city,
                password = :password,
                admin = :admin
                WHERE id = :id
            ");

        $req->bindValue(':password', $hashedPassword);
        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':firstName', $user->getFirstName());
        $req->bindValue(':lastName', $user->getLastName());
        $req->bindValue(':admin', $user->getAdmin(), PDO::PARAM_BOOL);
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);

        $req->execute();
    }

    public function updateNoPassword(User $user)
    {

        $req = $this->db->prepare("UPDATE users SET 
                    email = :email,
                    lastName = :lastName,
                    firstName = :firstName,
                    address = :address,
                    postalCode = :postalCode,
                    city = :city,
                    admin = :admin
                    WHERE id = :id
                ");

        $req->bindValue(':email', $user->getEmail());
        $req->bindValue(':firstName', $user->getFirstName());
        $req->bindValue(':lastName', $user->getLastName());
        $req->bindValue(':admin', $user->getAdmin(), PDO::PARAM_BOOL);
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);

        $req->execute();
    }



    public function delete(User $user): void
    {
        $req = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $req->bindValue(':id', $user->getId(), PDO::PARAM_INT);
        $req->execute();
    }

    public function findByEmail(string $email): ?User
    {
        $req = $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->execute();

        $donnees = $req->fetch(PDO::FETCH_ASSOC);

        if ($donnees) {
            return new User($donnees);
        } else {
            return null; // Retourne null si aucun utilisateur n'est trouvé
        }
    }
}
