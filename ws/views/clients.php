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

  function simuler() {
    const form = document.getElementById('pretForm');
    const montant = parseFloat(form.montant.value);
    const duree = parseInt(form.duree.value);
    const selectedOption = form.type_pret_id.selectedOptions[0];
    const taux = parseFloat(selectedOption.dataset.taux);
    const assurance = parseFloat(selectedOption.dataset.assurance);

    if (!montant || !duree) {
      alert('Veuillez remplir tous les champs');
      return;
    }

    const amortissement = montant / duree;
    const assuranceMensuelle = (montant * (assurance / 100)) / duree;

    let capitalRestant = montant;
    let totalInterets = 0;
    let totalMensualites = 0;

    let rows = `<table border="1" style="width:100%; margin-top:10px;">
      <thead>
        <tr><th>Mois</th><th>Capital restant</th><th>Intérêt</th><th>Assurance</th><th>Mensualité</th></tr>
      </thead><tbody>`;

    for (let i = 1; i <= duree; i++) {
      const interet = capitalRestant * (taux / 100) / 12;
      const mensualite = amortissement + interet + assuranceMensuelle;
      totalInterets += interet;
      totalMensualites += mensualite;

      rows += `<tr>
        <td>${i}</td>
        <td>${capitalRestant.toFixed(2)}</td>
        <td>${interet.toFixed(2)}</td>
        <td>${assuranceMensuelle.toFixed(2)}</td>
        <td>${mensualite.toFixed(2)}</td>
      </tr>`;
      capitalRestant -= amortissement;
    }

    rows += `</tbody></table>`;
    rows += `<p><strong>Total des intérêts :</strong> ${totalInterets.toFixed(2)} Ar</p>`;
    rows += `<p><strong>Total à rembourser :</strong> ${totalMensualites.toFixed(2)} Ar</p>`;

    document.getElementById('simulationResult').innerHTML = rows;
    document.getElementById('validerBtn').disabled = false;
  }

  document.getElementById('pretForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const nom = this.nom.value.trim();
    const email = this.email.value.trim();
    const type_pret_id = this.type_pret_id.value;
    const montant = parseFloat(this.montant.value);
    const duree = parseInt(this.duree.value);

    // Vérifier si le client existe
    fetch(`${apiBase}/clients`)
      .then(res => res.json())
      .then(clients => {
        const client = clients.find(c => c.email.toLowerCase() === email.toLowerCase());

        let clientPromise;
        if (!client) {
          clientPromise = fetch(`${apiBase}/clients`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom, email })
          }).then(res => res.json());
        } else {
          clientPromise = Promise.resolve(client);
        }

        return clientPromise;
      })
      .then(client => {
        // Créer le prêt
        return fetch(`${apiBase}/prets`, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            client_id: client.id,
            type_pret_id,
            montant,
            duree,
            date_debut: new Date().toISOString().split('T')[0]
          })
        });
      })
      .then(res => {
        if (res.ok) {
          alert("Prêt enregistré avec succès !");
          document.getElementById('pretForm').reset();
          document.getElementById('simulationResult').innerHTML = '';
          document.getElementById('validerBtn').disabled = true;
        } else {
          alert("Erreur lors de l'enregistrement du prêt.");
        }
      })
      .catch(err => {
        console.error(err);
        alert("Erreur : " + err.message);
      });
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
