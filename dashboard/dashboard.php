<?php
require '../db_connection.php';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'A-Z';

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];
    $sql_delete = "DELETE FROM staff WHERE id_staff='$id_to_delete'";
    if ($conn->query($sql_delete) === TRUE) {

    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
if (isset($_POST['modify'])) {
    $staff_id = $_POST['staff_select'];
    $new_name = $_POST['new_name'];
    $new_email = $_POST['new_email'];
    $new_phone = $_POST['new_phone'];

    $updates = [];
    if (!empty($new_name))
        $updates[] = "namestaff='$new_name'";
    if (!empty($new_email))
        $updates[] = "email='$new_email'";
    if (!empty($new_phone))
        $updates[] = "phone='$new_phone'";

    if (!empty($updates)) {
        $sql_modify = "UPDATE staff SET " . implode(', ', $updates) . " WHERE id_staff='$staff_id'";
        if ($conn->query($sql_modify) !== TRUE) {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$sql = "SELECT * FROM staff INNER JOIN cargos on cargos.codarea = staff.codarea WHERE 1=1";

if (!empty($search)) {
    $sql .= " AND (namestaff LIKE '%$search%' OR userName LIKE '%$search%')";
}

if (!empty($category)) {
    $sql .= " AND codarea='$category'";
}

if ($sort == 'A-Z') {
    $sql .= " ORDER BY namestaff ASC";
} else {
    $sql .= " ORDER BY namestaff DESC";
}

$result = $conn->query($sql);

?>

<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Eden</title>
        <link rel="stylesheet" href="dashboard.css" />
        <!-- Font Awesome Cdn Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <div class="container">
            <nav>
                <div class="navbar" style="width: 170px;">
                    <div class="logo">
                        <img src="../Login/imagens/Eden.png" alt="logo">
                        <h1>Eden</h1>
                    </div>
                    <ul>
                        <li><a href="#">
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
                    <h1>Staff</h1>
                    <div class="search_bar" style="width: 1020px;">
                        <input type="search" id="search" placeholder="Pesquisa um pessoa em especifico..."
                            value="<?php echo $search; ?>">
                        <select name="category" id="category">
                            <option value="">Category</option>
                            <option value="Receção" <?php if ($category == 'Receção')
                                echo 'selected'; ?>>Receção</option>
                            <option value="Bar" <?php if ($category == 'Bar')
                                echo 'selected'; ?>>Bar</option>
                            <option value="Restaurante" <?php if ($category == 'Restaurante')
                                echo 'selected'; ?>>
                                Restaurante
                            </option>
                            <option value="Limpezas" <?php if ($category == 'Limpezas')
                                echo 'selected'; ?>>Limpezas
                            </option>
                            <option value="Segurança" <?php if ($category == 'Segurança')
                                echo 'selected'; ?>>Segurança
                            </option>
                            <option value="Superior" <?php if ($category == 'Superior')
                                echo 'selected'; ?>>Superior
                            </option>
                        </select>
                        <select id="sort">
                            <option value="A-Z" <?php if ($sort == 'A-Z')
                                echo 'selected'; ?>>A-Z</option>
                            <option value="Z-A" <?php if ($sort == 'Z-A')
                                echo 'selected'; ?>>Z-A</option>
                        </select>
                        <button class="deleteButton" id="deleteButton">Apagar </button>
                        <button class="modifyButton" id="modifyButton">Alterar </button>
                    </div>

                    <div class="row">
                        <table>
                            <tr>
                                <th>ID</th>
                                <th>Área</th>
                                <th>Nome</th>
                                <th>Data Nasc</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Contract</th>
                                <th>Data de Entrada</th>
                                <th>Efetividade</th>
                                <th>Username</th>
                            </tr>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id_staff"] . "</td>";
                                    echo "<td>" . $row["area"] . "</td>";
                                    echo "<td>" . $row["namestaff"] . "</td>";
                                    echo "<td>" . $row["databirth"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["phone"] . "</td>";
                                    echo "<td>" . $row["contract"] . "</td>";
                                    echo "<td>" . $row["dataentry"] . "</td>";
                                    echo "<td>" . $row["perm"] . "</td>";
                                    echo "<td>" . $row["userName"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>No results found</td></tr>";
                            }
                            ?>
                        </table>
                        <a href="#">See all</a>
                    </div>
                </div>
            </section>

            <!-- Delete Modal -->
            <div id="deleteModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Apagar Membro Staff</h2>
                    <form method="POST" action="">
                        <label for="id_to_delete">Digite o ID do Staff a apagar:</label>
                        <input type="text" id="id_to_delete" name="id_to_delete" required>
                        <button type="submit" name="delete">Apagar</button>
                    </form>
                </div>
            </div>

            <!-- Modify Modal -->
            <div id="modifyModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Modificar Membro Staff</h2>
                    <form method="POST" action="">
                        <label for="staff_select">Escolha o Staff a modificar:</label>
                        <select id="staff_select" name="staff_select">
                            <?php
                            $result->data_seek(0); // Reset result set pointer
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["id_staff"] . "'>" . $row["namestaff"] . "</option>";
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
                // Get the modals
                var deleteModal = document.getElementById("deleteModal");
                var modifyModal = document.getElementById("modifyModal");

                // Get the buttons that open the modals
                var deleteBtn = document.getElementById("deleteButton");
                var modifyBtn = document.getElementById("modifyButton");

                // Get the <span> elements that close the modals
                var deleteSpan = deleteModal.getElementsByClassName("close")[0];
                var modifySpan = modifyModal.getElementsByClassName("close")[0];

                // When the user clicks the button, open the corresponding modal
                deleteBtn.onclick = function () {
                    deleteModal.style.display = "block";
                }

                modifyBtn.onclick = function () {
                    modifyModal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the corresponding modal
                deleteSpan.onclick = function () {
                    deleteModal.style.display = "none";
                }

                modifySpan.onclick = function () {
                    modifyModal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == deleteModal) {
                        deleteModal.style.display = "none";
                    } else if (event.target == modifyModal) {
                        modifyModal.style.display = "none";
                    }
                }

            </script>

        </div>
    </body>

    </html>
    <?php
    $conn->close();
    ?>
</span>