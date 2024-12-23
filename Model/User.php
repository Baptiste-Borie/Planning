<?php
class User
{
    private ?string $id;
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
    public function getId(): ?string
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
    public function setId(?string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setAdmin(bool $admin): static
    {
        $this->admin = $admin;
        return $this;
    }

    public function hydrate(array $data): void
    {

        if (isset($data['_id'])) {
            $data['id'] = $data['_id'];
            unset($data['_id']);
        }

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}
