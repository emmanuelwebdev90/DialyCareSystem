<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System</title>
    <link rel="stylesheet" href="./public/styles/main.css">
    <link rel="stylesheet" href="./public/styles/navbar.css">
    <link rel="stylesheet" href="./public/styles/forms.css">
</head>

<body>

    <!--Las barras de navegacion del sistema-->
    <nav class="navbar_d">
        <div class="content_navbar_d">
            <div class="navbar_logo_d">
                <img src="./public/images/logo.png" alt="Logo" class="logo">
                <strong>DialyCareSystem</strong>
            </div>
        </div>
    </nav>

    <!--Fin de las barras de navegacion del sistema-->
    <section class="title">
        <div class="content">
            <p class="form_title">Dtos de Paciente</p>
        </div>
    </section>

    <div class="grid">

        <section class="user_form">
            <div class="content">
                <div class="form-user-title">
                    <img src="./public/images/user_new.png" alt="user">
                    <p>Datos de la cuenta <?=  $nombre->nombre_completo ?></p>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="content">
                <form action="" id="user" method="post">
                    <input type="hidden" name="id_paciente" value="<?= $this->id_usuario ?>" id="id">

                    <div class="form-content">
                        <div class="group-controls">
                            <label for="fechaNacimiento">Fecha de Nacimiento *</label>
                            <div class="controls">
                                <i class="fa-solid fa-id-card-clip fa"></i>
                                <input required type="date" class="input" id="fechaNacimiento"  name="fecha_nacimiento">
                            </div>

                        </div>

                        <div class="group-controls">
                            <label for="tipoDialisis">Tipo de dialisis *</label>
                            <div class="controls">
                                <i class="fa-solid fa-id-card-clip fa"></i>
                                <input required type="text" class="input" id="tipoDialisis"  name="tipo_dialisis">
                            </div>

                        </div>

                        <div class="group-controls">
                            <label for="fechaTratamiento">Inicio del Tratamiento *</label>
                            <div class="controls">
                                <i class="fa-solid fa-id-card-clip fa"></i>
                                <input required type="date" class="input" id="fechaTratamiento"  name="fecha_inicio_tratamiento">
                            </div>

                        </div>

                        <div class="group-controls">
                            <label for="medico">Medico responsable *</label>
                            <div class="controls">
                                <i class="fa-solid fa-id-card-clip fa"></i>
                                <input required type="text" class="input" id="medico"  name="medico_responsable">
                            </div>

                        </div>

                       
                        
                            
                       
                     
                    </div>


                </form>
            </div>
        </section>
        <section class="action-form">
            <div class="content">
                 <button class="button-success" type="submit" form="user"> <i class="fa-solid fa-circle-user"></i> Registrar Pciente</button>
            </div>
            <?php if (isset($_REQUEST['message'])): ?>
                <br>
                <hr>
                <br>
                <div class="alert <?= $_REQUEST['cls']; ?>">
                    <?= ($_REQUEST['message']); ?>
                </div>
            <?php endif ?>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/415cf4c5ff.js" crossorigin="anonymous"></script>

</body>

</html>