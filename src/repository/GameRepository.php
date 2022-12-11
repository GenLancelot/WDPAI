<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/Game.php';

class GameRepository extends Repository
{
    public function getGame(string $name)
    {
        $stat = $this->database->connect()->prepare('
            SELECT * FROM public."games" u WHERE u.name  = :name;
        ');
        $stat->bindParam('name', $name, PDO::PARAM_STR);
        $stat->execute();

        $game = $stat->fetch(PDO::FETCH_ASSOC);

        if($game == false){
            return null;
        }

        return new Game(
            $game['name'],
            $game['filename']
        );
    }

    public function addGame(Game $game){
        $stat = $this->database->connect()->prepare('
            INSERT INTO public.games(name, filename) VALUES (?,?)
        ');


        $stat->execute([
            $game->getName(),
            $game->getFilename()
        ]);
    }

    public function getGames(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM games;
        ');
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($games as $game) {
            $result[] = new Game(
                $game['name'],
                $game['filename']
            );
        }
        return $result;
    }

    public function getGameByTitle(string $search)
    {
        $search = '%'.strtolower($search).'%';

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM games WHERE lower(name) LIKE :search');
        $stmt->bindParam("search", $search, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}