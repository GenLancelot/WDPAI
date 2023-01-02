<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email)
    {
        $stat = $this->database->connect()->prepare('
            SELECT * FROM public."users" u WHERE u.email  = :email;
        ');
        $stat->bindParam('email', $email, PDO::PARAM_STR);
        $stat->execute();

        $user = $stat->fetch(PDO::FETCH_ASSOC);

        if($user == false){
            return null;
        }

        return new User(
            $user['email'],
            $user['password']
        );
    }

    public function addUser(User $user){
        $stat = $this->database->connect()->prepare('
            INSERT INTO public.users(email, password) VALUES (?,?)
        ');

        $stat->execute([
            $user->getEmail(),
            $user->getPassword()
        ]);
    }

    public function addUserPrioritizedGame(User $user, int $gameID){
        $stat = $this->database->connect()->prepare('
            SELECT * FROM public."users" u JOIN 
                public."user_details" ud ON u."ID_user" = ud."ID_user" 
                WHERE u.email  = :email;
        ');
        $email = $user->getEmail();
        $stat->bindParam('email', $email, PDO::PARAM_STR);
        $stat->execute();

        $result = $stat->fetch(PDO::FETCH_ASSOC);

        if($result == false){
            return null;
        }

        $stat = $this->database->connect()->prepare('
            UPDATE public."user_details" SET "ID_prioritizedGame" = :gameID WHERE "ID_user_details" = :userDetID;
        ');
        $stat->bindParam('gameID', $gameID, PDO::PARAM_INT);
        $stat->bindParam('userDetID', $result['ID_user_details'], PDO::PARAM_INT);
        $stat->execute();
    }

    public function getUserGames(User $user){
        $stat = $this->database->connect()->prepare('
            SELECT g."name", g."filename", gr."name" gamerank FROM public."users" u FULL JOIN  
                public."user_details" ud ON u."ID_user" = ud."ID_user"
                FULL JOIN  public."user_game_info" ugi ON ud."ID_user_details" = ugi."ID_user_details"
                FULL JOIN  public.games g ON ugi."ID_game" = g."ID_game"
                FULL JOIN  public."games_ranks" gr ON ugi."ID_rank" = gr."ID_rank"
                WHERE u.email  = :email;
        ');
        $email = $user->getEmail();
        $stat->bindParam('email', $email, PDO::PARAM_STR);
        $stat->execute();

        $result = $stat->fetchAll(PDO::FETCH_ASSOC);

        if($result == false){
            return null;
        }

        return $result;
    }

    public function getNotUserGames(User $user){
        $stat = $this->database->connect()->prepare('
            SELECT games."name" FROM public.games games 
            EXCEPT 
            SELECT g."name" FROM public."users" u FULL JOIN 
                public."user_details" ud ON u."ID_user" = ud."ID_user"
                FULL JOIN  public."user_game_info" ugi ON ud."ID_user_details" = ugi."ID_user_details"
                FULL JOIN  public.games g ON ugi."ID_game" = g."ID_game"
                FULL JOIN  public."games_ranks" gr ON ugi."ID_rank" = gr."ID_rank"
                WHERE u.email  = :email;
        ');
        $email = $user->getEmail();
        $stat->bindParam('email', $email, PDO::PARAM_STR);
        $stat->execute();

        $result = $stat->fetchAll(PDO::FETCH_ASSOC);

        if($result == false){
            return null;
        }

        return $result;
    }

    public function getGameID(string $gamename){
        $stmt = $this->database->connect()->prepare('
            SELECT g."ID_game" FROM public."games" g WHERE g.name = :gamename;');
        $stmt->bindParam('gamename', $gamename, PDO::PARAM_STR);
        $stmt->execute();
        $gameID = $stmt->fetch(PDO::FETCH_ASSOC);
        if($gameID == false){
            return null;
        }
        return $gameID;
    }

    public function getUserDetailsID(User $user){
        $stmt = $this->database->connect()->prepare('
            SELECT ud."ID_user_details" idud FROM public.users u 
                     JOIN public."user_details" ud ON u."ID_user" = ud."ID_user"
                         WHERE u.email = :email;');
        $email = $user->getEmail();
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $udiID = $stmt->fetch(PDO::FETCH_ASSOC);
        if($udiID == false){
            return null;
        }
        return $udiID;
    }

    public function getGameRankID(array $gameID, string $rank){
        $stmt = $this->database->connect()->prepare('
            SELECT gr."ID_rank" FROM public."games_ranks" gr WHERE gr."ID_game" = :gameID AND gr."name" = :rank;');
        $stmt->bindParam('gameID', $gameID['ID_game'], PDO::PARAM_INT);
        $stmt->bindParam('rank', $rank, PDO::PARAM_STR);
        $stmt->execute();
        $rankID = $stmt->fetch(PDO::FETCH_ASSOC);
        if($rankID == false){
            return null;
        }
        return $rankID;
    }

    public function addNewUserGame(User $user, string $gamename, string $rank = 'Unranked'){
        $udiID = $this->getUserDetailsID($user);
        if($udiID == null){
            return null;
        }

        $gameID = $this->getGameID($gamename);
        if($gameID == null){
            return null;
        }

        $rankID = $this->getGameRankID($gameID, $rank);
        if($rankID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."user_game_info"("ID_user_details", "ID_game", "ID_rank") VALUES(?, ?, ?);');
        $stmt->execute([
            $udiID['idud'],
            $gameID['ID_game'],
            $rankID['ID_rank']
        ]);
    }

    public function updateGameInfo(int $userDetailsID, string $gamename, string $rank){
        $gameID = $this->getGameID($gamename);
        if($gameID == null){
            return null;
        }

        $rankID = $this->getGameRankID($gameID, $rank);
        if($rankID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            UPDATE public."user_game_info" SET "ID_rank" = ? WHERE "ID_game" = ? AND "ID_user_details" = ?;');
        $stmt->execute([
            $rankID['ID_rank'],
            $gameID['ID_game'],
            $userDetailsID
        ]);
    }

    public function updateUserInfo(User $user, array $decoded){
        $userGames = $this->getUserGames($user);
        $udiID = $this->getUserDetailsID($user);
        if($udiID == null){
            return null;
        }

        foreach ($userGames as $game){
            if($game['gamerank'] == $decoded[$game['name']]){
                continue;
            }

            $this->updateGameInfo($udiID['idud'], $game['name'], $decoded[$game['name']]);
        }

        $stmt = $this->database->connect()->prepare('
            UPDATE public."user_details" SET description = ? WHERE "ID_user_details" = ?');
        $stmt->execute([
            $decoded['description'],
            $udiID['idud']
        ]);
    }

    public function updateUserBackground(User $user, string $filename){
        $udiID = $this->getUserDetailsID($user);
        if($udiID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            UPDATE public."user_details" SET "background_path" = ? WHERE "ID_user_details" = ?');
        $stmt->execute([
            $filename,
            $udiID['idud']
        ]);
    }

    public function updateUserIcon(User $user, string $filename){
        $udiID = $this->getUserDetailsID($user);
        if($udiID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            UPDATE public."user_details" SET "icon_path" = ? WHERE "ID_user_details" = ?');
        $stmt->execute([
            $filename,
            $udiID['idud']
        ]);

    }
}