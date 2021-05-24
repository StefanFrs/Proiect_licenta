<?php

if (!function_exists('wp_handle_upload')) {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
}


function admin_scripts()
{
    //styles
    wp_enqueue_style('campanie-style-bootstrap', plugin_dir_url(__DIR__) . 'assets/css/bootstrap.min.css', array(), _S_VERSION);
    wp_enqueue_style('campanie-style-jquery1', plugin_dir_url(__DIR__) . 'assets/css/jquery-ui.css', array(), _S_VERSION);
    wp_style_add_data('campanie_delaco-style', 'rtl', 'replace');


    //scripts
    wp_enqueue_script('campanie-bootstrap-js', plugin_dir_url(__DIR__) . 'assets/js/bootstrap.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('campanie-jquery-ui', plugin_dir_url(__DIR__) . 'assets/js/jquery-ui.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('campanie-jquery-js1', plugin_dir_url(__DIR__) . 'assets/js/jquery-ui.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('campanie-jquery-js2', plugin_dir_url(__DIR__) . 'assets/js/jquery.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('campanie_delaco-navigation', plugin_dir_url(__DIR__) . 'assets/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('client-update-script', plugin_dir_url(__DIR__) . 'admin/views/rewards_update.js', array(), _S_VERSION, true);
}
add_action('admin_enqueue_scripts', 'admin_scripts');


function campanie_admin_menu_option()
{
    add_menu_page('Campanie', 'Campanie', 'manage_options', 'my-menu', 'campanie_scripts_page', 200); //main 
    add_submenu_page("my-menu", "Participanti", "Participanti", 'manage_options', 'participanti', 'users_page'); //submeniu users
    add_submenu_page("my-menu", "Premii", "Premii", 'manage_options', 'premii', 'rewards_page'); //submeniu premii
    add_submenu_page("my-menu", "Extrageri", "Extrageri", 'manage_options', 'extrageri', 'extraction_page'); //submeniu premii
    add_submenu_page(null, null, 'Vezi Inregistrari', 'manage_options', 'registrations_for_users', 'registrations_for_users'); //vezi inregistrari (pagina ascunsa)
    add_submenu_page(null, null, 'Vezi extrageri', 'manage_options', 'extractions_with_date', 'extractions_with_date'); //vezi extrageri in functie de data (pagina ascunsa)
    add_submenu_page(null, null, 'Edit', 'manage_options', 'edit_page', 'edit_page'); //edit page (pagina ascunsa)
}
add_action('admin_menu', 'campanie_admin_menu_option');

//edit rewards form

function edit_rewards_form_process()
{
    global $wpdb;

    $id_premiu = $_POST['ID'];
    $nameUpdated = $_POST['Nume_premiu'];
    $stockUpdated = $_POST['Stoc'];
    $descriptionUpdated = $_POST['Descriere'];
    $uploadedfile = $_FILES['Imaginea'];


    $upload_overrides = array(
        'test_form' => false
    );
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    $tableName = 'premii';
    $tableData = array(
        'Nume_premiu' => $nameUpdated,
        'Stoc' => $stockUpdated,
        "Imaginea" => $movefile['url'],
        'Descriere' => $descriptionUpdated
    );
    $tableWhere = array('ID' => $id_premiu);

    $saved = $wpdb->update($tableName, $tableData, $tableWhere);
    if ($saved) {
        echo "success";
    } else {
        echo "Modificarile nu au putut fi salvate!";
    }
    wp_die();
}
add_action('wp_ajax_edit_rewards_form_process', 'edit_rewards_form_process');
add_action('wp_ajax_nopriv_edit_rewards_form_process', 'edit_rewards_form_process');

//add rewards form

function add_rewards_form_process()
{
    global $wpdb;

    $id_client = $_POST['ID'];
    $nameUpdated = $_POST['Nume_premiu'];
    $stockUpdated = $_POST['Stoc'];
    $descriptionUpdated = $_POST['Descriere'];
    $uploadedfile = $_FILES['Imaginea'];

    $upload_overrides = array(
        'test_form' => false
    );
    $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

    $new_reward = $wpdb->insert('premii', array(
        'ID' => $id_client,
        'Nume_premiu' => $nameUpdated,
        "Imaginea" => $movefile['url'],
        'Stoc' => $stockUpdated,
        'Descriere' => $descriptionUpdated
    ));

    if ($new_reward) {
        echo "success";
    } else {
        echo "Nu s-a putut adauga premiul!";
    }

    wp_die();
}

add_action('wp_ajax_add_rewards_form_process', 'add_rewards_form_process');
add_action('wp_ajax_nopriv_add_rewards_form_process', 'add_rewards_form_process');

//add extraction picking

function add_extraction_form_process()
{
    global $wpdb;
   
    $result="SELECT * FROM registrations
    INNER JOIN users ON registrations.Id_client=users.Id_client
    WHERE registrations.Win=0 ORDER BY RAND() LIMIT 1";
    $extrageri=$wpdb->get_row($result,ARRAY_A);

    $new_winner = $wpdb->insert('extrageri', array(
        'ID_participant' => $extrageri['Id_client'],
        'Cod_castigator' => $extrageri['Cod']
       
    ));
    $update_win = $wpdb->update('registrations', array(
        'Win' => 1),
        array( 'Cod' => $extrageri['Cod'])
    );

    $to      = 'ferastauaru.ionut.stefan@gmail.com';
    $subject = 'Felicitari';
    $message = 'Sunteti fericitul castigator al extragerii noastre zilnice. Codul castigator este:' .$extrageri['Cod'];
    $headers = 'From: ferastauaru.ionut.stefan@gmail.com'       . "\r\n" .
                 'Reply-To: ferastauaru.ionut.stefan@gmail.com' . "\r\n" .
                 'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    if ($new_winner && $update_win) {
        echo "success";
    } else {
        echo "Extragerea nu s-a putut realiza!";
    }
    
    wp_die();
}

add_action('wp_ajax_add_extraction_form_process', 'add_extraction_form_process');
add_action('wp_ajax_nopriv_add_extraction_form_process', 'add_extraction_form_process');

function delete_reward_form_process()
{
    global $wpdb;
    $id_reward = $_POST['ID'];
    $deleted = $wpdb->delete('premii', array('ID' => $id_reward));
    if ($deleted) {
        echo "success";
    } else {
        echo "Nu s-a putut sterge premiul!";
    }
    wp_die();
}

add_action('wp_ajax_delete_reward_form_process', 'delete_reward_form_process');
add_action('wp_ajax_nopriv_delete_reward_form_process', 'delete_reward_form_process');


function users_page()
{
    include "views/view_users.php";
}
function registrations_for_users()
{
    include "views/view_registrations.php";
}

function rewards_page()
{
    include "views/view_rewards.php";
}

function edit_page()
{
    include "views/view_edit.php";
}
function extraction_page()
{
    include "views/view_extraction_page.php";
}
function extractions_with_date(){
    include "views/view_extraction_date.php";
}
//inner-join pentru legatura din tabele