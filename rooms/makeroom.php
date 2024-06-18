<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "eden";
$port = 3306;

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_name = $_POST["room_name"];
    $room_number = $_POST["room_number"];
    $id_room = $_POST["id_room"];
    $capacity = $_POST["capacity"];
    $price = $_POST["price"];

    $sql = "INSERT INTO exhibit_rooms (room_name, room_number, id_room, capacity, price) 
            VALUES ('$room_name', '$room_number', '$id_room', '$capacity', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Quarto adicionado com successo!";

        header("Location: consultroom.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Eden</title>
        <link rel="stylesheet" href="makeroom.css" />
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
                    <form action="makeroom.php" method="post" style="margin-left: 200px;">
                        <h2>Formulário dos Quartos</h2>
                        <div class="form-group">
                            <label for="room_name">Nome do Quarto:</label>
                            <input type="text" name="room_name" id="room_name" placeholder="Digite o Nome do quarto"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="room_number">Número do quarto:</label>
                            <input type="text" name="room_number" id="room_number"
                                placeholder="Digite o Número do quarto" required>
                        </div>
                        <div class="form-group">
                            <label for="id_room">Tipo de Quarto</label>
                            <select name="id_room" id="id_room">
                                <option value="" disabled selected>Selecione o tipo de quarto</option>
                                <option id="1" value="1">Deluxe</option>
                                <option id="2" value="2">Suite</option>
                                <option id="3" value="3">Family</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="capacity">Capacidade:</label>
                            <input type="text" name="capacity" id="capacity" placeholder="Digite o limite de pessoas"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="price">Preço:</label>
                            <input type="text" name="price" id="price" placeholder="Digite o Preço" required>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>

        </div>

        </section>
        <script src="rooms.js"></script>

        </div>
    </body>

    </html>

</span>