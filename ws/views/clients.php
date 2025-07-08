<?php
$title = 'Simulation de prêt';
ob_start();
?>

<section>
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2>Gestion de client</h2>
    <span id="date-today"></span>
  </div>
  <form id="pretForm">
    <h3>Informations Client</h3>
    <label>Nom</label>
    <input type="text" name="nom" required>
    <label>Email</label>
    <input type="email" name="email" required>

    <h3>Type de prêt</h3>
    <select name="type_pret_id" id="type_pret_id" required>
      <!-- Les options seront chargées via AJAX -->
    </select>

    <h3>Montant du prêt</h3>
    <input type="number" name="montant" id="montant" min="1000" required>

    <h3>Durée (en mois)</h3>
    <input type="number" name="duree" id="duree" min="1" required>

    <div style="margin-top:1.5rem;">
      <button type="button" id="btn-simuler" class="btn">Simuler</button>
      <button type="button" id="btn-voir-tableau" class="btn" style="display:none">Voir intérêt par mois</button>
      <button type="button" id="btn-valider" class="btn">Valider</button>

      <!-- <button type="button" id="btn-simuler">Simuler</button> -->

      <div id="simulation-container"></div>
    </div>
  </form>

  <div id="recapitulatif" style="margin-top: 2rem;"></div>
  <div id="simulation-container" style="margin-top:2rem;"></div>
</section>

<script>
  const apiBase = "http://localhost/Projet_final/ws";

  function afficherDateDuJour() {
    const today = new Date();
    const jour = String(today.getDate()).padStart(2, '0');
    const mois = String(today.getMonth() + 1).padStart(2, '0');
    const annee = today.getFullYear();
    document.getElementById('date-today').textContent = `Date du jour : ${jour}/${mois}/${annee}`;
  }

  function ajax(method, url, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, apiBase + url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = () => {
      if (xhr.readyState === 4 && xhr.status === 200) {
        callback(JSON.parse(xhr.responseText));
      }
    };
    xhr.send(data);
  }

  function chargerTypes() {
    ajax("GET", "/types", null, (data) => {
      const select = document.getElementById("type_pret_id");
      select.innerHTML = "";
      data.forEach(tp => {
        const assuranceTxt = tp.assurance != null ? `, Assurance ${tp.assurance}%` : "";
        const option = document.createElement("option");
        option.value = tp.id;
        option.dataset.taux = tp.taux / 100;
        option.dataset.assurance = tp.assurance ? tp.assurance / 100 : 0;
        option.textContent = `${tp.nom} (Taux ${tp.taux}%${assuranceTxt})`;
        select.appendChild(option);
      });
    });
  }

  let simulationData = null;

  function simulerTableau() {
    const montant = parseFloat(document.getElementById('montant').value);
    const duree = parseInt(document.getElementById('duree').value);
    const select = document.getElementById('type_pret_id');
    const t = parseFloat(select.options[select.selectedIndex].dataset.taux);
    const assuranceTaux = parseFloat(select.options[select.selectedIndex].dataset.assurance);
    const recapContainer = document.getElementById('recapitulatif');
    const container = document.getElementById('simulation-container');
    recapContainer.innerHTML = '';
    container.innerHTML = '';

    if (isNaN(duree) || duree < 1 || isNaN(montant)) {
      recapContainer.textContent = 'Veuillez saisir un montant et une durée valides.';
      return;
    }

    const mensualiteAssurance = montant * assuranceTaux;
    const numerator = t * Math.pow(1 + t, duree);
    const denominator = Math.pow(1 + t, duree) - 1;
    const annuite = montant * (numerator / denominator);
    const mensualiteTotale = annuite + mensualiteAssurance;

    simulationData = {
      montant,
      duree,
      t,
      assuranceTaux,
      annuite,
      mensualiteAssurance,
      mensualiteTotale
    };


    recapContainer.innerHTML = `
      <h3>Récapitulatif</h3>
      <p><strong>Capital emprunté :</strong> ${montant.toFixed(2)} Ar</p>
      <p><strong>Taux mensuel :</strong> ${(t * 100).toFixed(2)}%</p>
      <p><strong>Assurance mensuelle :</strong> ${(assuranceTaux * 100).toFixed(2)}%</p>
      <p><strong>Mensualité totale :</strong> ${mensualiteTotale.toFixed(2)} Ar</p>
      <p><strong>Total à rembourser :</strong> ${(mensualiteTotale * duree).toFixed(2)} Ar</p>
    `;
  }

  document.getElementById('btn-simuler').addEventListener('click', () => {
    const capital = parseFloat(document.getElementById('montant').value);
    const duree = parseInt(document.getElementById('duree').value);
    const select = document.getElementById('type_pret_id');
    const taux = parseFloat(select.options[select.selectedIndex].dataset.taux);
    const assurance = parseFloat(select.options[select.selectedIndex].dataset.assurance);

    if (!capital || !duree || !taux) {
      alert('Veuillez remplir tous les champs correctement');
      return;
    }

    fetch(apiBase + '/simulate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        capital: capital,
        taux: taux,
        duree: duree,
        assurance: assurance
      })
    })
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('simulation-container');
        container.innerHTML = '';

        // Affiche tableau
        const table = document.createElement('table');
        const header = `<tr>
            <th>Mois</th><th>Année</th><th>Capital début</th><th>Intérêt</th>
            <th>Amortissement</th><th>Assurance</th><th>Reste</th>
        </tr>`;
        table.innerHTML = header;

        data.tableau.forEach(row => {
          const tr = document.createElement('tr');
          tr.innerHTML = `
                <td>${row.mois}</td>
                <td>${row.annee}</td>
                <td>${row.capital_debut}</td>
                <td>${row.interet}</td>
                <td>${row.amortissement}</td>
                <td>${row.assurance}</td>
                <td>${row.reste}</td>
            `;
          table.appendChild(tr);
        });

        container.appendChild(table);
        const totalDiv = document.createElement('div');
        totalDiv.textContent = `Total à rembourser : ${data.total} Ar`;
        container.appendChild(totalDiv);
      })
      .catch(err => {
        alert('Erreur lors de la simulation');
        console.error(err);
      });
});


  document.addEventListener('DOMContentLoaded', () => {
    afficherDateDuJour();
    chargerTypes();
    document.getElementById('btn-simuler').addEventListener('click', simulerTableau);
  });

  document.getElementById('btn-valider').addEventListener('click', () => {
    const capital = parseFloat(document.getElementById('montant').value);
    const duree = parseInt(document.getElementById('duree').value);
    const select = document.getElementById('type_pret_id');
    const taux = parseFloat(select.options[select.selectedIndex].dataset.taux);
    const assurance = parseFloat(select.options[select.selectedIndex].dataset.assurance);

    if (!capital || !duree || !taux) {
      alert('Veuillez remplir tous les champs correctement');
      return;
    }

    fetch(apiBase + '/simulate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          capital: capital,
          taux: taux,
          duree: duree,
          assurance: assurance
        })
      })
      .then(res => res.json())
      .then(data => {
        const date = new Date();
        data.tableau.forEach(row => {
          date.setMonth(date.getMonth() + 1);
          const result = JSON.stringify({
            client_id: 1,
            mois: date,
            montant: row.interet
          });
          ajax("POST", "/interets", result, () => {});
          // alert('good');
        });
      })
      .catch(err => {
        alert('Erreur lors de la simulation');
        console.error(err);
      });
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
?>