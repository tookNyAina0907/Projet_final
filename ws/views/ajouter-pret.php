<?php
$title = 'Créer un prêt';
ob_start();
?>
<section style="max-width:600px; margin:auto;">
  <h2>Créer un prêt pour un client</h2>
  <form method="post" style="display:flex; flex-direction:column; gap:1.2rem;">
    <label>Client</label>
    <select name="client_id" required>
      <option value="">Sélectionner un client</option>
      <option value="1">Jean Dupont</option>
    </select>
    <label>Type de prêt</label>
    <select name="type_pret" required>
      <option value="">Sélectionner un type</option>
      <option value="1">Prêt Personnel</option>
    </select>
    <label>Montant (€)</label>
    <input type="number" name="montant" min="1" step="0.01" required>
    <label>Durée (mois)</label>
    <input type="number" name="duree" min="1" required>
    <!-- <label>Assurance (%)</label>
    <input type="number" name="assurance" step="0.01" min="0" required> -->
    <!-- <label>Délai de grâce (mois, S4 uniquement)</label>
    <input type="number" name="grace" min="0" value="0"> -->
    <button class="btn" type="submit" name="simuler">Simuler prêt</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 