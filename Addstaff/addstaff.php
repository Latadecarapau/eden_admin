<?php

require '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $databirth = $_POST['databirth'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $codarea = $_POST['codarea'];
    $dataentry = $_POST['dataentry'];
    $perm = $_POST['perm'];
    $contract = isset($_POST['contract']) ? $_POST['contract'] : null;
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password

    $sql = "INSERT INTO staff (namestaff, databirth, phone, email, codarea, dataentry, perm, contract, userName, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $name, $databirth, $phone, $email, $codarea, $dataentry, $perm, $contract, $username, $password);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Eden</title>
        <link rel="stylesheet" href="addstaff.css" />
        <!-- Font Awesome Cdn Link -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
            integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>

    <body>
        <div class="container">
            <nav>
                <div class="navbar">
                    <div class="logo">
                        <img src="../Login/imagens/Eden.png" alt="">
                        <h1>Eden</h1>
                    </div>
                    <ul>
                        <li><a href="../dashboard/dashboard.php">
                                <i class="fas fa-user"></i>
                                <span class="nav-item">Dashboard</span>
                            </a>
                        </li>
                        <li><a href="#">
                                <i class="fas fa-user"></i>
                                <span class="nav-item">Add staff</span>
                            </a>
                        </li>
                        <li><a href="../rooms/mainroom.php">
                                <i class="fa-solid fa-person-booth"></i>
                                <span class="nav-item">Rooms</span>
                            </a>
                        </li>
                        <li><a href="#">
                                <i class="fas fa-tasks"></i>
                                <span class="nav-item">Reservations</span>
                            </a>
                        </li>
                        <li><a href="#">
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
                                <span class="nav-item">Help</span>
                            </a>
                        </li>
                        <li><a href="#">
                                <i class="fa-solid fa-gear"></i>
                                <span class="nav-item">Setting</span>
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
                    <form action="addstaff.php" method="post" style="margin-left: 200px;">
                        <h2>Staff Information Form</h2>
                        <div class="form-group">
                            <label for="name">Nome:</label>
                            <input type="text" name="name" id="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="databirth">Data de Nascimento:</label>
                            <input type="date" name="databirth" id="databirth" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Numero de telefone:</label>
                            <input type="text" name="phone" id="phone" placeholder="Enter your phone number">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="codarea">Codigo de Aréa</label>
                            <select name="codarea" id="codarea">
                                <option value="" disabled selected>Selecione o Cargo</option>
                                <option id="1" value="1">Limpeza</option>
                                <option id="2" value="2">Receção</option>
                                <option id="3" value="3">Superior</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dataentry">Data de entrada:</label>
                            <input type="date" name="dataentry" id="dataentry" required>
                        </div>
                        <div class="form-group">
                            <label for="perm">Efetividade</label>
                            <select name="perm" id="perm">
                                <option value="" disabled selected>Seleciona se efetivo ou não</option>
                                <option value="sim">Sim</option>
                                <option value="nao">Não</option>
                            </select>
                        </div>
                        <div class="form-group" id="contrato-group" style="display: none;">
                            <label for="contract">Contrato:</label>
                            <input type="text" name="contract" id="contract">
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" name="username" id="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" id="password" required>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>

            </section>




        </div>



    </body>

   
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var efetividadeSelect = document.getElementById('perm');
            var contratoGroup = document.getElementById('contrato-group');

            efetividadeSelect.addEventListener('change', function () {
                if (efetividadeSelect.value === 'nao') {
                    contratoGroup.style.display = 'block';
                } else {
                    contratoGroup.style.display = 'none';
                }
            });
        });
    </script>

    </html>
</span>