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
 * This file is part of the CP Framework for Wordpress. This one deals with 
 * the outputting of HTML for shortcodes and themes. 
 */

final class cpf_input_types {
    const Text = '<input type="text"';
    const Number = '<input type="number"';
    const Email = '<input type="email"';
    const Radio = '<input type="radio"';
    const Password = '<input type="password"';
    const Checkbox = '<input type="checkbox"';
    const Select = '<select>';

}

function cpf_html_ul($ul_class, $li_class, $items_array) {
    $result = '<ul class="' . $css_class . '">';
    foreach ($items_array as $item)
        $result = $result . '<li class="' . $li_class . '">' . $item . '</li>';

    $result = $result . '</ul>';
    return $result;
}

function cpf_html_img($src, $class, $alt) {
    return '<img src="' . $src . '" alt="' . $alt . '" class="' . $class . '"/>';
}

function cpf_html_input($name, $id, $type, $default_value) {
    $select_type = cpf_input_types::Select;
    if ($type !== $select_type)
        $result = $type . ' name="' . $name . '" id="' . $id . '"';
}

?>
