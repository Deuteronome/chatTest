let message = document.querySelector('#message');
let send = document.querySelector('#send');
let chatFeed = document.querySelector('.chat-box');
let author = document.querySelector('#author').value;
let lastId = document.querySelector('#lastId').value;



setInterval(loadMessages, 1000);

function loadMessages() {
    
    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
        if(this.readyState == 4) {
            if(this.status == 200) {
                
                let loadedMessages = JSON.parse(this.response);
                
                for (let newMessage of loadedMessages) {
                    if(newMessage.id>lastId) {
                        lastId = newMessage.id;
                    }

                    //let dateMessage = new Date(newMessage);

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
            } else {
                let response = JSON.parse(this.response);
                console.log(response.message);
            }
        }
    }

    xhr.open("GET", '../controller/loadMessages.php?lastId='+lastId);

    xhr.send();
}

function enterValid(e) {
    if(e.key == "Enter") {
        addMessage();
    }
}

function addMessage() {
    let messageContent = message.value;
    
    
    
    if (messageContent !="") {
        let data = {};
        data['message'] = messageContent;

        let JSONdata = JSON.stringify(data);

        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if(this.readyState == 4) {
                if(this.status == 201) {
                    message.value = null;
                } else {
                    let response = JSON.parse(this.response);
                    console.log(response.message);
                }
            }
        }

        xhr.open("POST", "../controller/addMessage.php");
        xhr.send(JSONdata);
    }
}

message.addEventListener('keyup', enterValid);
send.addEventListener('click', addMessage);

