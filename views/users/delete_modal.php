<div class="modal-overlay" id="deleteModal" hidden>
  <div class="delete-modal" role="dialog" aria-modal="true">
    <div class="warning-icon">!</div>

    <h2>¿Eliminar usuario?</h2>

    <p>
      Está a punto de eliminar al usuario
      <strong id="userToDelete"></strong>.
      Esta acción no se puede deshacer.
    </p>

    <div class="modal-actions">
      <button
        class="cancel-button"
        id="cancelDelete"
        type="button">
        Cancelar
      </button>
      <form action="index.php?controller=user&action=delete_user" name="deleteForm" id="deleteForm" method="post">
        <input type="hidden" name="id_user" id="id_user">
      </form>
      <button
        class="delete-button"

        type="submit"
        form="deleteForm">
        Eliminar usuario


      </button>

    </div>
  </div>
</div>