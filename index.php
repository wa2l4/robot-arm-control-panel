<?php
$conn = new mysqli("localhost", "root", "", "robot_arm");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$poses = $conn->query("SELECT * FROM robot_arm_status ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Robot Arm Control Panel</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        input[type=range] { width: 200px; }
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
        button { margin: 5px; padding: 5px 15px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Robot Arm Control Panel</h2>

    <?php for ($i = 1; $i <= 6; $i++): ?>
        Motor <?= $i ?>:
        <input type="range" id="m<?= $i ?>" min="0" max="180" value="90" oninput="updateValue(<?= $i ?>)">
        <span id="val<?= $i ?>">90</span><br>
    <?php endfor; ?>

    <br>
    <button onclick="reset()">Reset</button>
    <button onclick="savePose()">Save Pose</button>
    <button onclick="runPose()">Run</button>

    <br><br>
    <table id="posesTable">
        <tr>
            <th>#</th>
            <th>Motor 1</th><th>Motor 2</th><th>Motor 3</th>
            <th>Motor 4</th><th>Motor 5</th><th>Motor 6</th>
            <th>Action</th>
        </tr>
        <?php
        $counter = 1; 
        while($row = $poses->fetch_assoc()):
        ?>
            <tr>
                <td><?= $counter++ ?></td> 
                <?php for ($i = 1; $i <= 6; $i++): ?>
                    <td><?= htmlspecialchars($row["motor$i"]) ?></td>
                <?php endfor; ?>
                <td>
                    <button onclick="loadPose(<?= $row['id'] ?>)">Load</button>
                    <button onclick="removePose(<?= $row['id'] ?>)">Remove</button>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

<script>
function updateValue(id) {
    document.getElementById("val" + id).innerText = document.getElementById("m" + id).value;
}

function reset() {
    for (let i = 1; i <= 6; i++) {
        document.getElementById("m" + i).value = 90;
        document.getElementById("val" + i).innerText = 90;
    }
}

function savePose() {
    const motors = [];
    for (let i = 1; i <= 6; i++) {
        motors.push(parseInt(document.getElementById("m" + i).value));
    }
    fetch('save_pose.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({motors: motors})
    })
    .then(() => location.reload())
    .catch(() => {
        location.reload();
    });
}

function loadPose(id) {
    fetch('load_pose.php?id=' + id)
    .then(res => res.json())
    .then(data => {
        if (!data.error) {
            for (let i = 1; i <= 6; i++) {
                document.getElementById("m" + i).value = data["motor" + i];
                document.getElementById("val" + i).innerText = data["motor" + i];
            }
        }
    })
    .catch(() => {});
}

function removePose(id) {
    fetch('remove_pose.php?id=' + id)
    .then(() => location.reload())
    .catch(() => {
        location.reload();
    });
}

function runPose() {
    fetch('get_run_pose.php')
    .then(() => {})
    .catch(() => {});
}
</script>
</body>
</html>
