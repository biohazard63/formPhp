<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <title>Formulaire</title>
</head>
<body>
    <div class="content">
        <h1>Formulaire</h1>
        <p>Remplissez le formulaire suivant :</p>
        <form action="index.php" method="post">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" placeholder="Votre nom"
                   value="<?php echo isset($data['name']) ? $data['name'] : ''; ?>">
            <?php if (isset($errors['name'])) echo "<p class='erreur'>{$errors['name']}</p>"; ?>

            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" placeholder="Votre prénom"
                   value="<?php echo isset($data['firstname']) ? $data['firstname'] : ''; ?>">
            <?php if (isset($errors['firstname'])) echo "<p class='erreur'>{$errors['firstname']}</p>"; ?>

            <label for="email">Email :</label>
            <input type="email" id="email" name="email" placeholder="Votre email"
                   value="<?php echo isset($data['email']) ? $data['email'] : ''; ?>">
            <?php if (isset($errors['email'])) echo "<p class='erreur'>{$errors['email']}</p>"; ?>

            <label for="phone">Téléphone :</label>
            <input type="tel" id="phone" name="phone" placeholder="Votre téléphone"
                   value="<?php echo isset($data['phone']) ? $data['phone'] : ''; ?>">

            <label for="subject">Sujet :</label>
            <input type="text" id="subject" name="subject" placeholder="Sujet"
                   value="<?php echo isset($data['subject']) ? $data['subject'] : ''; ?>">

            <label for="message">Message :</label>
            <textarea id="message" name="message"
                      placeholder="Votre message"><?php echo isset($data['message']) ? $data['message'] : ''; ?></textarea>
            <?php if (isset($errors['message'])) echo "<p class='erreur'>{$errors['message']}</p>"; ?>

            <input type="checkbox" id="newsletter"
                   name="newsletter" <?php echo isset($data['newsletter']) && $data['newsletter'] ? 'checked' : ''; ?>>
            <label for="newsletter">Inscription à la newsletter</label>

            <input type="submit" value="Envoyer">
        </form>
        <?php if ($success): ?>
            <p class="success">Votre message a été envoyé avec succès !</p>
        <?php endif; ?>


    </div>
    <script src="../js/script.js"></script>
</body>
</html>