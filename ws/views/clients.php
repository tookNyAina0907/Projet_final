// <?php
// $title = 'Liste des clients';
// ob_start();
// ?>
// <section>
//   <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
//     <h2>Clients enregistrés</h2>
//     <a class="btn" href="ajouter-client">➕ Ajouter client</a>
//   </div>
//   <table>
//     <thead>
//       <tr>
//         <th>Nom</th>
//         <th>Email</th>
//         <th>Téléphone</th>
//         <th>Date</th>
//         <th>Actions</th>
//       </tr>
//     </thead>
//     <tbody>
//       <!-- Exemple de ligne -->
//       <tr>
//         <td>Jean Dupont</td>
//         <td>jean.dupont@email.com</td>
//         <td>0601020304</td>
//         <td>2024-07-07</td>
//         <td class="table-actions"><a class="btn" href="pret-client.php?id=1" style="background:var(--accent);">Voir prêts</a></td>
//       </tr>
//       <!-- Fin exemple -->
//     </tbody>
//   </table>
// </section>
// <?php
// $content = ob_get_clean();
// include __DIR__.'/../templates/layout.php'; 

<script>function simuler() {
  const form = document.getElementById('pretForm');
  const montant = parseFloat(form.montant.value);
  const duree = parseInt(form.duree.value);
  const tauxText = form.type_pret_id.options[form.type_pret_id.selectedIndex].text;
  const taux = parseFloat(tauxText.match(/\((\d+\.?\d*)%\)/)[1]);

  if (!montant || !duree) {
    alert('Veuillez remplir montant et durée.');
    return;
  }

  const amortissement = montant / duree;
  let capitalRestant = montant;
  let totalInterets = 0;
  let rows = `<table border="1" style="width:100%; margin-top:10px;">
    <thead>
      <tr><th>Mois</th><th>Capital Restant</th><th>Intérêt</th><th>Mensualité</th></tr>
    </thead><tbody>`;

  for (let i = 1; i <= duree; i++) {
    const interet = capitalRestant * (taux / 100) / 12;
    const mensualite = amortissement + interet;
    totalInterets += interet;
    rows += `<tr>
      <td>${i}</td>
      <td>${capitalRestant.toFixed(2)}</td>
      <td>${interet.toFixed(2)}</td>
      <td>${mensualite.toFixed(2)}</td>
    </tr>`;
    capitalRestant -= amortissement;
  }
  rows += `</tbody></table>`;
  rows += `<p><strong>Total des intérêts :</strong> ${totalInterets.toFixed(2)} Ar</p>`;
  rows += `<p><strong>Montant total à rembourser :</strong> ${(montant + totalInterets).toFixed(2)} Ar</p>`;

  document.getElementById('simulationResult').innerHTML = rows;
  document.getElementById('validerBtn').disabled = false;
}
document.addEventListener('DOMContentLoaded', function () {
    fetch('/types') // Ton endpoint FlightPHP
      .then(response => {
        if (!response.ok) throw new Error("Erreur lors de la requête");
        return response.json();
      })
      .then(data => {
        const select = document.getElementById('type_pret_id');
        data.forEach(type => {
          const option = document.createElement('option');
          option.value = type.id;
          option.textContent = `${type.nom} (${type.taux}%)`;
          select.appendChild(option);
        });
      })
      .catch(error => {
        console.error('Erreur chargement types de prêt :', error);
        alert("Impossible de charger les types de prêt.");
      });
  });
</script>

<form id="pretForm">
  <h3>Informations Client</h3>
  <label>Nom</label>
  <input type="text" name="nom" required>
  <label>Email</label>
  <input type="email" name="email" required>

  <h3>Type de prêt</h3>
  <select name="type_pret_id" id="type_pret_id" required>
    <!-- Options à charger via AJAX -->
  </select>

  <h3>Montant du prêt</h3>
  <input type="number" name="montant" min="1000" required>

  <h3>Durée (mois)</h3>
  <input type="number" name="duree" min="1" required>

  <button type="button" onclick="simuler()">Simuler</button>
  
  <div id="simulationResult" style="margin-top: 1em;"></div>

  <button type="submit" disabled id="validerBtn">Valider le prêt</button>
</form>

<script>
  // Charger les types de prêt depuis l'API
  fetch('/type_prets').then(res => res.json()).then(data => {
    const select = document.getElementById('type_pret_id');
    data.forEach(tp => {
      let option = document.createElement('option');
      option.value = tp.id;
      option.textContent = tp.nom + " (" + tp.taux + "%)";
      select.appendChild(option);
    });
  });

  function simuler() {
    const form = document.getElementById('pretForm');
    const montant = parseFloat(form.montant.value);
    const duree = parseInt(form.duree.value);
    const taux = form.type_pret_id.options[form.type_pret_id.selectedIndex].text.match(/\((\d+\.?\d*)%\)/)[1];

    if (!montant || !duree) {
      alert('Veuillez remplir montant et durée.');
      return;
    }

    // Calcul simplifié amortissement constant + intérêts
    const amortissement = montant / duree;
    let capitalRestant = montant;
    let totalInterets = 0;
    let rows = `<table border="1" style="width:100%; margin-top:10px;">
      <tr><th>Mois</th><th>Capital Restant</th><th>Intérêt</th><th>Mensualité</th></tr>`;

    for (let i = 1; i <= duree; i++) {
      let interet = capitalRestant * (taux / 100) / 12;
      let mensualite = amortissement + interet;
      totalInterets += interet;
      rows += `<tr>
        <td>${i}</td>
        <td>${capitalRestant.toFixed(2)}</td>
        <td>${interet.toFixed(2)}</td>
        <td>${mensualite.toFixed(2)}</td>
      </tr>`;
      capitalRestant -= amortissement;
    }
    rows += `</table><p>Total des intérêts : ${totalInterets.toFixed(2)} Ar</p>`;

    document.getElementById('simulationResult').innerHTML = rows;
    document.getElementById('validerBtn').disabled = false;
  }

  // Gestion de la validation
  document.getElementById('pretForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Données client
    const nom = this.nom.value.trim();
    const email = this.email.value.trim();

    // Vérifier si client existe
    fetch(`/clients?email=${encodeURIComponent(email)}`)
      .then(res => res.json())
      .then(clients => {
        let client = clients.find(c => c.email.toLowerCase() === email.toLowerCase());

        // Si client pas trouvé, créer
        let clientPromise;
        if (!client) {
          clientPromise = fetch('/clients', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({nom, email})
          }).then(res => res.json()).then(data => {
            return {id: data.insertId || data.id}; // adapter selon réponse API
          });
        } else {
          clientPromise = Promise.resolve(client);
        }

        return clientPromise;
      })
      .then(client => {
        // Créer le prêt
        const type_pret_id = this.type_pret_id.value;
        const montant = parseFloat(this.montant.value);
        const duree = parseInt(this.duree.value);

        return fetch('/prets', {
          method: 'POST',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({
            client_id: client.id,
            type_pret_id,
            montant,
            duree,
            date_debut: new Date().toISOString().slice(0,10)
          })
        });
      })
      .then(res => {
        if (res.ok) {
          alert('Prêt créé avec succès');
          this.reset();
          document.getElementById('simulationResult').innerHTML = '';
          document.getElementById('validerBtn').disabled = true;
        } else {
          alert('Erreur lors de la création du prêt');
        }
      })
      .catch(err => alert('Erreur : ' + err.message));
  });
</script>
