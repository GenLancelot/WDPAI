<?php
require_once 'AppController.php';
require_once __DIR__ . '/../models/Game.php';
require_once __DIR__ . '/../repository/GameRepository.php';

class GamesController extends AppController
{
    const MAX_FILE_SIZE = 2048*2048;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/svg'];
    const UPLOAD_DIRECTORY = '/../public/icons/games/';
    private $gamesRepository;
    private $message = [];


    public function __construct()
    {
        parent::__construct();
        $this->gamesRepository = new GameRepository();
    }

    public function games()
    {
        $games = $this->gamesRepository->getGames();
        $this->render('gameselect', ['games' => $games]);
    }

    public function addGame(){
        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {
            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $game = new Game($_POST['name'], $_FILES['file']['name']);
            $this->gamesRepository->addGame($game);

            return $this->render('gameselect', [
                'messages' => $this->message,
                'games' => $this->gamesRepository->getGames()
            ]);
        }
    }

    public function search()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->gamesRepository->getGameByTitle($decoded['search']));
        }
    }

    public function getgameranks(){
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);
            header('Content-type: application/json');

            http_response_code(200);

            echo json_encode( $this->gamesRepository->getGameRanks($decoded['search']));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->message[] = 'File is too large for destination file system.';
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->message[] = 'File type is not supported.';
            return false;
        }
        return true;
    }

}