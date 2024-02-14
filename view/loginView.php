<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/bootstrap.css">
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/bootstrap.bundle.js" defer></script>
    <title>Login</title>
</head>
<body class="login-page">
    <!-- Juste un formulaire centré dans la page - pas d'identification sécurisé, on entre juste un pseudo, le formulaire est directement géré par le controller du chat, - pas de controller dédié à l'identification -->
    <main class="container-fluid">
        <section class="row justify-content-center">
            <div class="col-11 col-lg-8 justify-content-center align-items-center p-4 login-box">
                <form action="../controller/chat.php" method="post">
                    <label for="usersname" class="form-label">Nom : </label>
                    <input type="text" name="username" id="username" class="form-control">
                    <input type="submit" value="Valider" class="btn btn-dark mt-5">
                </form>
            </div>
        </section>
    </main>
</body>
</html>