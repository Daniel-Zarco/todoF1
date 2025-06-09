<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>

<?php if ($isLoggedIn): ?>
    <nav class="navbar">
        <div class="navbar-user">
            👤 <?php echo htmlspecialchars($username); ?>
        </div>
    </nav>
<?php endif; ?>