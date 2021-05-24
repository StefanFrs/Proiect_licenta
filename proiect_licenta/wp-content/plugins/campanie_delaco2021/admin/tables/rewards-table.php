<?php
//check if wp_list_table exists
if (!class_exists('WP_List_Table')) {
   require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class RegisteredRewards extends WP_List_Table
{
   /**
    * Retrieve rewards’s data from the database
    *
    */
   static function get_users($per_page = 10, $page_number = 1)
   {

      global $wpdb;

      $sql = "SELECT * FROM premii";

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
   function no_items()
   {
      _e('No customers avaliable.', 'sp');
   }

   /**
    *  Associative array of columns
    */
   function get_columns()
   {
      $columns = [
         'ID' =>'ID',
         'Nume_premiu'    => 'Nume_premiu',
         'Stoc'    => 'Stoc',
         'Descriere' => 'Descriere',
         'Imaginea'    => 'Imaginea',
         'Data_adaugarii'    => 'Data_adaugarii',
         'Editeaza' => 'Editeaza',
         'Sterge' => 'Sterge'
      ];

      return $columns;
   }
   /**
    * Returns the count of records in the database.
    */
   static function record_count()
   {
      global $wpdb;

      $sql = "SELECT COUNT(*) FROM premii";

      return $wpdb->get_var($sql);
   }

   /**
    * Handles data query and filter, sorting, and pagination.
    */
   function prepare_items()
   {

      $this->_column_headers = $this->get_column_info();


      $per_page     = $this->get_items_per_page('users_per_page', 10);
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

   function column_default($item, $column_name)
   {
      switch ($column_name) {
         case 'ID':
         case 'Nume_premiu':
         case 'Stoc':
         case 'Descriere':
         case 'Imaginea':
         case 'Data_adaugarii':
            return $item[$column_name];
         default:
            return print_r($item, true); //Show the whole array for troubleshooting purposes
      }
   }
   /**
    * Columns to make sortable.
    */
   function get_sortable_columns()
   {
      $sortable_columns = array(
         'ID' =>  array('ID', false),
         'Stoc' => array('Stoc', false)
        
      );

      return $sortable_columns;
   }

   function column_Imaginea($item){
      return "<a href='".$item['Imaginea']."'> Imagine </a>";
   }

   function column_Editeaza($item)
   {
      return "<a href='".admin_url('admin.php?page=edit_page&ID='.$item['ID'])."'> Editeaza </a>";
   }
   function column_Sterge($item)
   {
      return "<button type ='submit' class='btn btn-danger' style='padding:5px; font-size:15px;' id='delete-reward' data-reward-id='".$item['ID'] . "'>Sterge</button>";
   }
   
   function column_edit($item)
   {
   }
}