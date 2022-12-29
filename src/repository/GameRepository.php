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

        $stat = $this->database->connect()->prepare('
            SELECT * FROM public."games_ranks" gr WHERE gr."ID_game"  = :name;
        ');
        $stat->bindParam('name', $game['ID_game'], PDO::PARAM_INT);
        $stat->execute();

        $ranks = $stat->fetchAll(PDO::FETCH_ASSOC);

        $ranksArr = array();

        foreach ($ranks as $rank){
            array_push($ranksArr, $rank['name']);
        }

        return new Game(
            $game['ID_game'],
            $game['name'],
            $game['filename'],
            $ranksArr
        );
    }

    public function addGame(Game $game){
        $stat = $this->database->connect()->prepare('
            INSERT INTO public.games(name, filename) VALUES (?,?)
        ');


        $stat->execute([
            $game->getId(),
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
            $stat = $this->database->connect()->prepare('
            SELECT * FROM public."games_ranks" gr WHERE gr."ID_game"  = :name;
        ');
            $stat->bindParam('name', $game['ID_game'], PDO::PARAM_INT);
            $stat->execute();

            $ranks = $stat->fetchAll(PDO::FETCH_ASSOC);

            $ranksArr = array();

            foreach ($ranks as $rank){
                array_push($ranksArr, $rank['name']);
            }

            $result[] = new Game(
                $game['ID_game'],
                $game['name'],
                $game['filename'],
                $ranksArr
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

        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $newGames = array();
        foreach ($games as $game) {
            $stat = $this->database->connect()->prepare('
            SELECT * FROM public."games_ranks" gr WHERE gr."ID_game"  = :name;');
            $stat->bindParam('name', $game['ID_game'], PDO::PARAM_INT);
            $stat->execute();

            $ranks = $stat->fetchAll(PDO::FETCH_ASSOC);
            array_push($game, $ranks);
            array_push($newGames, $game);
        }
        return $newGames;
    }

    public function getGameRanks(string $gameName)
    {
        $searchedGame = '%'.strtolower($gameName).'%';

        $stmt = $this->database->connect()->prepare('
        SELECT gr."name" FROM games 
        JOIN public."games_ranks" gr ON gr."ID_game" = games."ID_game"
                 WHERE lower(games.name) LIKE :searchedGame');
        $stmt->bindParam("searchedGame", $searchedGame, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}