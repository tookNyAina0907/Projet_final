<?php
$title = 'Remboursements du prêt';
ob_start();
?>
<section style="max-width:800px; margin:auto;">
  <h2>Remboursements du prêt</h2>
  <table>
    <thead>
      <tr>
        <th>Mois/Année</th>
        <th>Mensualité</th>
        <th>Intérêts</th>
        <th>Amortissement</th>
        <th>Statut</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>07/2024</td>
        <td>298 €</td>
        <td>37 €</td>
        <td>261 €</td>
        <td><span class="badge badge-success">Payé</span></td>
        <td class="table-actions"><a class="btn" href="#" style="background:var(--accent);">Effectuer un paiement</a></td>
      </tr>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 