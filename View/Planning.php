<form method="post" action="planning_handler.php">
    <table border="1" class="events-table">
        <thead>
            <tr>
                <th>Date de début</th>
                <th>Année</th>
                <th>Utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event):
                $id = $event["user_id"];
                $user = $id ? $userManager->findOne($id) : null;

                // Calculer le premier jour de la semaine
                $weekNumber = $event['weekNumber'] ?? null;
                $year = $event['year'] ?? null;

                if ($weekNumber && $year) {
                    $firstDayOfWeek = new DateTime();
                    $firstDayOfWeek->setISODate($year, $weekNumber);
                    $startDate = $firstDayOfWeek->format('d/m');
                } else {
                    $startDate = 'Date non définie';
                }
            ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($startDate) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($event["year"] ?? 'Non spécifiée') ?>
                    </td>
                    <td>
                        <select name="user_<?= htmlspecialchars($event->_id) ?>">
                            <option value="" <?= $user === null ? 'selected' : '' ?>>
                                Aucun utilisateur
                            </option>
                            <?php if ($user): ?>
                                <option value="<?= htmlspecialchars($user->getId()) ?>" selected>
                                    <?= htmlspecialchars($user->getLastName()) ?>
                                </option>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit">Enregistrer</button>
</form>