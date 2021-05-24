<?php

if (!class_exists('RegisteredRewards')) {
    require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/rewards-table.php');
}
global $wpdb;

$id_premiu = $_GET['ID'];

$nameCurrentQuery = "SELECT Nume_premiu FROM premii WHERE ID='$id_premiu'";
$stocCurrentQuery = "SELECT Stoc FROM premii WHERE ID='$id_premiu'";
$descriereCurrentQuery = "SELECT Descriere FROM premii WHERE ID='$id_premiu'";
$imagineCurrentQuery = "SELECT Imaginea FROM premii WHERE ID='$id_premiu'";

$varNume_premiu = $wpdb->get_var($nameCurrentQuery);
$varStoc_premiu  = $wpdb->get_var($stocCurrentQuery);
$varDescriere_premiu = $wpdb->get_var($descriereCurrentQuery);
$varImagine_premiu = $wpdb->get_var($imagineCurrentQuery);
?>

<div class="wrap">
    <h1>Editeaza premiul</h1>
    <br>

    <form id="edit-reward-form" class="edit-formular d-flex flex-column align-items-start" method="post">
        <input type="hidden" name="action" value="edit_rewards_form_process">
        <input type="hidden" name="ID" value="<?= $id_premiu ?>">
        <label>Nume</label>
        <input type="text" id="Nume_premiu" name="Nume_premiu" class="form_field mb-4" value="<?= $varNume_premiu ?>">
        <label>Stoc</label>
        <input type="text" id="Stoc" name="Stoc" class="form_field mb-4" value="<?= $varStoc_premiu ?>">
        <label>Descriere</label>
        <input type="text" id="Descriere" name="Descriere" class="form_field mb-4" value="<?= $varDescriere_premiu ?>">
        <label> Imaginea:</label>
        <input class="col-6 form-control " type="file" id="Imaginea" name="Imaginea" value="<?= $varImagine_premiu ?>">

        <div class="form-group">
            <button type="submit" name="update-button" class="btn btn-primary">Actualizeaza</button>
        </div>

    </form>

</div>