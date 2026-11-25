<?php
$activePage = 'messages';
$pageStyle = 'messages';
$pageTitle = 'Messages | ' . $appName;
?>
<?php require __DIR__ . '/includes/head.php'; ?>
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
                <p>Vous n’avez pas encore d’amis. <a href="<?= $basePath ?>/amis">Ajouter un ami</a>.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($contacts as $contact): ?>
                        <?php $isSelected = $selectedContact !== null && $selectedContact->getId() === (int) $contact['id']; ?>

                        <li>
                            <a href="<?= $basePath ?>/messages/<?= (int) $contact['id'] ?>"<?= $isSelected ? ' aria-current="page"' : '' ?>>
                                <span aria-hidden="true">@</span>
                                <span><?= htmlspecialchars($contact['nom_utilisateur']) ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>

        <section aria-label="Conversation">
            <?php if ($selectedContact === null): ?>
                <div>
                    <h2>Bienvenue dans les messages</h2>
                    <p>Choisissez un ami pour commencer une conversation, ou <a href="<?= $basePath ?>/amis">ajoutez-en un</a>.</p>
                </div>
            <?php else: ?>
                <header>
                    <span aria-hidden="true">@</span>

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

                <form action="<?= $basePath ?>/messages/<?= $selectedContact->getId() ?>/envoyer" method="post">
                    <textarea id="message-body" name="body" aria-label="Votre message" maxlength="2000" placeholder="Écrire à <?= htmlspecialchars($selectedContact->getUsername()) ?>" required></textarea>

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
