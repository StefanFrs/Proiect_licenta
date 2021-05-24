<?php

if (!class_exists('RegisteredRewards')) {
    require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/rewards-table.php');
}
?>


<!-- Main table -->
<div class="wrap">
    <h1>Premii</h1>
    <br>
    <div id="poststuff">
        <div id="post-body">

            <div id="postbox-container-2" class="postbox-container">
                <div id="normal-sortables" class="meta-box-sortables ui-sortable">

                    <div class="postbox">
                        <h2 class="handle ui-sortable-handle">Lista de premii</h2>
                        <!-- add rewards button-->
                        <button type="button" class=" ml-lg-2 btn btn-primary mt-lg-3" data-toggle="modal" data-target="#add-rewards">
                            Adaugă premiu
                        </button>
                        <div class="inside">
                            <?php
                            $usersTable = new RegisteredRewards();
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

<!-- MODAL FOR ADD REWARDS -->
<div class="modal fade" id="add-rewards" tabindex="-1" role="dialog" aria-labelledby="modal-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title-add-rewards">Adaugă premiu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-rewards-form" method="post">
          <input type="hidden" name="action" value="add_rewards_form_process">
          <div class="form-group row">
            <label class="col-2 offset-2 mr-lg-2" for="Nume_premiu">Nume premiu:</label>
            <input class="col-6 form-control" type="text" id="Nume_premiu" name="Nume_premiu" required>
          </div>
          <div class="form-group row">
            <label class="col-2 offset-2 mr-lg-2" for="Stoc">Stoc:</label>
            <input class="col-6 form-control" type="text" id="Stoc" name="Stoc" required>
          </div>
          <div class="form-group row">
            <label class="col-2 offset-2 mr-lg-2" for="Descriere">Descriere:</label>
            <input class="col-6 form-control " type="text" id="Descriere" name="Descriere">
          </div>
          <div class="form-group row">
            <label class="col-2 offset-2 mr-lg-2" for="Imaginea">Imaginea:</label>
            <input class="col-6 form-control " type="file" id="Imaginea" name="Imaginea">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add-rewards" class="btn btn-success">Adaugă</button>
          </div>
        </form>
      </div>
      <!--modal body -->
    </div>
    <!--modal content -->
  </div>
  <!--modal dialog -->
</div>