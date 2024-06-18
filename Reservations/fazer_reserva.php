<?php
require '../db_connection.php';

$errorMessages = array(
    "name" => "",
    "telephone" => "",
    "type_of_room" => "",
    "room_number" => "",
    "check_in" => "",
    "check_out" => "",
    "num_guests" => "",
    "card_name" => "",
    "card_number" => "",
    "card_expiry" => "",
    "card_cvc" => ""
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['room_name']) ? $_POST['room_name'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
    $type_of_room = isset($_POST['id_room']) ? $_POST['id_room'] : null;
    $room_number = isset($_POST['capacity']) ? $_POST['capacity'] : null;
    $check_in = isset($_POST['check_in']) ? $_POST['check_in'] : null;
    $check_out = isset($_POST['check_out']) ? $_POST['check_out'] : null;
    $num_guests = isset($_POST['num_guests']) ? $_POST['num_guests'] : null;
    $card_name = isset($_POST['card_name']) ? $_POST['card_name'] : null;
    $card_number = isset($_POST['card_number']) ? $_POST['card_number'] : null;
    $card_expiry = isset($_POST['card_expiry']) ? $_POST['card_expiry'] : null;
    $card_cvc = isset($_POST['card_cvc']) ? $_POST['card_cvc'] : null;

    $valid = true;

    $current_date = new DateTime();
    $check_in_date = new DateTime($check_in);
    $check_out_date = new DateTime($check_out);

    if ($check_in_date < $current_date) {
        $errorMessages["check_in"] = "Check-in date cannot be earlier than today's date.";
        $valid = false;
    }

    if ($check_out_date <= $check_in_date) {
        $errorMessages["check_out"] = "Check-out date must be later than the check-in date.";
        $valid = false;
    }

    if ($valid) {
        if ($name && $email && $telephone && $type_of_room && $room_number && $check_in && $check_out && $num_guests && $card_name && $card_number && $card_expiry && $card_cvc) {
            $stmt = $conn->prepare("INSERT INTO reservations (name, email, telephone, room_number, check_in, check_out, num_guests, card_name, card_number, card_expiry, card_cvc, type_of_room, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("ssssssssssss", $name, $email, $telephone, $room_number, $check_in, $check_out, $num_guests, $card_name, $card_number, $card_expiry, $card_cvc, $type_of_room);

            if ($stmt->execute()) {
                header("Location: ../Reservations/Reservation.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessages["form"] = "All fields are required.";
        }
    }
}
$conn->close();
?>
<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Eden</title>
        <link rel="stylesheet" href="fazer_reserva.css" />
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
                                <span class="nav-item">Rooms</span>
                            </a>
                        </li>
                        <li><a href="../Reservations/Reservation.php">
                                <i class="fas fa-tasks"></i>
                                <span class="nav-item">Reservations</span>
                            </a>
                        </li>
                        <li><a href="../Clientes/mainclientes.php">
                                <i class="fa-solid fa-id-card-clip"></i>
                                <span class="nav-item">Clients</span>
                            </a>
                        </li>
                        <li><a href="#">
                                <i class="fa-solid fa-money-check"></i>
                                <span class="nav-item">Biling</span>
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
                    <form action="fazer_reserva.php" method="post" style="margin-left: 200px;">
                        <h2>Formulário das Reservas</h2>
                        <div class="form-group">
                            <label for="room_name">Nome do Cliente:</label>
                            <input type="text" name="room_name" id="room_name" placeholder="Digite o Nome do quarto"
                                required>
                            <span class="error"><?php echo $errorMessages['name']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="email">Email do Cliente:</label>
                            <input type="text" name="email" id="email" placeholder="Digite o Email" required>
                        </div>
                        <div class="form-group">
                            <label for="telephone">Telefone de cliente:</label>
                            <input type="tel" name="telephone" id="telephone" placeholder="Digite o Número de Telefone"
                                required>
                            <span class="error"><?php echo $errorMessages['telephone']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="id_room">Tipo do Quarto:</label>
                            <select id="id_room" name="id_room">
                                <option id="1" value="1">Suite</option>
                                <option id="2" value="2">Deluxe</option>
                                <option id="3" value="3">Family</option>
                            </select>
                            <span class="error"><?php echo $errorMessages['type_of_room']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="capacity">Número do Quarto:</label>
                            <input type="text" name="capacity" id="capacity" placeholder="Digite o Número do Quarto"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="check_in">Check-in:</label>
                            <input type="date" id="check_in" name="check_in" required>
                            <span class="error"><?php echo $errorMessages['check_in']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="check_out">Check-out:</label>
                            <input type="date" id="check_out" name="check_out" required>
                            <span class="error"><?php echo $errorMessages['check_out']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="num_guests">Número de Hóspedes:</label>
                            <input type="number" id="num_guests" name="num_guests" required>
                            <span class="error"><?php echo $errorMessages['num_guests']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="card_name">Nome do cartão:</label>
                            <input type="text" id="card_name" name="card_name" required>
                            <span class="error"><?php echo $errorMessages['card_name']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="card_number">Número do cartão:</label>
                            <input type="text" id="card_number" name="card_number" required>
                            <span class="error"><?php echo $errorMessages['card_number']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="card_expiry">Data de Expiração:</label>
                            <input type="month" id="card_expiry" name="card_expiry" required>
                            <span class="error"><?php echo $errorMessages['card_expiry']; ?></span>
                        </div>
                        <div class="form-group">
                            <label for="card_cvc">CVC:</label>
                            <input type="text" id="card_cvc" name="card_cvc" required>
                            <span class="error"><?php echo $errorMessages['card_cvc']; ?></span>
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