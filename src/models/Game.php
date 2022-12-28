<?php

class Game
{
    private $id;
    private $name;
    private $filename;
    private $ranks;

    public function __construct(int $id, string $name, string $filename,array $ranks)
    {
        $this->id = $id;
        $this->name = $name;
        $this->filename = $filename;
        $this->ranks = $ranks;
    }

    public function getRanks(): array
    {
        return $this->ranks;
    }

    public function setRanks(array $ranks)
    {
        $this->ranks = $ranks;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename)
    {
        $this->filename = $filename;
    }


}