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
        $date = new DateTime();
        $stat = $this->database->connect()->prepare('
            INSERT INTO public.users(email, password) VALUES (?,?)
        ');

        // $date->format('Y-m-d')
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
            SELECT g."name", g."filename", gr."name" gamerank FROM public."users" u JOIN 
                public."user_details" ud ON u."ID_user" = ud."ID_user"
                JOIN public."user_game_info" ugi ON ud."ID_user_details" = ugi."ID_user_details"
                JOIN public.games g ON ugi."ID_game" = g."ID_game"
                JOIN public."games_ranks" gr ON ugi."ID_rank" = gr."ID_rank"
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
            SELECT g."name" FROM public."users" u JOIN 
                public."user_details" ud ON u."ID_user" = ud."ID_user"
                JOIN public."user_game_info" ugi ON ud."ID_user_details" = ugi."ID_user_details"
                JOIN public.games g ON ugi."ID_game" = g."ID_game"
                JOIN public."games_ranks" gr ON ugi."ID_rank" = gr."ID_rank"
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
}