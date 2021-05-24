<?php

require_once(WP_PLUGIN_DIR . '/campanie_delaco2021/admin/tables/rewards-table.php');
function registration_public_scripts()
{
    wp_register_script('registration-public-js', plugin_dir_url(__DIR__) . 'public/assets/js/public.js', array(), null, true);
    wp_register_script('registration-public-js_md5', plugin_dir_url(__DIR__) . 'public/assets/js/md5-script.js', array(), null, true);

    wp_localize_script('registration-public-js', 'params', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));

    wp_enqueue_script('registration-public-js');
}

add_action('wp_enqueue_scripts', 'registration_public_scripts');

//php forms required

function verify()
{
    $error = false;
    if (empty($_POST["Nume"])) {
        $error = true;
        return $error;
    } else {
        $Fname = test_input($_POST["Nume"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $Fname)) {
            $error = true;
            return $error;
            echo ("Introduceti un nume valid");
        }
    }

    if (empty($_POST["Prenume"])) {
        $error = true;
        return $error;
    } else {
        $Lname = test_input($_POST["Prenume"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $Lname)) {
            $error = true;
            return $error;
        }
    }

    if (empty($_POST["Email"])) {
        $error = true;
        return $error;
    }

    if (empty($_POST["Telefon"])) {
        $error = true;
        return $error;
    }

    if (empty($_POST["Oras"])) {
        $error = true;
        return $error;
    }
    echo $error;
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function contact_form_process()
{
    global $wpdb;
    // checking status of code
    $code_query = "SELECT status_cod FROM coduri WHERE Cod='$_POST[Cod]'";
    $code_query_results = $wpdb->get_row($code_query, ARRAY_A);
    //checking new user + adding to users table
    $phone_query = "SELECT Telefon FROM users WHERE Telefon = '$_POST[Telefon]'";
    $phone_query_results = $wpdb->get_row($phone_query, ARRAY_A);
    // validare forms php -> verificare coduri -> inseratul in tabel

    //checking new user on phone number + insert in db
    if (verify() == false) {

        if ($code_query_results['status_cod'] === '0') {
            //update status cod from "coduri" table
            $wpdb->update(
                "coduri",
                array(
                    "status_cod" => "1"
                ),
                array(
                    "Cod" => $_POST['Cod']
                )
            );
            //new user
            if ($phone_query_results == null) {
                $newUser = $wpdb->insert('users', array(
                    "Nume" => $_POST['Nume'],
                    "Prenume" => $_POST['Prenume'],
                    "Email" => $_POST['Email'],
                    "Telefon" => $_POST['Telefon'],
                    "Judet" => $_POST['Judet'],
                    "Oras" => $_POST['Oras'],
                    "Adresa" => $_POST['Adresa']
                ));
                $show_id_client = $wpdb->insert_id;
            } else {
                //user already exists
                $newId_client = "SELECT Id_client FROM users WHERE Telefon='$_POST[Telefon]'";
                $show_id_client = $wpdb->get_var($newId_client);
            }

            $results = $wpdb->insert(
                "registrations",
                array(

                    "Cod" => $_POST['Cod'],
                    "Id_client" => $show_id_client

                )
            );
            if ($results != false || $newUser != false) {

                echo ("success");
            } else {
                echo ("Database insert failed. Please try again.");
            }
        } else {
            echo ("exista erori in cazul codului");
        }
    } else {
        echo '<script>alert("Welcome to Nicesnippests")</script>';
    }
    wp_die();
}
add_action('wp_ajax_contact_form_process', 'contact_form_process');    // If called from admin panel
add_action('wp_ajax_nopriv_contact_form_process', 'contact_form_process');    // If called from front end



function contact_form()
{ ?>
    <div id="error"></div>
    <form id="contact-form" class="formular d-flex flex-column align-items-center">
        <input type="hidden" name="action" class="form_field mb-4" value="contact_form_process">
        <input type="text" id="Nume" name="Nume" class="form_field mb-4" placeholder="nume ">
        <input type="text" id="Prenume" name="Prenume" class="form_field mb-4" placeholder="prenume ">
        <input type="email" id="Email" name="Email" class="form_field mb-4" placeholder="email">
        <input type="text" id="Telefon" name="Telefon" class="form_field mb-4" placeholder="telefon">
        <select name="Judet" id="Judet" class="mb-4">
            <option value="AB">Alba</option>
            <option value="AG">Arges</option>
            <option value="AR">Arad</option>
            <option value="B">Bucuresti</option>
            <option value="BC">Bacau</option>
            <option value="BH">Bihor</option>
            <option value="BN">Bistrita</option>
            <option value="BR">Braila</option>
            <option value="BT">Botosani</option>
            <option value="BV">Brasov</option>
            <option value="BZ">Buzau</option>
            <option value="CJ">Cluj</option>
            <option value="CL">Calarasi</option>
            <option value="CS">Caras-Severin</option>
            <option value="CT">Constanta</option>
            <option value="CV">Covasna</option>
            <option value="DB">Dambovita</option>
            <option value="DJ">Dolj</option>
            <option value="GJ">Gorj</option>
            <option value="GL">Galati</option>
            <option value="GR">Giurgiu</option>
            <option value="HD">Hunedoara</option>
            <option value="HG">Harghita</option>
            <option value="IF">Ilfov</option>
            <option value="IL">Ialomita</option>
            <option value="IS">Iasi</option>
            <option value="MH">Mehedinti</option>
            <option value="MM">Maramures</option>
            <option value="MS">Mures</option>
            <option value="NT">Neamt</option>
            <option value="OT">Olt</option>
            <option value="PH">Prahova</option>
            <option value="SB">Sibiu</option>
            <option value="SJ">Salaj</option>
            <option value="SM">Satu-Mare</option>
            <option value="SV">Suceava</option>
            <option value="TL">Tulcea</option>
            <option value="TM">Timis</option>
            <option value="TR">Teleorman</option>
            <option value="VL">Valcea</option>
            <option value="VN">Vrancea</option>
            <option value="VS">Vaslui</option>
        </select>
        <input type="text" id="Oras" name="Oras" class="form_field mb-4" placeholder="oras">
        <input type="text" id="Adresa" name="Adresa" class="form_field mb-4" placeholder="adresa">
        <input type="text" id="Cod" name="Cod" class="form_field mb-4" placeholder="cod">
        <button type="submit" class="">Trimite</button>

    </form>
<?php }


// ##########################################  Winning form    ############################ 
function winning_code_process() {
    global $wpdb;

    $winningCode = $_GET['Cod_castigator'];

    $winCodeQuery = "SELECT Cod_castigator, Premiu_ales FROM extrageri WHERE Cod_castigator ='$winningCode'";
    $winCodeResult = $wpdb->get_row($winCodeQuery, ARRAY_A);

    if ($winCodeResult == null) {
        $saved = false;
    } else if($winCodeResult['Premiu_ales'] == "nu") {
        $saved = true;
    } else echo "The prize has already been chosen.\n";

    if ($saved) {
        echo "success";
    } else {
        echo "Database insert failed. Please try again.";
    }

    wp_die();
}
add_action('wp_ajax_winning_code_process', 'winning_code_process');
add_action('wp_ajax_nopriv_winning_code_process', 'winning_code_process');


function win_code_form() { ?>
    <form id="winning-code-form" method="post">
        <input type="hidden" name="action" value="winning_code_process">
        <!-- Codul promotional -->
        <div class="form-group col-md-6">
            <label for="input-win-code">*Winning Code:</label>
            <input type="text" class="form-control" id="input-win-code" name="input-win-code" placeholder="Codul promotional" required>
        </div>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
<?php }




// ##########################################  GET REWARD PROCESS+FORM   ############################

function choose_prize_process()
{
    global $wpdb;

    $prizeChoosen = $_POST['prize-choose']; //?
    $currentToken = $_POST['current-token']; // ?

    //verify if the winner choosed his prize
    $checkChooseQuery = "SELECT Premiu_ales FROM extrageri WHERE md5_code ='$currentToken'";
    $checkChooseResult = $wpdb->get_row($checkChooseQuery, ARRAY_A);

    //getting the actual stock
    $quantityCheckQuery = "SELECT Stoc FROM premii WHERE ID = '$prizeChoosen'";
    $quantityCheckResult = $wpdb->get_row($quantityCheckQuery, ARRAY_A);

    if($checkChooseResult['Premiu_ales'] == "nu") {
        $updated = $wpdb->update('premii', array(
            'stoc' => ($quantityCheckResult['stoc'] - 1),
        ), array(
            'ID' => $prizeChoosen,
        ));

        $updated = $wpdb->update('extrageri', array(
            'Premiu_ales' => 'da',
            'prize_id' => $prizeChoosen, // ?
        ), array(
            'md5_code' => $currentToken
        ));  
    } else echo "The prize has already been chosen.";
    
    if ($updated) {
        echo "success";
    } else {
        echo "Database insert failed. Please try again.";
    }

    wp_die();
  
}

add_action('wp_ajax_choose_prize_process', 'choose_prize_process');
add_action('wp_ajax_nopriv_choose_prize_process', 'choose_prize_process');

function get_reward_form()
{
    global $wpdb;

    //get all the prizes 
    $getPrizesQuery = "SELECT * FROM premii ORDER BY ID";
    $getPrizesResults = $wpdb->get_results($getPrizesQuery, ARRAY_A);
?>
    <form id="get_reward" method="post">
        <h1 class="text-center">Alegeti un premiu</h1>
        <input type="hidden" name="action" value="choose_prize_process">
        <div class="row justify-content-center">
            <?php
            foreach ($getPrizesResults as $result) {
                if ($result['Stoc'] != 0) {
            ?>
                <!-- more than 0 quantity = available prize -->
                    <input type="radio" class="sr-only" name="prize" id="<?php echo $result['ID'] ?>" value="<?php echo $result['ID'] ?>">
                    <label for="<?php echo $result['ID'] ?>" class="col-4 label-prize">
                        <img class="img-fluid" src="<?php echo $result['Imaginea'] ?>">
                        <p class="text-center"><?php echo $result['Nume_premiu'] ?></p>
                    </label>
                <?php } else { ?>
                <!-- 0 quantity = prize not available-->
                    <label class="col-4 grayscale">
                        <img class="img-fluid" src="<?php echo $result['Imaginea'] ?>">
                        <p class="text-center"><?php echo $result['Nume_premiu'] ?></p>
                    </label>
            <?php
                }
            }
            ?>
        </div> <!-- row -->
        <div class="text-center">
            <button type="submit" class="btn btn-warning">Choose the prize</button>
        </div>
    </form>
<?php
}




// Register a new shortcode: [cr_custom_registration]
add_shortcode('contact_form', 'custom_contact_form_shortcode');
add_shortcode('get_reward_form', 'custom_pick_reward_shortcode');
add_shortcode('win_code_form', 'custom_win_code_shortcode');

function custom_contact_form_shortcode()
{
    ob_start();
    contact_form();
    return ob_get_clean();
}

function custom_win_code_shortcode() {
    ob_start();
    win_code_form();
    return ob_get_clean();
}

function custom_pick_reward_shortcode()
{
    ob_start();
    get_reward_form();
    return ob_get_clean();
}

