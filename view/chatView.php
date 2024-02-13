<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/bootstrap.css">
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/bootstrap.bundle.js" defer></script>
    <script src="../script/chat.js" defer></script>
    <title>Chat</title>
</head>
<body>
    <input type="hidden" id="author" value="<?php echo $_SESSION['username'] ?>">
    <input type="hidden" id="lastId" value="<?php echo $lastId ?>">
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <h1 class="navbar-brand">
                <img src="../asset/images/logo.png" alt="logo" class="img-fluid ms-3" width="40">
                Bonjour <?php  echo $_SESSION['username']?></h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="../controller/logout.php">Déconnexion</a>
                </li>                
            </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid chat-page justify-content-between">
        <section class="row chat-zone justify-content-center mt-4">
            <div class="col-11 chat-box">
                
            </div>
        </section>
        <section class="row send-zone justify-content-between mt-4">
            <div class="col-9">
                <input type="text" name="message" id="message" class="form-control" placeholder="Votre message...">
            </div>            
            <button id="send" class="col-2 btn btn-dark me-3">Envoyer</button>
        </section>
    </main>
</body>
</html>