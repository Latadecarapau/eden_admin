<?php
require '../db_connection.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'A-Z';

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];
    $sql_delete = "DELETE FROM reservations WHERE id_reservation='$id_to_delete'";
    if ($conn->query($sql_delete) === TRUE) {

    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
if (isset($_POST['modify'])) {
    $reservation_id = $_POST['reservation_select'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_phone = $_POST['new_phone'];

    // Formulate update query based on non-empty fields
    $updates = [];
    if (!empty($new_name))
        $updates[] = "name='$new_name'";
    if (!empty($new_email))
        $updates[] = "email='$new_email'";
    if (!empty($new_phone))
        $updates[] = "phone='$new_phone'";

    if (!empty($updates)) {
        $sql_modify = "UPDATE reservations SET " . implode(', ', $updates) . " WHERE id_reservation='$reservation_id'";
        if ($conn->query($sql_modify) !== TRUE) {
            echo "Error updating record: " . $conn->error;
        }
    }
}


$sql = "SELECT * FROM reservations inner join exhibit_rooms on reservations.room_number = exhibit_rooms.room_number inner join rooms on exhibit_rooms.id_room = rooms.id_room WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (name LIKE '%$search%' OR email LIKE '%$search%')";
}

if (!empty($category)) {
    $sql .= " AND type_of_room='$category'";
}

if ($sort == 'A-Z') {
    $sql .= " ORDER BY name ASC";
} else {
    $sql .= " ORDER BY name DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Eden</title>
    <link rel="stylesheet" href="Reservationverreservas.css" />
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <nav>
            <div class="navbar" style=" width: 170px;">
                <div class="logo">
                    <img src="../Login/imagens/Eden.png" alt="logo">
                    <h1>Eden</h1>
                </div>
                <ul>
                    <li><a href="../Dashboard/Dashboard.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Dashboard</span>
                        </a>
                    </li>
                    <li><a href="../addstaff/addstaff.php">
                            <i class="fas fa-user"></i>
                            <span class="nav-item">Add staff</span>
                        </a>
                    </li>
                    <li><a href="../rooms/mainroom.php">
                            <i class="fa-solid fa-person-booth"></i>
                            <span class="nav-item">Quartos</span>
                        </a>
                    </li>
                    <li><a href="../Reservations/Reservation.php">
                            <i class="fas fa-tasks"></i>
                            <span class="nav-item">Reservas</span>
                        </a>
                    </li>
                    <li><a href="../Clientes/mainclientes.php">
                            <i class="fa-solid fa-id-card-clip"></i>
                            <span class="nav-item">Clientes</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fa-solid fa-money-check"></i>
                            <span class="nav-item">Faturação</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fas fa-question-circle"></i>
                            <span class="nav-item">Ajuda</span>
                        </a>
                    </li>
                    <li><a href="#">
                            <i class="fa-solid fa-gear"></i>
                            <span class="nav-item">Opções</span>
                        </a>
                    </li>
                    <li><a href="#" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="nav-item">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="main">
            <div class="main-top">
                <p>Eden Dash</p>
            </div>
            <div class="main-body">
                <h1>Reservas</h1>
                <div class="search_bar" style="width: 1020px;">
                    <input type="search" id="search" placeholder="Pesquisa um pessoa em especifico..."
                        value="<?php echo $search; ?>">
                    <select name="category" id="category">
                        <option value="">Category</option>
                        <option value="suite" <?php if ($category == 'suite')
                            echo 'selected'; ?>>suite</option>
                        <option value="deluxe" <?php if ($category == 'deluxe')
                            echo 'selected'; ?>>deluxe</option>

                    </select>
                    <select id="sort">
                        <option value="A-Z" <?php if ($sort == 'A-Z')
                            echo 'selected'; ?>>A-Z</option>
                        <option value="Z-A" <?php if ($sort == 'Z-A')
                            echo 'selected'; ?>>Z-A</option>
                    </select>
                    <button class="deleteButton" id="deleteButton">Apagar</button>
                    <button class="modifyButton" id="modifyButton">Alterar</button>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <th>id_reserva</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Tipo de quarto</th>
                            <th>Número do quarto</th>
                            <th>Check in</th>
                            <th>Check out</th>
                            <th>Guests</th>
                            <th>Data da reserva</th>
                        </tr>
                        <?php

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id_reservation"] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["telephone"] . "</td>";
                                echo "<td>" . $row["type_of_room"] . "</td>";
                                echo "<td>" . $row["room_number"] . "</td>";
                                echo "<td>" . $row["check_in"] . "</td>";
                                echo "<td>" . $row["check_out"] . "</td>";
                                echo "<td>" . $row["num_guests"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>No results found</td></tr>";
                        }

                        ?>
                    </table>
                </div>
            </div>
        </section>
        <!-- Delete Modal -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Apagar Reserva</h2>
                <form method="POST" action="">
                    <label for="id_to_delete">Digite o ID de Reserva a eliminar:</label>
                    <input type="text" id="id_to_delete" name="id_to_delete" required>
                    <button type="submit" name="delete">Apagar</button>
                </form>
            </div>
        </div>

        <!-- Modify Modal -->
        <div id="modifyModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Modificar Reserva</h2>
                <form method="POST" action="">
                    <label for="reservation_select">Escolha a Reserva a modificar:</label>
                    <select id="reservation_select" name="reservation_select">
                        <?php
                        $result->data_seek(0); // Reset result set pointer
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row["id_reservation"] . "'>" . $row["name"] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <label for="new_name">Novo Nome:</label>
                    <input type="text" id="new_name" name="new_name">
                    <label for="new_email">Novo Email:</label>
                    <input type="email" id="new_email" name="new_email">
                    <label for="new_phone">Novo Telefone:</label>
                    <input type="text" id="new_phone" name="new_phone">
                    <button type="submit" name="modify">Modificar</button>
                </form>
            </div>
        </div>

        <script>
            var deleteModal = document.getElementById("deleteModal");
            var modifyModal = document.getElementById("modifyModal");

            var deleteBtn = document.getElementById("deleteButton");
            var modifyBtn = document.getElementById("modifyButton");

            var deleteSpan = deleteModal.getElementsByClassName("close")[0];
            var modifySpan = modifyModal.getElementsByClassName("close")[0];

            deleteBtn.onclick = function () {
                deleteModal.style.display = "block";
            }

            modifyBtn.onclick = function () {
                modifyModal.style.display = "block";
            }

            deleteSpan.onclick = function () {
                deleteModal.style.display = "none";
            }

            modifySpan.onclick = function () {
                modifyModal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == deleteModal) {
                    deleteModal.style.display = "none";
                } else if (event.target == modifyModal) {
                    modifyModal.style.display = "none";
                }
            }

        </script>
        <script src="Reservation.js"></script>
    </div>
</body>
<?php
$conn->close();
?>

</html>