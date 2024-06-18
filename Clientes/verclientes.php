<?php
require '../db_connection.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'A-Z';

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];
    $sql_delete = "DELETE FROM users WHERE id='$id_to_delete'";
    if ($conn->query($sql_delete) === TRUE) {
       
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$sql = "SELECT * FROM users WHERE 1=1";


if (!empty($search)) {
    $sql .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}



if ($sort == 'A-Z') {
    $sql .= " ORDER BY id ASC";
} else {
    $sql .= " ORDER BY id DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Eden</title>
    <link rel="stylesheet" href="verclientes.css" />
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
                            <span class="nav-item">Billing</span>
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
                <h1>Clientes</h1>
                <div class="search_bar" style="width: 1020px;">
                    <input type="search" id="search" placeholder="Pesquisa um Cliente em especifico..."
                        value="<?php echo $search; ?>">
                    <select id="sort">
                        <option value="A-Z" <?php if ($sort == 'A-Z')
                            echo 'selected'; ?>>A-Z</option>
                        <option value="Z-A" <?php if ($sort == 'Z-A')
                            echo 'selected'; ?>>Z-A</option>
                    </select>
                    <button class="deleteButton" id="deleteButton">Apagar Cliente</button>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>UserName</th>
                            <th>Email</th>
                            <th>Primeiro Nome</th>
                            <th>Ultimo Nome</th>
                            <th>Género</th>
                            <th>Telefone</th>                      
                            <th>Área de telefone</th>
                            <th>Data de criação</th>
                        </tr>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["username"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["firstname"] . "</td>";
                                echo "<td>" . $row["lastname"] . "</td>";
                                echo "<td>" . $row["gender"] . "</td>";
                                echo "<td>" . $row["telephone"] . "</td>";
                                echo "<td>" . $row["phone_area"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No results found</td></tr>";
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
                    <h2>Apagar Cliente</h2>
                    <form method="POST" action="">
                        <label for="id_to_delete">Digite o id do Cliente a eliminar:</label>
                        <input type="text" id="id_to_delete" name="id_to_delete" required>
                        <button type="submit" name="delete">Apagar</button>
                    </form>
                </div>
            </div>

            <script>
                var modal = document.getElementById("deleteModal");
                var btn = document.getElementById("deleteButton");
                var span = document.getElementsByClassName("close")[0];
                btn.onclick = function () {
                    modal.style.display = "block";
                }


                span.onclick = function () {
                    modal.style.display = "none";
                }


                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            </script>
        <script src="Clientes.js"></script>
    </div>
</body>
<?php
$conn->close();
?>

</html>