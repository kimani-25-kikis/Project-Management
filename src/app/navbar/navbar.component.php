<?php
// Sample dynamic data
$notification_count = 5; // Could come from a database
$user_name = 'Admin'; // Could come from a session
?>

<div class="toolbar">
    <div class="menu">
        <p><?php echo htmlspecialchars($user_name); ?></p>
        <button class="btn-icon" title="Menu" onclick="toggleMenu()">
            <span>☰</span>
        </button>
    </div>
    <div>
        <button class="btn-icon" title="Notifications (<?php echo $notification_count; ?>)" onclick="showNotifications()">
            <span>🔔 <?php if ($notification_count > 0) echo "<span class='badge bg-danger'>$notification_count</span>"; ?></span>
        </button>
        <button class="btn-icon" title="Language">
            <img src="assets/uk-flag.png" width="24px" alt="UK Flag">
        </button>
        <button class="btn-icon" title="Fullscreen" onclick="toggleFullscreen()">
            <span>⛶</span>
        </button>
    </div>
</div>

<!-- Same HTML head and script as above -->