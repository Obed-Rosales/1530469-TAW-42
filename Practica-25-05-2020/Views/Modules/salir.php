<?php
    // Cierra la sesión actual y limpia la información asociada a la misma
    session_destroy();
    ob_end_flush();
?>