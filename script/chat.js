let message = document.querySelector('#message');//input dans lequel l'utilsateur écrit son message
let send = document.querySelector('#send');//bouton 'envoyer' à côté de l'input
let chatFeed = document.querySelector('.chat-box');//zone dans laquelle les messages doivent s'afficher
let author = document.querySelector('#author').value;//nom de l'utilisateur (type string)
let lastId = document.querySelector('#lastId').value;//id du dernier message entré en base de données (type int)


//lance la fonction loadMessage toutes les secondes
setInterval(loadMessages, 1000);

/**
 * le script intéroge le serveur pour savoir s'il y a de nouveaux messages - si oui, il les récupère et les affiche - les données échangées sont au format JSON
 */
function loadMessages() {
    
    //on crée un requête pour le serveur (AJAX)
    let xhr = new XMLHttpRequest();

    //On définit ce qui se passe quand la requête est terminé (le client a reçu une réponse du serveur, ce qui correspond à l'état 4 de readyState)
    xhr.onreadystatechange = function () {
        if(this.readyState == 4)/* La requête est terminé */ {
            if(this.status == 200) /*code 200 : tout s'est bien passé*/ {
                //on récupère les messages et on les décode
                let loadedMessages = JSON.parse(this.response);
                
                //on boucle pour chaque message 
                for (let newMessage of loadedMessages) {
                    if(newMessage.id>lastId) {
                        lastId = newMessage.id;//on met à jour l'id du dernier message
                    }                   

                    //on insert les messages dans le DOM - html en insérant les données du message newMessage.author et newMessage.Message
                    let chatLine = document.createElement('div');
                    chatLine.classList.add('row', 'align-items-end', 'my-3');
                    if(author == newMessage.author) {
                        chatLine.classList.add('flex-row-reverse');
                    }
                    let pseudoBox = document.createElement('div');
                    pseudoBox.classList.add('col-4', 'col-lg-2', 'pseudo', 'mx-2');
                    pseudoBox.innerHTML = newMessage.author;
                    let messageBubble = document.createElement('div')
                    messageBubble.classList.add('col-6', 'message');
                    messageBubble.innerHTML= newMessage.message;

                    chatLine.appendChild(pseudoBox);
                    chatLine.appendChild(messageBubble);
                    chatFeed.appendChild(chatLine);
                    chatFeed.scrollTop = chatFeed.scrollHeight;
                }
            } else/*Il y a eu un problème, l'erreur s'affiche dans la console */ {
                let response = JSON.parse(this.response);
                console.log(response.message);
            }
        }
    }

    //on envoie la requête à un controller spécifique - methode get, la données lastId est envoyé dans l'url 
    xhr.open("GET", '../controller/loadMessages.php?lastId='+lastId);

    xhr.send();
}

/**
 * Quand l'utilisateur écrit dans la zone message, si c'est la touche entrée qui est utlisé, on envoie le message
 * 
 * @param {event} e 
 */
function enterValid(e) {
    if(e.key == "Enter") {
        addMessage();
    }
}

/**
 * envoie du message à la base de données - requête AJAX, même structure que la fonction loadMessages
 */
function addMessage() {
    let messageContent = message.value;//on récupère le message entrée par l'utilisateur 
    
    //on n'envoie le message que s'il n'est pas vide
    if (messageContent !="") {
        let data = {};//on initialise une structure associative JS
        data['message'] = messageContent;//on stocke le message dedans

        let JSONdata = JSON.stringify(data); //on convertie en JSON

        //Création de la requête
        let xhr = new XMLHttpRequest();

        //Gestion de fin de requête
        xhr.onreadystatechange = function () {
            if(this.readyState == 4) {
                if(this.status == 201) {
                    message.value = null;//si tout va bien, il n'y a rien à faire, les données ont été rentrée en bdd, on efface juste le champ input pour laisser la place à l'utilisateur d'entrer un nouveau message
                } else {
                    let response = JSON.parse(this.response);
                    console.log(response.message);//en cas d'erreur, elle est affichée en console
                }
            }
        }

        //on envoir la requête au bon controller - méthode POST pour entrer des données en base de données
        xhr.open("POST", "../controller/addMessage.php");
        xhr.send(JSONdata);//contrairement à la méthode get, les données envoyées le sont en paramètre de la méthode send
    }
}

/* écouteur d'évenement - quand l'utilisateur écrit dans l'input ou qu'il clique sur envoyer*/
message.addEventListener('keyup', enterValid);
send.addEventListener('click', addMessage);

