<?PHP

namespace Model;

use PDO;

class Model {
    private PDO $bdd;

    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=127.0.0.1:3306;dbname=chat_test;charset=utf8','chat-admin', '5KMqtAs2t86cB5');
    }

    public function getAllMessages() {
        $slQuery = "SELECT * FROM messages ORDER BY Date ASC";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute();
        $req = $logStatement->fetchAll();
        $logStatement->closeCursor();

        return $req;
    }

    public function createMessage($author, $message) {
        $slQuery = "INSERT INTO messages (author, message)
                    VALUES(:author, :message)";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute([
            "author" => $author,
            "message" => $message
        ]);
        $logStatement->closeCursor();

        return true;
    }

    public function loadLastMessages($lastId) {
        $slQuery = "SELECT * FROM messages WHERE id > :lastId ORDER BY id ASC";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute([
            "lastId" => $lastId
        ]);
        $req = $logStatement->fetchAll();
        $logStatement->closeCursor();

        return $req;
    }

    public function getLastMessageId() {
        $slQuery = "SELECT MAX(id) AS lastId FROM messages";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute();
        $req = $logStatement->fetch();
        $logStatement->closeCursor();

        return $req["lastId"];
    }
}