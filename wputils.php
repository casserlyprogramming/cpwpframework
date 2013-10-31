<?php

/*    ######   ########
 * #########   #########
 * ####        ####   ####
 * ####        #########   
 * ####        #######
 * ####        ####            
 * #########   ####
 *    ######   ####
 * 
 * This adds common functionality to Wordpress Themes and Shortcodes for use in 
 * the framework
 */


/*
 * Menu positions in the wordpress admin menu by default...
  5 - below Posts
  10 - below Media
  15 - below Links
  20 - below Pages
  25 - below comments
  60 - below first separator
  65 - below Plugins
  70 - below Users
  75 - below Tools
  80 - below Settings
  100 - below second separator
 */

function cpf_add_admin_menu_seperator() {
    global $menu;
    $index = 0;
    $cpcommerce = CPCommerce::Instance();
    foreach ($menu as $offset => $section) {
        if (substr($section[2], 0, 9) == 'separator')
            $index++;

        extract($cpcommerce->menu_seperation_indices());
        foreach ($cpcommerce->menu_seperation_indices() as $idx) {
            if ($offset >= $idx) {
                $menu[$idx] = array('', 'read', "separator{$index}", '', 'wp-menu-separator');
            }
        }
    }
    ksort($menu);
}

//--------------------------------------------------------------
//Create an admin field
//--------------------------------------------------------------
// Add Status Page
class CP_CustomTaxField {

    public function __construct() {
        
    }

    public $option_array_name;

    public function cpf_add_custom_field_html($field_type, $label_name, $default_value, $description) {
        if($this->$option_array_name === null)
            return '';
        // This will add the Priority to the "add new" form...
        $result = '<div class="form-field">
                   <label for="term_meta[' . $this->$option_array_name . ']">
                   ' . $label_name .  
                   '</label>
                <select name="term_meta[' . $this->$option_array_name . ']">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
		<p class="description">' . $description . '</p>
	</div>';
        return $result;
    }    
}

add_action( 'cp_ticket_status_add_form_fields', 'add_status_custom_fields');

// Edit term page
function cpf_edit_status_custom_fields($term) {
 
	// put the term ID into a variable
	$t_id = $term->term_id;
 
	// retrieve the existing value(s) for this meta field. This returns an array
	$term_meta = get_option( "status_$t_id" ); ?>
	<tr class="form-field">
	<th scope="row" valign="top"><label for="term_meta[status_priority]">Priority</label></th>
		<td>
                <select name="term_meta[status_priority]">
                    <option value="High" <?php echo esc_attr( $term_meta['status_priority']) == 'High' ? 'selected' : '' ?>>High</option>
                    <option value="Medium" <?php echo esc_attr( $term_meta['status_priority']) == 'Medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="Low" <?php echo esc_attr( $term_meta['status_priority']) == 'Low' ? 'selected' : '' ?>>Low</option>
                </select>
		<p class="description">What priority should this Status Take?</p>
		</td>
	</tr>
        <tr class="form-field">            
            <th scope="row" valign="top">                
              <label for="term_meta[status_isclosed]">Is Closed?</label>
            </th>
            <td>
                <select name="term_meta[status_isclosed]">
                    <option value="Yes" <?php echo esc_attr( $term_meta['status_isclosed']) == 'Yes' ? 'selected' : '' ?>>Yes</option>
                    <option value="No" <?php echo esc_attr( $term_meta['status_isclosed']) == 'No' ? 'selected' : '' ?>>No</option>
                </select>
                <p class="description">Does this signify that the Status is Closed?</p>
            </td>
        </tr>
<?php
}
add_action( 'cp_ticket_status_edit_form_fields', 'edit_status_custom_fields');
// Save the Status fields....
function cpf_save_status_fields( $term_id ) {
	if ( isset( $_POST['term_meta'] ) ) {
		$t_id = $term_id;
		$term_meta = get_option( "status_$t_id" );
		$cat_keys = array_keys( $_POST['term_meta'] );
		foreach ( $cat_keys as $key ) {
			if ( isset ( $_POST['term_meta'][$key] ) ) {
				$term_meta[$key] = $_POST['term_meta'][$key];
			}
		}
		// Save the option array.
		update_option( "status_$t_id", $term_meta );
	}
}  
add_action( 'edited_cp_ticket_status', 'save_status_fields');  
add_action( 'create_cp_ticket_status', 'save_status_fields');

?>
