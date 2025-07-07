<?php
$title = 'Prêts du client';
ob_start();
?>
<section>
  <h2>Prêts du client</h2>
  <table>
    <thead>
      <tr>
        <th>Date de demande</th>
        <th>Montant</th>
        <th>Taux</th>
        <th>Statut</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2024-07-07</td>
        <td>10 000 €</td>
        <td>4.5 %</td>
        <td><span class="badge badge-success">Validé</span></td>
        <td class="table-actions">
          <a class="btn" href="remboursements.php?id=1" style="background:var(--accent);">Remboursements</a>
          <a class="btn" href="pdf-pret.php?id=1" style="background:var(--gray-dark);">PDF</a>
        </td>
      </tr>
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 