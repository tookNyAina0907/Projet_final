<?php
$title = 'PDF Récapitulatif Prêt';
ob_start();
?>
<section style="max-width:800px; margin:auto;">
  <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem;">
    <img src="/logo.png" alt="Logo EF" style="height:50px;">
    <span style="font-weight:bold; font-size:1.2rem; color:var(--primary-dark);">Récapitulatif de prêt</span>
  </div>
  <h3>Données client</h3>
  <ul style="list-style:none; padding:0; margin-bottom:1.5rem;">
    <li><strong>Nom :</strong> Jean Dupont</li>
    <li><strong>Email :</strong> jean.dupont@email.com</li>
    <li><strong>Téléphone :</strong> 0601020304</li>
  </ul>
  <h3>Détail du prêt</h3>
  <ul style="list-style:none; padding:0; margin-bottom:1.5rem;">
    <li><strong>Montant :</strong> 10 000 €</li>
    <li><strong>Taux :</strong> 4.5 %</li>
    <li><strong>Durée :</strong> 36 mois</li>
    <li><strong>Assurance :</strong> 0.5 %</li>
  </ul>
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
  <div style="text-align:right; margin-top:2rem;">
    <img src="/logo.png" alt="Signature/Logo" style="height:40px; opacity:0.7;">
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 