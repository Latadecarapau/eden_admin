<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eden";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'A-Z';

if (isset($_POST['delete'])) {
    $id_to_delete = $_POST['id_to_delete'];
    $sql_delete = "DELETE FROM exhibit_rooms WHERE room_number='$id_to_delete'";
    if ($conn->query($sql_delete) === TRUE) {
       
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


$sql = "SELECT * FROM exhibit_rooms INNER JOIN rooms on rooms.id_room = exhibit_rooms.id_room WHERE 1=1";


if (!empty($search)) {
    $sql .= " AND (room_name LIKE '%$search%' OR room_number LIKE '%$search%')";
}

if (!empty($category)) {
    $sql .= " AND id_room='$category'";
}

if ($sort == 'A-Z') {
    $sql .= " ORDER BY room_name ASC";
} else {
    $sql .= " ORDER BY room_name DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Eden</title>
    <link rel="stylesheet" href="consultroom.css" />
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
                <h1>Quartos</h1>
                <div class="search_bar" style="width: 1020px;">
                    <input type="search" id="search" placeholder="Pesquisa um Quarto em especifico..."
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
                    <button class="deleteButton" id="deleteButton">Apagar Quarto</button>
                </div>
                <div class="row">
                    <table>
                        <tr>
                            <th>Nome do Quarto</th>
                            <th>Número do Quarto</th>
                            <th>ID do Quarto</th>
                            <th>Capacidade</th>
                            <th>Preço</th>
                        </tr>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["room_name"] . "</td>";
                                echo "<td>" . $row["room_number"] . "</td>";
                                echo "<td>" . $row["type_of_room"] . "</td>";
                                echo "<td>" . $row["capacity"] . "</td>";
                                echo "<td>" . $row["price"] . "</td>";
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
                    <h2>Apagar Quarto</h2>
                    <form method="POST" action="">
                        <label for="id_to_delete">Digite o Número do Qaurto a eliminar:</label>
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
        <script src="rooms.js"></script>
    </div>
</body>
<?php
$conn->close();
?>

</html>