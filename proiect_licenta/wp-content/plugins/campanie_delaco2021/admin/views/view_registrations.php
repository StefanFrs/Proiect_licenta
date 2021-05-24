<?php
//vezi rezervarea doar de la id-ul clientului respectiv
if (!class_exists('RegisteredReservations')) {
    require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/registrations-table.php');
}
?>

<div class="wrap">
    <h1>Registered reservations</h1>
    <br>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="hndle ui-sortable-handle">Registration list</h2>
                        <div class="inside">
                            <?php
                            $appointmentsTable = new RegisteredReservations();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $appointmentsTable->prepare_items();
                                $appointmentsTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>