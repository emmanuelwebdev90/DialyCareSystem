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
                            <td>
                                <div class="group_actions">
                                    <a href="index.php?controller=user&action=form_create_user&user=<?= $user->id ?>" class="edit"><i class="fa-solid fa-pen"></i></a>
                                    <a href="#" class="delete" onclick="openDeleteModal('<?= $user->id ?>','<?= $user->nombre_completo ?>', this)"><i class="fa-solid fa-trash-can"></i></a>
                                </div>


                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        <section class="action-form">
            <div class="content">
                <a class="button-success" href="index.php?controller=user&action=form_create_user"><i class="fa-solid fa-circle-user"></i>Registrar Usuario</a>
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
    <?php require_once('./views/users/delete_modal.php') ?>
    <script src="https://kit.fontawesome.com/415cf4c5ff.js" crossorigin="anonymous"></script>
    <script>
        const deleteModal = document.getElementById("deleteModal");
        const userToDelete = document.getElementById("userToDelete");
        const idUserToDelete = document.getElementById("id_user");
        const cancelDeleteButton = document.getElementById("cancelDelete");
        const confirmDeleteButton = document.getElementById("confirmDelete");

        let selectedUserButton = null;

        function openDeleteModal(id, userName, button) {
            selectedUserButton = button;
            userToDelete.textContent = userName;
            idUserToDelete.value = id;
            deleteModal.hidden = false;
            document.body.style.overflow = "hidden";
        }

        function closeDeleteModal() {
            deleteModal.hidden = true;
            document.body.style.overflow = "";
            selectedUserButton = null;
        }

        cancelDeleteButton.addEventListener("click", closeDeleteModal);

        confirmDeleteButton.addEventListener("click", function() {
            if (selectedUserButton) {
                const row = selectedUserButton.closest("tr");

                if (row) {
                    row.remove();
                }
            }

            closeDeleteModal();
        });

        // Cierra el modal al hacer clic fuera de su contenido
        deleteModal.addEventListener("click", function(event) {
            if (event.target === deleteModal) {
                closeDeleteModal();
            }
        });

        // Permite cerrar el modal con la tecla Escape
        document.addEventListener("keydown", function(event) {
            if (event.key === "Escape" && !deleteModal.hidden) {
                closeDeleteModal();
            }
        });
    </script>
</body>

</html>