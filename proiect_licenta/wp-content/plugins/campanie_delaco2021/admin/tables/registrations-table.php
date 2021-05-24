<?php
//check if wp_list_table exists
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class RegisteredReservations extends WP_List_Table
{
    /**
     * Retrieve customer’s data from the database
     *
     */
    public static function get_users($per_page = 10, $page_number = 1)
    {

        global $wpdb;
        $id_client = $_GET['Id_client'];

        $sql = "SELECT * FROM registrations WHERE Id_client = $id_client";

        if (!empty($_REQUEST['orderby'])) {
            $sql .= ' ORDER BY ' . esc_sql($_REQUEST['orderby']);
            $sql .= !empty($_REQUEST['order']) ? ' ' . esc_sql($_REQUEST['order']) : ' ASC';
        }

        $sql .= " LIMIT $per_page";

        $sql .= ' OFFSET ' . ($page_number - 1) * $per_page;


        $result = $wpdb->get_results($sql, 'ARRAY_A');

        return $result;
    }
    /** Text displayed when no customer data is available */
    public function no_items()
    {
        _e('No customers avaliable.', 'sp');
    }


    /**
     *  Associative array of columns
     */
    function get_columns()
    {
        $columns = [
            'ID_inregistrare' => 'ID_inregistrare',
            'Cod'    => 'Cod',
            'Id_client' => 'Id_client'

        ];

        return $columns;
    }
    /**
     * Returns the count of records in the database.
     */
    public static function record_count()
    {
        global $wpdb;
        $id_client=$_GET['Id_client'];
        $sql = "SELECT COUNT(*) FROM registrations WHERE Id_client = $id_client";

        return $wpdb->get_var($sql);
    }

    /**
     * Handles data query and filter, sorting, and pagination.
     */
    public function prepare_items()
    {

        $this->_column_headers = $this->get_column_info();


        $per_page     = $this->get_items_per_page('reservations_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items  = self::record_count();

        $this->set_pagination_args([
            'total_items' => $total_items, //WE have to calculate the total number of items
            'per_page'    => $per_page //WE have to determine how many items to show on a page
        ]);
        $columns  = $this->get_columns();
        $hidden   = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items           = self::get_users($per_page, $current_page);
    }
    /**
     * Render a column when no column specific method exists.
     */
    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'ID_inregistrare':
            case 'Cod':
            case 'Id_client':
                return $item[$column_name];
            default:
                return print_r($item, true); //Show the whole array for troubleshooting purposes
        }
    }
    /**
     * Columns to make sortable.
     */
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'ID_inregistrare' =>  array('ID_inregistrare', false),
        );

        return $sortable_columns;
    }
}
