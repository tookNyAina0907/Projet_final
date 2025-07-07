<?php
$title = 'Ajouter un client';
ob_start();
?>
<section style="max-width:500px; margin:auto;">
  <h2>Ajouter un client</h2>
  <form method="post" style="display:flex; flex-direction:column; gap:1.2rem;">
    <label>Nom</label>
    <input type="text" name="nom" required>
    <label>Email</label>
    <input type="email" name="email" required>
    <label>Téléphone</label>
    <input type="text" name="telephone" required>
    <label>Date</label>
    <input type="date" name="date" required>
    <button class="btn" type="submit">Ajouter client</button>
  </form>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 