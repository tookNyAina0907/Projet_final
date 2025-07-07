<?php
$title = 'Gestion des types de prêts';
ob_start();
?>
<section>
  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
    <h2>Types de prêts</h2>
  </div>
  <table>
    <thead>
      <tr>
        <th>Nom</th>
        <th>Taux mensuel (%)</th>
        <th>Assurance (%)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="types-body">
      <!-- Les lignes seront générées dynamiquement ici -->
    </tbody>
  </table>

  <h3 style="margin-top: 2rem;">Ajouter / Modifier un type de prêt</h3>
  <form id="type-form" style="display:grid; grid-template-columns:repeat(4,1fr) 1fr; gap:1rem; align-items:end;">
    <input type="hidden" id="id">
    <div>
      <label>Nom</label>
      <input type="text" id="nom" required>
    </div>
    <div>
      <label>Taux mensuel (%)</label>
      <input type="number" id="taux" step="0.01" min="0" required>
    </div>
    <div>
      <label>Assurance (%)</label>
      <input type="number" id="assurance" step="0.01" min="0">
    </div>
    <button class="btn" type="submit">Ajouter</button>
  </form>
</section>

<script>
  const apiBase = "http://localhost/Projet_final/ws";

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
      const tbody = document.getElementById("types-body");
      tbody.innerHTML = "";
      data.forEach(type => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${type.nom}</td>
          <td>${type.taux}</td>
          <td>${type.assurance !== null ? type.assurance : ''}</td>
          <td class="table-actions">
            <a class="btn" href="#" style="background:var(--accent);" onclick='remplirFormulaire(${JSON.stringify(type)})'>Modifier</a>
            <a class="btn" href="#" style="background:var(--danger);" onclick='supprimerType(${type.id})'>Supprimer</a>
          </td>
        `;
        tbody.appendChild(tr);
      });
    });
  }

  function remplirFormulaire(type) {
    document.getElementById("id").value = type.id;
    document.getElementById("nom").value = type.nom;
    document.getElementById("taux").value = type.taux;
    document.getElementById("assurance").value = type.assurance ?? "";
    document.querySelector("#type-form button").textContent = "Modifier";
  }

  function supprimerType(id) {
    if (confirm("Supprimer ce type de prêt ?")) {
      ajax("DELETE", `/types/${id}`, null, () => {
        chargerTypes();
        resetForm();
      });
    }
  }

  function resetForm() {
    document.getElementById("id").value = "";
    document.getElementById("nom").value = "";
    document.getElementById("taux").value = "";
    document.getElementById("assurance").value = "";
    document.querySelector("#type-form button").textContent = "Ajouter";
  }

  document.getElementById("type-form").addEventListener("submit", function (e) {
    e.preventDefault();

    const id = document.getElementById("id").value;
    const nom = document.getElementById("nom").value;
    const taux = parseFloat(document.getElementById("taux").value);
    const assuranceInput = document.getElementById("assurance").value;
    const assurance = assuranceInput === "" ? null : parseFloat(assuranceInput);

    const data = JSON.stringify({ nom, taux, assurance });

    if (id) {
      ajax("PUT", `/types/${id}`, data, () => {
        chargerTypes();
        resetForm();
      });
    } else {
      ajax("POST", "/types", data, () => {
        chargerTypes();
        resetForm();
      });
    }
  });

  chargerTypes();
</script>
<?php
$content = ob_get_clean();
include __DIR__.'/../templates/layout.php';
