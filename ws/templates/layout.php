<?php
// layout.php : structure principale MVC avec includes
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title ?? 'Etablissement Financier'; ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <?php include __DIR__.'/header.php'; ?>
  <?php include __DIR__.'/sidebar.php'; ?>
  <div class="container">
    <main class="main-content">
      <?php echo $content ?? ''; ?>
    </main>
  </div>
  <?php include __DIR__.'/footer.php'; ?>
</body>
</html> 