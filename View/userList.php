<section id="main-section">
    <div>
        <h2 class="center">List of users</h2>
        <table class="user-list-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Password</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Admin</th>
                    <th>Actions</th> <!-- Nouvelle colonne pour les actions -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td><?= htmlspecialchars($user->getPassword()) ?></td>
                        <td><?= htmlspecialchars($user->getFirstName()) ?></td>
                        <td><?= htmlspecialchars($user->getLastName()) ?></td>
                        <td><?= $user->getAdmin() ? '1' : '0' ?></td>
                        <td>
                            <a href="./index.php?ctrl=user&action=modif&id=<?= $user->getId() ?>" class="btn btn-edit">Modifier</a>
                            <?php if ($_SESSION['user_id'] !== $user->getId()): // Empêche d'afficher le bouton Supprimer pour l'utilisateur connecté 
                            ?>
                                <a href="./index.php?ctrl=user&action=suppress&id=<?= $user->getId() ?>"
                                    class="btn btn-delete"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>