<?php



?>

<span style="font-family: verdana, geneva, sans-serif;">
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Eden</title>
        <link rel="stylesheet" href="Reservation.css" />
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
                    <div class="button-container">
                        <button class="button-container" onclick="location.href='fazer_reserva.php'">Fazer Reserva para um cliente</button>
                        <button class="button-container" onclick="location.href='ver_reservas.php'">Ver Reservas</button>
                        <button class="button-container" onclick="location.href='ver_quartos.php'">Ver Quartos Reservados</button>
                    </div>
                </div>

            </section>
            <script src="Reservation.js"></script>

        </div>
    </body>

    </html>

</span>