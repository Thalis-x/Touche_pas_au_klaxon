<?php
/**
 * Affichage des messages flash.
 * Variables disponibles : $flash
 */
?>
<?php if (!empty($flash)): ?>
    <?php foreach ($flash as $type => $messages): ?>
        <?php foreach ($messages as $message): ?>
            <div class="alert alert-<?= $type === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show mx-3 mt-3" role="alert">
                <?= htmlspecialchars($message) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>