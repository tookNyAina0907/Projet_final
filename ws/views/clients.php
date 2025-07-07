<?php
$title = 'Simulation de prêt';
ob_start();
?>

<h2>gestion de client</h2>

<form id="pretForm">
  <h3>Informations Client</h3>
  <label>Nom</label>
  <input type="text" name="nom" required>
  <label>Email</label>
  <input type="email" name="email" required>

  <h3>Type de prêt</h3>
  <select name="type_pret_id" id="type_pret_id" required>
    <!-- Rempli dynamiquement -->
  </select>

  <h3>Montant du prêt</h3>
  <input type="number" name="montant" min="1000" required>

  <h3>Durée (en mois)</h3>
  <input type="number" name="duree" min="1" required>

  <button type="button" onclick="simuler()">Simuler</button>

  <div id="simulationResult" style="margin-top: 1em;"></div>

  <button type="submit" disabled id="validerBtn">Valider le prêt</button>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
