<?php
require __DIR__ . '/includes/head.php';
$selectedContact = $selectedContact ?? null;
?>
<title>Messages | <?= htmlspecialchars(APP_NAME) ?></title>
<link rel="stylesheet" href="<?= htmlspecialchars(APP_BASE_PATH) ?>/css/pages/messages.css">
</head>
<body>
<?php require __DIR__ . '/includes/header.php'; ?>

<main id="messages">
    <h1>Messages</h1>

    <?php if (!empty($alert)): ?>
        <p><?= htmlspecialchars($alert) ?></p>
    <?php endif; ?>

    <div>
        <aside>
            <h2>Amis</h2>

            <?php if (empty($contacts)): ?>
                <p>Vous n’avez pas encore d’amis. <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis">Ajouter un ami</a>.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($contacts as $contact): ?>
                        <?php $isSelected = $selectedContact !== null && $selectedContact->getId() === (int) $contact['id']; ?>

                        <li>
                            <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/messages/<?= (int) $contact['id'] ?>">
                                <span>@</span>
                                <span><?= htmlspecialchars($contact['nom_utilisateur']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>

        <section>
            <?php if ($selectedContact === null): ?>
                <div>
                    <h2>Bienvenue dans les messages</h2>
                    <p>Choisissez un ami pour commencer une conversation, ou <a href="<?= htmlspecialchars(APP_BASE_PATH) ?>/amis">ajoutez-en un</a>.</p>
                </div>
            <?php else: ?>
                <header>
                    <span>@</span>

                    <div>
                        <h2><?= htmlspecialchars($selectedContact->getUsername()) ?></h2>
                        <p>Message privé</p>
                    </div>
                </header>

                <div id="chat-message-list">
                    <?php if (empty($messages)): ?>
                        <p>Pas encore de messages. Envoyez le premier !</p>
                    <?php else: ?>
                        <?php foreach ($messages as $chatMessage): ?>
                            <?php $isOwnMessage = (int) $chatMessage['expediteur_id'] === $currentUserId; ?>

                            <article data-own="<?= $isOwnMessage ? 'true' : 'false' ?>">
                                <div>
                                    <strong><?= htmlspecialchars($chatMessage['nom_expediteur']) ?></strong>
                                    <time datetime="<?= htmlspecialchars($chatMessage['date_creation']) ?>">
                                        <?= htmlspecialchars(date('d/m/Y H:i', strtotime($chatMessage['date_creation']))) ?>
                                    </time>
                                </div>
                                <p><?= nl2br(htmlspecialchars($chatMessage['contenu'])) ?></p>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <form action="<?= htmlspecialchars(APP_BASE_PATH) ?>/messages/<?= $selectedContact->getId() ?>/envoyer" method="post">
                    <textarea id="message-body" name="body" maxlength="2000" placeholder="Écrire à <?= htmlspecialchars($selectedContact->getUsername()) ?>" required></textarea>

                    <button type="submit">Envoyer</button>
                </form>
            <?php endif; ?>
        </section>
    </div>
</main>

<?php if ($selectedContact !== null): ?>
    <script>
        const messageList = document.getElementById('chat-message-list');
        messageList.scrollTop = messageList.scrollHeight;
    </script>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
