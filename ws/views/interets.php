<?php
require_once __DIR__ . '/../db.php';
$title = 'Intérêts gagnés';

$db = getDB();

// Récupération des dates depuis le formulaire (inputs type="month" donnent format YYYY-MM)
$debut = isset($_GET['debut']) ? $_GET['debut'] : null;
$fin = isset($_GET['fin']) ? $_GET['fin'] : null;

$interetsParMois = [];

if ($debut && $fin) {
    $stmt = $db->prepare("
        SELECT DATE_FORMAT(mois, '%m/%Y') AS mois, SUM(montant) AS total
        FROM interet
        WHERE mois BETWEEN ? AND LAST_DAY(?)
        GROUP BY mois
        ORDER BY mois
    ");
    $stmt->execute([$debut . '-01', $fin . '-01']);
    $interetsParMois = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

ob_start();
?>

<section>
  <h2>Visualisation des intérêts gagnés</h2>
  <form method="get" style="display:flex; gap:1rem; align-items:end; margin-bottom:2rem; flex-wrap:wrap;">
    <div>
      <label for="debut">Mois/année début</label>
      <input type="month" id="debut" name="debut" value="<?= htmlspecialchars($debut ?? '') ?>">
    </div>
    <div>
      <label for="fin">Mois/année fin</label>
      <input type="month" id="fin" name="fin" value="<?= htmlspecialchars($fin ?? '') ?>">
    </div>
    <button class="btn" type="submit">Filtrer</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Mois</th>
        <th>Intérêts totaux (Ar)</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($interetsParMois)): ?>
        <?php foreach ($interetsParMois as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['mois']) ?></td>
            <td><?= number_format($row['total'], 2, ',', ' ') ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="2" style="text-align:center;">Aucun intérêt trouvé pour cette période.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div style="margin-top:2rem;">
    <canvas id="chartInterets" height="100"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const mois = <?= json_encode(array_column($interetsParMois, 'mois')) ?>;
    const valeurs = <?= json_encode(array_map('floatval', array_column($interetsParMois, 'total'))) ?>;

    const ctx = document.getElementById('chartInterets').getContext('2d');

    if (mois.length > 0) {
      new Chart(ctx, {
        type: 'bar', // ou 'line'
        data: {
          labels: mois,
          datasets: [{
            label: 'Intérêts gagnés (Ar)',
            data: valeurs,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    } else {
      ctx.font = "16px Arial";
      ctx.fillText("Pas de données à afficher", 10, 50);
    }
  </script>
</section>

<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php';
?>
