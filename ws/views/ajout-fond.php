<?php
require_once __DIR__ . '/../db.php';
$title = 'Ajouter des fonds';

$db = getDB();

// ID de l'établissement (fixé à 1 ici, à adapter si plusieurs établissements)
$etablissement_id = 1;

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['montant'])) {
    $montant = floatval($_POST['montant']);

    if ($montant > 0) {
        // Ajouter le fond
        $stmt = $db->prepare("UPDATE etablissement SET fond = fond + ? WHERE id = ?");
        $stmt->execute([$montant, $etablissement_id]);
    }
}

// Récupérer le fond actuel
$stmt = $db->prepare("SELECT fond FROM etablissement WHERE id = ?");
$stmt->execute([$etablissement_id]);
$fond = $stmt->fetchColumn();

ob_start();
?>

<section style="max-width:500px; margin:auto;">
  <h2>Ajouter des fonds à l'établissement</h2>
  <div style="margin:1.5rem 0; text-align:center;">
    <span class="badge badge-success" style="font-size:1.2rem;">
      Solde actuel : <strong><?= number_format($fond, 2, ',', ' ') ?> €</strong>
    </span>
  </div>

  <form method="post" style="display:flex; flex-direction:column; gap:1.2rem;">
    <label for="montant">Montant à ajouter (€)</label>
    <input type="number" id="montant" name="montant" min="1" step="0.01" required>
    <button class="btn" type="submit">Ajouter fonds</button>
  </form>
</section>

<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php';
