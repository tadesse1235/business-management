<?php
// Protect admin pages
if (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
    if (!isLoggedIn() || !isAdmin()) {
        redirect(BASE_URL . '/login.php');
    }
}

// Protect customer pages
if (strpos($_SERVER['PHP_SELF'], '/customer/') !== false) {
    if (!isLoggedIn() || !isCustomer()) {
        redirect(BASE_URL . '/login.php');
    }
}
?>