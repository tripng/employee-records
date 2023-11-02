<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="<?= base_url('basicprimitives/css/primitives.css') ?>" media="screen" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">
    <title>Hello, world!</title>
  </head>
  <body>
    <?= $this->include('layout/navbar') ?>

    <div class="container-fluid">
        <?= $this->renderSection('content') ?>
    </div>

    <footer>
    
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="<?= base_url('/basicprimitives/dist/primitives.js') ?>"></script>
    <script src="<?= base_url('/js/app.js') ?>"></script>
  </body>
</html>