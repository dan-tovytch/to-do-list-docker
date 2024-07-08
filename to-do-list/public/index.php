<?php
require '../database/database.php';

$db = new Database();
$pdo = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['task'])) {
        $task = $_POST['task'];
        $stmt = $pdo->prepare("INSERT INTO tarefas (tasks, status) VALUES (:tasks, 0)");
        $stmt->execute(['tasks' => $task]);
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    if (isset($_POST['toggle'])) {
        $id = $_POST['toggle'];
        $stmt = $pdo->prepare("UPDATE tarefas SET status = !status WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

$tasks = $pdo->query("SELECT * FROM tarefas")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">To-Do List</h3>
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="task" placeholder="Adicionar tarefa" required>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </div>
            </form>
            <ul class="list-group">
                <?php foreach ($tasks as $task) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span style="text-decoration: <?= $task['status'] ? 'line-through' : 'none'; ?>;">
                            <?= htmlspecialchars($task['tasks']) ?>
                        </span>
                        <div>
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="toggle" value="<?= $task['id'] ?>">
                                <button class="btn btn-secondary btn-sm"><?= $task['status'] ? 'Desfazer' : 'Completa' ?></button>
                            </form>
                            <form action="" method="POST" style="display: inline;">
                                <input type="hidden" name="delete" value="<?= $task['id'] ?>">
                                <button class="btn btn-danger btn-sm">Deletar</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>