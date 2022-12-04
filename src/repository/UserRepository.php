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
            $user['password'],
            $user['name'],
            $user['surname']
        );
    }

    public function addUser(User $user){
        $date = new DateTime();
        $stat = $this->database->connect()->prepare('
            INSERT INTO public.users(email, password, name, surname) VALUES (?,?,?,?)
        ');

        // $date->format('Y-m-d')
        $stat->execute([
            $user->getEmail(),
            $user->getPassword(),
            $user->getName(),
            $user->getSurname()
        ]);
    }
}