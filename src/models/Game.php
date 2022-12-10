<?php

class Game
{
    private $name;
    private $filename;


    public function __construct(string $name, string $filename)
    {
        $this->name = $name;
        $this->filename = $filename;
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