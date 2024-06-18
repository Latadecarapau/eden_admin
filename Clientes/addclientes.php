<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require '../db_connection.php';

$errorMessages = array(
    "username" => "",
    "password" => "",
    "email" => "",
    "firstname" => "",
    "lastname" => "",
    "telephone" => "",
    "gender" => "",
    "image" => "",
    "phone_area" => ""
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : null;
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : null;
    $telephone = isset($_POST['telephone']) ? $_POST['telephone'] : null;
    $gender = isset($_POST['gender']) ? $_POST['gender'] : null;
    $phone_area = isset($_POST['phone_area']) ? $_POST['phone_area'] : null;

    $valid = true;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = dirname(__DIR__) . '/uploaded_files/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $image = $dest_path;
            } else {
                $valid = false;
                $errorMessages["image"] = 'There was some error moving the file to upload directory.';
            }
        } else {
            $valid = false;
            $errorMessages["image"] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
        }
    } else {
        $valid = false;
        $errorMessages["image"] = 'Error in file upload.';
    }

    if ($valid) {
        if ($username && $password && $email && $firstname && $lastname && $telephone && $gender && $image && $phone_area) {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, created_at, firstname, lastname, telephone, gender, image, phone_area) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $username, $password, $email, $firstname, $lastname, $telephone, $gender, $image, $phone_area);

            if ($stmt->execute()) {
                echo "New record created successfully";
                header("Location: ../Clientes/verclientes.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessages["form"] = "All fields are required.";
        }
    } else {
        echo "Validation failed.";
        var_dump($errorMessages);
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Eden</title>
    <link rel="stylesheet" href="addclientes.css" />
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
                    <li><a href="../Clientes/Mainclientes.php">
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
                <form action="addclientes.php" method="post" enctype="multipart/form-data" style="margin-left: 200px;">
                    <h2>Formulário das Reservas</h2>
                    <div class="form-group">
                        <label for="username">Nome de Usuário:</label>
                        <input type="text" name="username" id="username" placeholder="Digite o Nome de Usuário"
                            required>
                        <span class="error"><?php echo $errorMessages['username']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" id="password" placeholder="Digite a Senha" required>
                        <span class="error"><?php echo $errorMessages['password']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" placeholder="Digite o Email" required>
                        <span class="error"><?php echo $errorMessages['email']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="firstname">Primeiro Nome:</label>
                        <input type="text" name="firstname" id="firstname" placeholder="Digite o Primeiro Nome"
                            required>
                        <span class="error"><?php echo $errorMessages['firstname']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" name="lastname" id="lastname" placeholder="Digite o Sobrenome" required>
                        <span class="error"><?php echo $errorMessages['lastname']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="telephone">Telefone:</label>
                        <select id="phone_area" name="phone_area" required>
                            <option id="1" value="+1-USA">+1 (USA)</option>
                            <option id="2" value="+44-UK">+44 (UK)</option>
                            <option id="3" value="+91-INDIA">+91 (India)</option>
                            <option id="4" value="+61-AUS">+61 (Australia)</option>
                            <option id="5" value="+81-JAP">+81 (Japan)</option>
                            <option id="6" value="+351-PT">+351 (Portugal)</option>
                        </select>
                        <input type="text" name="telephone" id="telephone" placeholder="Digite o seu telefone" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gênero:</label>
                        <select name="gender" id="gender" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                        <span class="error"><?php echo $errorMessages['gender']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label>
                        <input type="file" name="image" id="image" required>
                        <span class="error"><?php echo $errorMessages['image']; ?></span>
                    </div>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </section>
    </div>
</body>

</html>