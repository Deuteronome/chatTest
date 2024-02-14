<?PHP

namespace Model;

use PDO;
/*objet servant à l'intéraction avec la base de données*/
class Model {
    private PDO $bdd;

    /**
     * Quand on initialise l'objet avec la fonction new Model(), on crée un objet PDO qui eststocké dans l'objet Model
     */
    public function __construct()
    {
        $this->bdd = new PDO('mysql:host=127.0.0.1:3306;dbname=chat_test;charset=utf8','chat-admin', '5KMqtAs2t86cB5');
    }

    /**
     * Récupère tout les messages (note : a servi pendant le développement mais ne sert pas dans le projet finalisé)
     * 
     * return : un tableau de tableaux associatif de la forme :
     *  ['id':int, 'author':string, 'message':string, 'Date':timestamp]
     */
    public function getAllMessages() {
        $slQuery = "SELECT * FROM messages ORDER BY Date ASC";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute();
        $req = $logStatement->fetchAll();
        $logStatement->closeCursor();

        return $req;
    }

    /**
     * Stocke un nouveaux message dans la bdd
     * 
     * params : ($author : string, $message : string)
     * 
     * return : boolean
     */
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
    /**
     * Récupère tout les messages à partir d'une id donnée
     * 
     * params : (lastId : string - id à partir de laquelle on récupère les messages)
     * 
     * return : un tableau de tableaux associatif de la forme :
     *  ['id':int, 'author':string, 'message':string, 'Date':timestamp]
     */
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

    /**
     * Récupère l'id du dernier message entré en base de données
     * 
     * return : int
     */
    public function getLastMessageId() {
        $slQuery = "SELECT MAX(id) AS lastId FROM messages";
        $logStatement = $this->bdd->prepare($slQuery);
        $logStatement->execute();
        $req = $logStatement->fetch();
        $logStatement->closeCursor();

        return $req["lastId"];
    }
}