<?php
$title = 'Accueil';
ob_start();
?>
<section style="text-align:center;">
  <h1>Bienvenue à l'Etablissement Financier</h1>
  <p style="font-size:1.1rem; color:#333;">Votre partenaire de confiance pour la gestion de prêts, de clients et de fonds. Accédez rapidement à toutes les fonctionnalités clés de votre établissement.</p>
  <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:1.5rem; margin-top:2rem;">
    <a class="btn" href="clients">🧍 Ajouter un client</a>
    <a class="btn" href="ajouter-pret" style="background:var(--secondary);">➕ Créer un prêt</a>
    <!-- <a class="btn" href="simulation" style="background:var(--accent);">📊 Simuler un prêt</a> -->
    <!-- <a class="btn" href="remboursements" style="background:var(--gray-dark);">📆 Consulter les remboursements</a> -->
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 