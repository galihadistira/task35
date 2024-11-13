<?php

$conn = new mysqli('localhost', 'root', '', 'task35');  

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT nik, name FROM your_table";
$result = $conn->query($query);
$data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIK Form</title>
    <style>
        .error {
            color: red;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div>
        <form onsubmit="saveNIK(event)">
            <input type="text" name="nik" id="nik" placeholder="Masukkan NIK" required>
            <br>
            <input type="text" name="name" id="name" placeholder="Masukkan Nama" required>
            <br>
            <button type="submit">Simpan</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            $conn = new mysqli('localhost', 'root', '', 'task35');  
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT nik, name FROM your_table";
            $result = $conn->query($query);
            $data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

            if (!empty($data)) {
                $no = 1;
                foreach ($data as $row) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nik']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "</tr>";
                }
            } else {
                
            }
            ?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        function saveNIK(e) {
            e.preventDefault();

            const nik = document.getElementById('nik').value;
            const name = document.getElementById('name').value;

            axios.post('save-nik.php', { nik: nik, name: name })
                .then(function(response) {
                    const tableBody = document.getElementById('tableBody');
                    const data = response.data;

                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    const newRow = `
                        <tr>
                            <td>${tableBody.rows.length + 1}</td>
                            <td>${data.nik}</td>
                            <td>${data.name}</td>
                        </tr>
                    `;
                    tableBody.insertAdjacentHTML('beforeend', newRow);

                    document.getElementById('nik').value = '';
                    document.getElementById('name').value = '';
                })
                .catch(function(error) {
                    console.error("There was an error!", error);
                    alert("Failed to save data. Please try again.");
                });
        }
    </script>
</body>
</html>
