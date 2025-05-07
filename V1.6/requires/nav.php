

<nav class="navbar">
    <div class="nav-left">
        <a href="index.php" class="nav-link">
            <img src="images/logo.png" alt="Sustain Energy Logo" class="logo">
            <div class="company-name">
                <strong>Sustain Energy</strong>
            </div>
        </a>
    </div>

    <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="calculator.php">Green Calculator</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="user_account.php">Profile</a></li>
        <li><a href="contact.php">Contact Us</a></li>
        
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
        <li><a href="admin_panel.php">Admin Panel</a></li>
        <?php endif; ?>
    </ul>

    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="post" action="logout.php" style="display:inline;">
            <a href="logout.php" class="nav-link">Logout</a>
            </form>
        <?php else: ?>
            <a href="login.php" class="nav-link">Log In</a>
            <a href="register.php" class="nav-link">Register</a>
        <?php endif; ?>


    </div>
</nav>
