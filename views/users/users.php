<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System</title>
    <link rel="stylesheet" href="./public/styles/main.css">
    <link rel="stylesheet" href="./public/styles/navbar.css">
    <link rel="stylesheet" href="./public/styles/forms.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            /*border: 2px solid rgb(140 140 140);*/
            border-radius: 12px;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        caption {
            caption-side: bottom;
            padding: 10px;
            font-weight: bold;
        }

        thead,
        tfoot {
            background-color: #EFF4FF;
        }

        thead th {
            padding: 14px 16px;

        }

        td {
            /*border: 1px solid rgb(160 160 160);
            */
            padding: 8px 10px;
        }

        td:last-of-type {
            text-align: center;
        }

        tbody>tr:hover {
            background-color: #EFF4FF;
        }

        tfoot th {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
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
            <p class="form_title">Directorio Usuarios</p>
        </div>
    </section>

    <div class="grid">

        <section class="user_table">
            <table>
                <thead>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    <?php foreach ($users as $user):
                        $getRol = $roles->readById($user->rol_id);
                        $rol_name = '';
                        if ($getRol->nombre == 'admin'):
                            $rol_name = 'Administrador';
                        else:
                            $rol_name = 'Paciente';
                        endif;
                    ?>

                        <tr>
                            <th><?= $user->nombre_completo ?></th>
                            <td><?= $user->email ?></td>
                            <td>
                                <div class="pill-radio-info">
                                    <?= $rol_name ?>
                                </div>

                            </td>
                            <td>
                                <div class=" <?= $user->activo == 1 ? 'pill-radio-activo' : 'pill-radio-inactivo'; ?>">
                                    <?= $user->activo == 1 ? 'Activo' : 'Inactivo'; ?>
                                </div>

                            </td>
                            <td></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section class="action-form">
            <div class="content">
                <a class="button-success" href="index.php?controller=user&action=form_create_user">Registrar Usuario</a>
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