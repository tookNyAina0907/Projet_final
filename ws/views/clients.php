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
<script>
  const apiBase = "http://localhost/Projet_final/ws"; // adapte à ton chemin

  // Charger les types de prêt
  fetch(`${apiBase}/types`)
    .then(res => res.json())
    .then(data => {
      const select = document.getElementById('type_pret_id');
      data.forEach(tp => {
        const option = document.createElement('option');
        option.value = tp.id;
        option.textContent = `${tp.nom} (Taux ${tp.taux}%, Assurance ${tp.assurance}%)`;
        option.dataset.taux = tp.taux;
        option.dataset.assurance = tp.assurance;
        select.appendChild(option);
      });
    });
</script>
<?php
$content = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
