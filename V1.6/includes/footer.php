<!-- footer.php -->
<footer class="footer">
    <div class="footer-links">
        <a href="index.php">Home</a> |
        <a href="about.php">About Us</a> |
        <a href="sustainability.php">Sustainability</a> |
        <a href="contact.php">Contact</a> |
        <a href="endorsements.php">Partners</a> |
        <a href="privacy.php">Privacy Policy</a> |
        <a href="terms.php">Terms & Conditions</a> |
        <a href="logout.php">Logout</a>
    </div>

    <div class="font-controls">
        <button onclick="setFontSize('small')">A-</button>
        <button onclick="setFontSize('standard')">A</button>
        <button onclick="setFontSize('large')">A+</button>
    </div>

    <div class="footer-copy">
        &copy; <?php echo date('Y'); ?> Sustain Energy. All rights reserved.
    </div>
</footer>

<script>
function setFontSize(size) {
    let root = document.documentElement;

    switch (size) {
        case 'small':
            root.style.fontSize = '14px';
            break;
        case 'standard':
            root.style.fontSize = '16px';
            break;
        case 'large':
            root.style.fontSize = '18px';
            break;
    }

    localStorage.setItem('fontSize', size); // Save preference
}

// Load font size preference on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedSize = localStorage.getItem('fontSize');
    if (savedSize) setFontSize(savedSize);
});
</script>


