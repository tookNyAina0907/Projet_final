<?php
$title = 'Intérêts gagnés';
ob_start();
?>
<section>
  <h2>Visualisation des intérêts gagnés</h2>
  <form method="get" style="display:flex; gap:1rem; align-items:end; margin-bottom:2rem; flex-wrap:wrap;">
    <div>
      <label>Mois/année début</label>
      <input type="month" name="debut">
    </div>
    <div>
      <label>Mois/année fin</label>
      <input type="month" name="fin">
    </div>
    <button class="btn" type="submit">Filtrer</button>
  </form>
  <table>
    <thead>
      <tr>
        <th>Mois</th>
        <th>Intérêts totaux (€)</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>07/2024</td>
        <td>120 €</td>
      </tr>
    </tbody>
  </table>
  <div style="background:#e3eafc; border-radius:8px; padding:2rem; text-align:center;">
    <span style="color:var(--primary); font-weight:bold;">[Graphique des intérêts mensuels ici]</span>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 