<header>
    <a href="./index.php?ctrl=user&action=home" class="info-bar">
        <div>Ma plateforme MVC !</div>
    </a>

    <div id="banner-bloc">
        <h1>Planning d'épluchages de patates</h1>
    </div>

    <div id="account_bar">
        <div class="connection center">
            <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_last_name'])) : ?>
                <!-- Affiche le prénom et le nom si l'utilisateur est connecté -->
                <p>Bienvenue, <?= htmlspecialchars($_SESSION['user_last_name']) ?></p>
                <a href="./index.php?ctrl=user&action=logout" class="no-deco" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <div class="text">Logout</div>
                </a>
            <?php else: ?>
                <!-- Lien de connexion si l'utilisateur n'est pas connecté -->
                <a href="./index.php?ctrl=user&action=login" class="no-deco" title="Login or create account">
                    <i class="fas fa-user"></i>
                    <div class="text">Login</div>
                </a>
            <?php endif; ?>
        </div>
    </div>
    <ul id="menu_bar">
        <a href="./index.php?ctrl=user&action=usersList" class="no-deco">
            <li>Liste des utilisateurs</li>
        </a>
    </ul>
</header>