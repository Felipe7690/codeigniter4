<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Document</title>
</head>
<body>
    <h1><?= $titulo ?></h1>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th colspan="2">
                 <a href="#">
                    <i class="bi bi-plus-circle"></i>
                    Novo
                </a>
            </th>
        </tr>

        <?php 
        echo base_url();
        foreach($cidades as $value){
             ?>

        <tr>
            <td><?= $value['id'] ?></td>
            <td><?= $value['cidade'] ?></td>
            <td><?= $value['uf'] ?></td>
            <td><a href="#">
                    <i class="bi bi-pencil-square"></i>
                    Alterar
                </a></td>
            <td><a href="#">
                    <i class="bi bi-x-circle"></i>
                    Excluir
                </a></td>

        </tr>

        <?php } ?>

    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>