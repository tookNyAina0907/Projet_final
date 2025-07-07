<?php
$title = 'Ajouter des fonds';
ob_start();
?>
<section style="max-width:500px; margin:auto;">
  <h2>Ajouter des fonds à l'établissement</h2>
  <div style="margin:1.5rem 0; text-align:center;">
    <span class="badge badge-success" style="font-size:1.2rem;">Solde actuel : <strong>100 000 €</strong></span>
  </div>
  <form method="post" style="display:flex; flex-direction:column; gap:1.2rem;">
    <label for="montant">Montant à ajouter (€)</label>
    <input type="number" id="montant" name="montant" min="1" step="0.01" required>
    <button class="btn" type="submit">Ajouter fonds</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; ?>