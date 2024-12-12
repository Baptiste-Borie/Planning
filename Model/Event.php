<?php

class Event
{
    private string $_id;
    private int $year;
    private string $user_id;
    private int $weekNumber;

    public function __construct(array $data = [])
    {
        $this->hydrate($data);
    }

    // Méthode hydrate
    private function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId(): string
    {
        return $this->_id;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getWeekNumber(): int
    {
        return $this->weekNumber;
    }

    // Setters
    public function setId(string $_id): void
    {
        $this->_id = $_id;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }

    public function setUserId(string $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setWeekNumber(int $weekNumber): void
    {
        $this->weekNumber = $weekNumber;
    }
}
