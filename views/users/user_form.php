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
            <p class="form_title">Alta y Registro de Usuario / Paciente</p>
        </div>
    </section>

    <div class="grid">

        <section class="user_form">
            <div class="content">
                <div class="form-user-title">
                    <img src="./public/images/user_new.png" alt="user">
                    <p>Datos de la cuenta de usuario</p>
                </div>
            </div>
            <br>
            <hr>
            <br>
            <div class="content">
                <form action="index.php?controller=user&action=create_user" id="user" method="post">
                    <div class="form-content">
                        <div class="group-controls">
                            <label for="fullName">Nombre completo *</label>
                            <div class="controls">
                                <i class="fa-solid fa-id-card-clip fa"></i>
                                <input required type="text" class="input" id="fullName" name="nombre_completo">
                            </div>

                        </div>

                        <div class="group-controls">
                            <label for="email">E-mail *</label>
                            <div class="controls">
                                <i class="fa-solid fa-envelope fa"></i>
                                <input type="email" id="email" " class='input' size=" 90" required name="email">
                            </div>

                        </div>
                        <div class="group-controls">
                            <label for="rol">Rol *</label>
                            <div class="controls">
                                <i class="fa-solid fa-address-card"></i>
                                <select required name="rol_id" class="input" id="rol_id">
                                    <option value="none" selected disabled hidden>Select an Option</option>
                                    <?php
                                    if (isset($roles)):
                                        foreach ($roles as $rol):
                                    ?>
                                            <option value="<?= $rol->id; ?>"><?= $rol->nombre; ?></option>
                                    <?php
                                        endforeach;
                                    endif ?>
                                </select>
                            </div>

                        </div>
                        <div class="controls-group">
                            <div class="group-controls">
                                <label for="passwordHash">Contraseña *</label>
                                <div class="controls">
                                    <i class="fa-solid fa-lock"></i>
                                    <input required type="password" class="input" id="passwordHash" name="password_hash">
                                </div>

                            </div>

                            <div class="group-controls">
                                <label for="password">Verifica Contraseña *</label>
                                <div class="controls">
                                    <i class="fa-solid fa-lock"></i>
                                    <input required type="password" class="input" id="pasword" name="password">
                                </div>

                            </div>
                        </div>
                        <div class="controls-group">
                            <div class="group-controls-radio activo">
                                <label>
                                    <input type="radio" name="activo" value="1" checked>
                                    <div>
                                        <p>Activo</p>
                                        <p class="legend">Permite inicio de de sesión y uso inmediato</p>
                                    </div>
                                    <div class="pill-radio-activo">
                                        <strong>Habilitado</strong>
                                    </div>
                                </label>
                            </div>

                            <div class="group-controls-radio">
                                <label>
                                    <input type="radio" name="activo" value="0">
                                    <div>
                                        <p>Inativo</p>
                                        <p class="legend">Cuenta pausada si acceso al sistema</p>
                                    </div>
                                    <div class="pill-radio-inactivo">
                                        <strong>Bloqueado</strong>
                                    </div>
                                </label>

                            </div>
                        </div>
                    </div>


                </form>
            </div>
        </section>
        <section class="action-form">
            <div class="content">
                <button class="button-success" type="submit" form="user">Registrar Usuario</button>
            </div>
            <?php if (isset($_REQUEST['message'])): ?>
                <br>
                <hr>
                <br>
                <div class="alert <?=$_REQUEST['cls'];?>">
                    <?= ($_REQUEST['message']); ?>
                </div>
            <?php endif ?>
        </section>
    </div>

    <script src="https://kit.fontawesome.com/415cf4c5ff.js" crossorigin="anonymous"></script>

</body>

</html>