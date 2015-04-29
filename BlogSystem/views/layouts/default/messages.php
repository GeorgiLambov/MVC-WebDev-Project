<?php

renderMessages('infoMessages', 'info-messages');
renderMessages('errorMessages', 'error-messages');

function renderMessages($messagesKey, $cssClass) {
    if (isset($_SESSION[$messagesKey]) && count($_SESSION[$messagesKey]) > 0) {
        echo '<ul class="' . $cssClass . '">';
        foreach ($_SESSION[$messagesKey] as $msg) {
            echo "<li>" . htmlspecialchars($msg) . '</li>';
        }
        echo '</ul>';
    }
    $_SESSION[$messagesKey] = [];
}
