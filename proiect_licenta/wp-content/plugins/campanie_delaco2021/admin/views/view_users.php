<?php

if (!class_exists('RegisteredUsers')) {
    require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/users-table.php');
}
?>

<div class="wrap">
    <h1>Registered users</h1>
    <br>
    <br>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2 class="handle ui-sortable-handle">Users list</h2>
                        <!-- extract button -->
                            <button type="submit" id="add-extraction-form" class=" ml-lg-2 btn btn-primary mb-lg-3 mt-lg-3" data-toggle="" data-target="">
                                Extrage castigatori
                            </button>
                       
                        <div class="inside">
                            <?php
                            $usersTable = new RegisteredUsers();
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