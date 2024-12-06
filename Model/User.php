<?php
class User
{
    private int $id;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private bool $admin;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
    public function getAdmin(): bool
    {
        return $this->admin;
    }

    // Setters
    public function setId($id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail($email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password): static
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstName($firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName($lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setAdmin($admin): static
    {
        $this->admin = $admin;
        return $this;
    }

    public function hydrate(array $data): void
    {
        foreach ($data as $key => $donnee) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($donnee);
            }
        }
    }
}
