<form method="post" action="planning_handler.php">
    <table border="1" class="events-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Année</th>
                <th>Utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event):
                $id = $event->user_id;
                $user = $userManager->findOne($id);
            ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($event->date ?? 'Non spécifiée') ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($event->year ?? 'Non spécifiée') ?>
                    </td>
                    <td>
                        <select name="user_<?= htmlspecialchars($event->_id) ?>">
                            <option value="<?= htmlspecialchars($user->getId()) ?>">
                                <?= htmlspecialchars($user->getLastName()) ?>
                            </option>
                            <!-- Vous pouvez ajouter d'autres options ici -->
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit">Enregistrer</button>
</form>