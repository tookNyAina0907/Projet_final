<?php
$title = 'Intérêts gagnés';
ob_start();
?>

<section>
  <h2>Visualisation des intérêts gagnés</h2>

  <form id="filtre-form" style="display:flex; gap:1rem; align-items:end; margin-bottom:2rem; flex-wrap:wrap;">
    <div>
      <label for="debut">Mois/année début</label>
      <input type="month" id="debut" name="debut" required>
    </div>
    <div>
      <label for="fin">Mois/année fin</label>
      <input type="month" id="fin" name="fin" required>
    </div>
    <button class="btn" type="submit">Filtrer</button>
  </form>

  <table id="table-interets">
    <thead>
      <tr>
        <th>Mois</th>
        <th>Intérêts totaux (Ar)</th>
      </tr>
    </thead>
    <tbody>
      <tr><td colspan="2" style="text-align:center;">Aucun filtre appliqué</td></tr>
    </tbody>
  </table>

  <div style="margin-top:2rem;">
    <canvas id="chartInterets" height="100"></canvas>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const form = document.getElementById('filtre-form');
  const tbody = document.querySelector('#table-interets tbody');
  const ctx = document.getElementById('chartInterets').getContext('2d');
  let chart;

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    const debut = document.getElementById('debut').value;
    const fin = document.getElementById('fin').value;

    try {
      const res = await fetch(`/interets/filtre?debut=${debut}&fin=${fin}`);
      if (!res.ok) throw new Error("Erreur API");
      const data = await res.json();

      // ➤ Met à jour le tableau
      tbody.innerHTML = '';
      if (data.length === 0) {
        tbody.innerHTML = '<tr><td colspan="2" style="text-align:center;">Aucune donnée</td></tr>';
      } else {
        data.forEach(row => {
          const tr = document.createElement('tr');
          tr.innerHTML = `<td>${row.mois}</td><td>${parseFloat(row.total).toLocaleString()} Ar</td>`;
          tbody.appendChild(tr);
        });
      }

      // ➤ Met à jour le graphique
      const mois = data.map(item => item.mois);
      const valeurs = data.map(item => parseFloat(item.total));

      if (chart) chart.destroy();
      chart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: mois,
          datasets: [{
            label: 'Intérêts gagnés (Ar)',
            data: valeurs,
            backgroundColor: 'rgba(75, 192, 192, 0.6)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                callback: function(value) {
                  return value.toLocaleString() + ' Ar';
                }
              }
            }
          }
        }
      });

    } catch (err) {
      console.error(err);
      alert("Erreur lors du chargement des données.");
    }
  });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../templates/layout.php';
