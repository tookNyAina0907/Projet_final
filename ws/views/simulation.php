<?php
$title = 'Simulation de prêt';
ob_start();
?>
<section style="max-width:800px; margin:auto;">
  <h2>Simulation de prêt</h2>
  <div style="display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; margin-bottom:2rem;">
    <div><strong>Montant emprunté :</strong> 10 000 €</div>
    <div><strong>Taux :</strong> 4.5 %</div>
    <div><strong>Assurance :</strong> 0.5 %</div>
    <div><strong>Durée :</strong> 36 mois</div>
    <div><strong>Annuité constante :</strong> 298 €/mois</div>
  </div>
  <h3>Tableau d'amortissement</h3>
  <table>
    <thead>
      <tr>
        <th>Mois</th>
        <th>Mensualité</th>
        <th>Intérêts</th>
        <th>Amortissement</th>
        <th>Solde restant</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>298 €</td>
        <td>37 €</td>
        <td>261 €</td>
        <td>9 739 €</td>
      </tr>
    </tbody>
  </table>
  <form method="post" style="text-align:center; margin-top:2rem;">
    <button class="btn" type="submit" name="valider">Valider prêt</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 