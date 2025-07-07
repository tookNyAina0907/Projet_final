<?php
$title = 'Liste des clients';
ob_start();
?>
<section>
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2>Clients enregistrés</h2>
    <a class="btn" href="ajouter-client">➕ Ajouter client</a>
  </div>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Date</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Exemple de ligne -->
      <tr>
        <td>Jean Dupont</td>
        <td>jean.dupont@email.com</td>
        <td>0601020304</td>
        <td>2024-07-07</td>
        <td class="table-actions"><a class="btn" href="pret-client.php?id=1" style="background:var(--accent);">Voir prêts</a></td>
      </tr>
      <!-- Fin exemple -->
    </tbody>
  </table>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php'; 