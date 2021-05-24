<?php

if (!class_exists('Extractions')) {
    require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/extractions-table.php');
}
?>

<div class="wrap">
    <h1>Extrageri</h1>
    <br>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <div class="inside">
                            <?php
                            $usersTable = new Extractions();
                            ?>

                            <form method="post" id="search">
                                <?php
                                $usersTable->prepare_items();
                                $usersTable->display(); ?>
                            </form>
                        </div>
                    </div>

                </div>
                <div id="advanced-sortables" class="meta-box-sortables ui-sortable"></div>
            </div>

        </div>
    </div>
</div>