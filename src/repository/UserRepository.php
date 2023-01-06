<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';

class UserRepository extends Repository
{
    public function getUser(string $email)
    {
        $stat = $this->database->connect()->prepare('
            SELECT u."email" email, u."password" password, ud."description" description, u."ID_user_type" idut FROM public."users" u 
                     FULL JOIN public."user_details" ud
                     ON u."ID_user" = ud."ID_user"
                     WHERE u.email  = :email;
        ');
        $stat->bindParam('email', $email, PDO::PARAM_STR);
        $stat->execute();

        $user = $stat->fetch(PDO::FETCH_ASSOC);

        if($user == false){
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['idut'] === 1 ? $user['description'] : 'admin'
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

    public function checkIfAdmin(string $email){
        $stmt = $this->database->connect()->prepare('
            SELECT ut."name" rolename FROM public."users" u 
            JOIN public."user_types" ut 
            ON ut."ID_user_type" = u."ID_user_type"
            WHERE u."email" = :email
        ');

        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result == false){
            return null;
        }
        return $result['rolename'] === 'admin';
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
            SELECT g."name", g."filename", gr."name" gamerank, gr."filename" gamerankfilename FROM public."users" u FULL JOIN  
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

        if($result == false || $result[0]['name'] == ''){
            return [];
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

        if($result == false || $result[0]['name'] == ''){
            return [];
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

    public function getUserId(string $email){
        $stmt = $this->database->connect()->prepare('
            SELECT u."ID_user" FROM public."users" u 
                WHERE u.email  = :email;
        ');
        $stmt->bindParam('email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $userID = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userID == false){
            return null;
        }
        return $userID["ID_user"];
    }

    public function addFriendshipStatus(User $user, bool $bAccept, string $email){
        $status = $bAccept ? 'Accepted' : 'Declined';

        $stmt = $this->database->connect()->prepare('
            SELECT fs."ID_friendship_status" id FROM public."friendship_status" fs 
                WHERE fs.name  = :name;
        ');
        $stmt->bindParam('name', $status, PDO::PARAM_STR);
        $stmt->execute();

        $friendshipStatusID = $stmt->fetch(PDO::FETCH_ASSOC);
        if($friendshipStatusID == false){
            return null;
        }
        $thisUserID = $this->getUserId($user->getEmail());
        if($thisUserID == null){
            return null;
        }

        $otherUserID = $this->getUserId($email);
        if($otherUserID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            INSERT INTO "friendships"("ID_user1", "ID_user2", "ID_status") VALUES(?,?,?)');
        $stmt->execute([
            $thisUserID,
            $otherUserID,
            $friendshipStatusID['id']
        ]);
    }

    public function getNextUserToShow(User $user){
        $userID = $this->getUserId($user->getEmail());
        if($userID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT u."email", ud."description", ud."icon_path" FROM public."users" u 
                     FULL JOIN public."user_details" ud
                     ON u."ID_user" = ud."ID_user"
                     WHERE u."ID_user" NOT IN(
                SELECT f."ID_user2" otherUserID FROM public."friendships" f WHERE f."ID_user1" =:userID AND f."ID_status" != 4
                UNION
                SELECT f."ID_user1" otherUserID FROM public."friendships" f WHERE f."ID_user2" =:userID AND f."ID_status" != 4
                UNION 
                SELECT :userID)
                AND u."ID_user_type" != 2 
            ORDER BY RANDOM()
            LIMIT 1');

        $stmt->bindParam('userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $userToShow = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userToShow == false){
            return null;
        }

        return $userToShow;
    }

    public function getUserImages(User $user){
        $userID = $this->getUserId($user->getEmail());
        if($userID == null){
            return null;
        }

        $stmt = $this->database->connect()->prepare('
            SELECT ud."icon_path" icon, ud."background_path" background FROM public."user_details" ud WHERE ud."ID_user" =:userID');

        $stmt->bindParam('userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $files = $stmt->fetch(PDO::FETCH_ASSOC);
        if($files == false){
            return null;
        }

        return $files;
    }
}