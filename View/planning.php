<form method="GET" action="index.php">
    <input type="hidden" name="ctrl" value="user">
    <input type="hidden" name="action" value="planning">
    <label for="year">Sélectionner une année :</label>
    <select name="year" id="year" onchange="this.form.submit()">
        <option value="">Toutes les années</option>
        <?php foreach ($availableYears as $availableYear): ?>
            <option value="<?= htmlspecialchars($availableYear) ?>"
                <?= $selectedYear == $availableYear ? 'selected' : '' ?>>
                <?= htmlspecialchars($availableYear) ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<form method="POST" action="index.php?ctrl=user&action=updateEvent">
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
                    <td><?= htmlspecialchars($startDate) ?></td>
                    <td><?= htmlspecialchars($year ?? 'Non spécifiée') ?></td>
                    <td>
                        <select name="user_<?= htmlspecialchars($event["_id"]) ?>">
                            <option value="" <?= $id === null ? 'selected' : '' ?>>Aucun utilisateur</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= htmlspecialchars($user->getId()) ?>"
                                    <?= (string)$user->getId() === (string)$id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user->getLastName()) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit">Enregistrer</button>
</form>