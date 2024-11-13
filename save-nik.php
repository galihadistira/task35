<?php
header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$nik = $input['nik'];
$name = $input['name'];

$conn = new mysqli('localhost', 'root', '', 'task35'); 
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

$query = "INSERT INTO message (nik, name) VALUES (?, ?)";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die(json_encode(['error' => 'Failed to prepare statement: ' . $conn->error]));
}

$stmt->bind_param("ss", $nik, $name);
if (!$stmt->execute()) {
    die(json_encode(['error' => 'Failed to execute statement: ' . $stmt->error]));
}

$id = $stmt->insert_id;

$response = [
    'id' => $id,
    'nik' => $nik,
    'name' => $name
];

echo json_encode($response);

$stmt->close();
$conn->close();
?>
