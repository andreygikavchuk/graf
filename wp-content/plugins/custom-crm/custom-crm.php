<?php
/**
 *
 * Plugin Name: Custom CRM
 * Description: Yet another CRM
 * Text Domain: custom-crm
 * Version: 0.0.1
 */


function custom_crm_is_ajax()
{
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        return true;
    }
    return false;
}

function custom_crm_run()
{

    if (isset($_GET['action']) && ($_GET['action'] == 'mailing') && isset($_GET['post']) && !empty($_GET['post']) && !custom_crm_is_ajax()) {
        $ids = array_values($_GET['post']);
        $posts = get_posts(['ID' => $ids, 'post_type' => 'crm_record']);
        $message = false;
        if (isset($_GET['mailing_result'])) {
            if ($_GET['mailing_result']) {
                $message = 'Рассылка отправлена';
                $message_type = 'success';
            } else {
                $message = 'Ошибка отправки';
                $message_type = 'warning';
            }
        }
        require_once 'mailing.php';
        die;
    }
    if (isset($_POST['crm_mail']) && is_array($_POST['crm_mail'])) {

        $data = $_POST['crm_mail'];
        $subject = $data['subject'];
        $text = nl2br($data['text']);
        $sender = $data['from'];
        $to = array_unique(array_values($data['email']));

        $headers = "From: $sender\n" .
            "Content-Type: text/html\n";

        $uploaded_files = [];

        $upload_dir = get_temp_dir();
        if (isset($_FILES['crm_mail'])) {
            $files = $_FILES['crm_mail'];

            foreach ($files['name']['files'] as $key => $file_name) {

                $upload_file = $upload_dir . basename($file_name);

                if (move_uploaded_file($files['tmp_name']['files'][$key], $upload_file)) {
                    $uploaded_files[] = $upload_file;
                }
            }
        }


        $result = wp_mail($to, $subject, $text, $headers, $uploaded_files);

        wp_redirect('/wp-admin/edit.php?post_type=crm_record&action=mailing&_wpnonce=' .
            wp_create_nonce('mailing') . '&_wp_http_referer=' . wp_get_referer() . '&mailing_result=' . $result);

        foreach ($uploaded_files as $file) {
            unlink($file);
        }


        die;
    }
}


function custom_crm_save_wpcf7_data($cf7)
{
    $data = custom_crm_get_data_form_post($_POST);

    custom_crm_create_record($data, $cf7->title);

    return true;
}

function custom_crm_create_record($data, $form_title)
{


    $title = '';

    if (isset($data['surname'])) {
        $title .= ($data['surname']) . ' ';
    }
    if (isset($data['name'])) {
        $title .= $data['name'];
    }

//    if (isset($data['name'])) {
//        wp_mail($data['email'], 'КЛУБНЬІЙ ДОМ GRAF "[Форма обратной связи]"', 'Вы заполнили форму обратной связи');
//    }
//    if (isset($data['text2'])) {
//        wp_mail($data['email'], 'КЛУБНЬІЙ ДОМ GRAF "[Подписка на новости]"', 'Вы подписались на  рассылку новостей о Клубном Доме Graf.');
//
//    }

    $id = wp_insert_post([
        'post_title' => $title,
        'post_type' => 'crm_record',
        'post_status' => 'publish',
    ]);

    if (isset($data['entity_name'])) {
        $form_title .= ' ' . $data['entity_name'];
        unset($data['entity_name']);
    }

    $data['request_type'] = $form_title;

    foreach ($data as $name => $value) {
        update_field($name, $value, $id);
    }
    $fields = array_diff(custom_crm_get_fields(), ['take_part']);

    $values = [];

    foreach ($fields as $field) {
        $value = get_field(acf_field_key($field, $id), $id);
        if ($value) {
            $values[] = $value;
        }
    }

    $title = implode(' ', $values);
    if ($title) {
        wp_update_post(['ID' => $id, 'post_title' => $title]);
    }


}

function custom_crm_get_data_form_post($data)
{

    $fieldsMap = [
        'deliveryMail' => 'email',
        'tel-445' => 'telephone',
        'text-456' => 'text',
        'text-336' => 'text2',
        'text-423' => 'name',
        'email-181' => 'email',
        'menu-788' => 'payment_type',
        'text-457' => 'position',
        'text-975' => 'entity_name',
    ];

    $result = [
        'take_part' => 0,
    ];

    foreach ($fieldsMap as $key => $name) {
        if (isset($data[$key])) {
            $result[$name] = $data[$key];
        }
    }


    if (isset($result['name']) && strpos($result['name'], ' ') > 0) {
        $parts = explode(' ', $result['name']);
        $result['surname'] = array_shift($parts);
        $result['name'] = implode(' ', $parts);
    }

    return $result;
}

function create_crm_post_type()
{
    $labels = array(
        'name' => 'CRM Записи',
        'singular_name' => 'CRM Запись',
        'menu_name' => 'CRM Записи',
        'all_items' => 'Все записи',
        'view_item' => 'Просмотреть записи',
        'add_new_item' => 'Добавить запись',
        'add_new' => 'Добавить запись',
        'edit_item' => 'Редактировать запись',
        'update_item' => 'Редактировать запись',
        'search_items' => 'Поиск',
        'not_found' => 'Не найдено',
        'not_found_in_trash' => 'Не найдено в корзине',
    );
    register_post_type('crm_record', [
        'label' => 'CRM Записи',
        'description' => 'CRM Записи',
        'labels' => $labels,
        'supports' => false,
        'map_meta_cap' => ['delete_post', 'edit_post'],
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'can_export' => true,
        'exclude_from_search' => true,
        'rewrite' => array('slug' => 'crm_record'),
        'publicly_queryable' => true,
        'capability_type' => 'post',
    ]);
}

function custom_crm_row_actions($actions, $post)
{
    $result = [];
    if ($post->post_type == 'crm_record') {
        if (isset($actions['edit'])) {
            $result['edit'] = $actions['edit'];
        }
        if (isset($actions['trash'])) {
            $result['trash'] = $actions['trash'];
        }
        unset($actions['inline hide-if-no-js']);
    } else {
        return $actions;
    }
    return $result;
}


function custom_crm_after_save($location, $post_id)
{
    if ('crm_record' == get_post_type($post_id)) {
        $location = admin_url('edit.php?post_type=crm_record');
    }
    return $location;
}

add_filter('post_row_actions', 'custom_crm_row_actions', 20, 2);
add_action('admin_action_mailing', 'custom_crm_run');
add_action('init', 'create_crm_post_type', -10);
add_filter('redirect_post_location', 'custom_crm_after_save', 20, 2);
add_filter('manage_crm_record_posts_columns', 'custom_crm_table_filter');
add_action('manage_crm_record_posts_custom_column', 'custom_crm_custom_column', 10, 2);
add_action('restrict_manage_posts', 'custom_crm_add_header_filter', -10);
add_action('pre_get_posts', 'custom_crm_query_filter');
add_action('wpcf7_before_send_mail', 'custom_crm_save_wpcf7_data');

add_action('bulk_actions-edit-crm_record', 'custom_crm_bulk_action');

function custom_crm_bulk_action($actions)
{
    $actions['mailing'] = 'Рассылка';
    return $actions;
}

function custom_crm_get_filter_value()
{
    return (isset($_GET['custom_crm_filter_checked']) && ($_GET['custom_crm_filter_checked'] === 'on')) ? 1 : 0;
}

function custom_crm_query_filter(WP_Query $query)
{
    if (create_crm_is_valid_request()) {
        $query->set('meta_query', array(
                array(
                    'key' => 'take_part',
                    'value' => custom_crm_get_filter_value(),
                    'compare' => '=',
                    'type' => 'numeric'
                )
            )
        );
    }
}

function create_crm_is_valid_request()
{
    return isset($_REQUEST['custom_crm_filter']);
}

function custom_crm_add_header_filter()
{
    global $post_type;
    if ($post_type == 'crm_record') : ?>
        <div id="status-filter" style="padding-top: 4px;float: left;">
            <button class="button page-title-action" name="action" value="mailing">Рассылка</button>
            <input type="hidden" name="custom_crm_filter">
            <label for="statusFilterInput">Участвовал
                <input type="checkbox" name="custom_crm_filter_checked"
                       id="statusFilterInput" <?php if (custom_crm_get_filter_value()): ?>
                    checked
                <?php endif ?>>
            </label>
        </div>
        <?php
    endif;
}


function custom_crm_table_filter($sortable_columns)
{
    $sortable_columns['custom_date'] = 'Дата';
    $sortable_columns['fullname'] = 'ФИО';
    $sortable_columns['email'] = 'Email';
    $sortable_columns['telephone'] = 'Телефон';
    $sortable_columns['request_type'] = 'Вид заявки';
    $sortable_columns['details'] = '';
    return $sortable_columns;
}


if (!function_exists('acf_field_key')) {
    function acf_field_key($field_name, $group_id, $post_id = false)
    {
        if ($post_id) {
            return get_field_reference($field_name, $post_id);
        }

        if (!empty($GLOBALS['acf_register_field_group'])) {

            foreach ($GLOBALS['acf_register_field_group'] as $acf) {

                if ($acf['id'] === $group_id) {

                    foreach ($acf['fields'] as $field) {

                        if ($field_name === $field['name']) {
                            return $field['key'];
                        }
                    }
                }
            }
        }
        return $field_name;
    }
}

function custom_crm_custom_column($column, $post_id)
{
    switch ($column) {
        case 'details':
            echo '<a class="button action page-title-action" href="'
                . " post.php?action=edit&amp;post=$post_id"
                . '">Подробнее</a>';
            break;
        case 'custom_date':
            echo get_post($post_id)->post_date;
            break;
        case 'request_type':
            echo get_field(acf_field_key('request_type', 'acf_crm'), $post_id);
            break;
        case 'email':
            echo get_field(acf_field_key('email', 'acf_crm'), $post_id);
            break;
        case 'telephone':
            echo get_field(acf_field_key('telephone', 'acf_crm'), $post_id);
            break;
        case 'fullname':
            echo get_field(acf_field_key('surname', 'acf_crm'), $post_id) . ' ' . get_field(acf_field_key('name', 'acf_crm'), $post_id);
            break;
    }
}

function custom_crm_custom_column_filter($columns)
{
    unset($columns['title']);
    unset($columns['date']);
    return $columns;
}


function custom_crm_get_fields()
{
    foreach ($GLOBALS['acf_register_field_group'] as $acf_group) {
        if ($acf_group['id'] === 'acf_crm') {
            return array_map(function ($field) {
                return $field['name'];
            }, $acf_group['fields']);
        }
    }
    return [];
}

add_filter('manage_edit-crm_record_columns', 'custom_crm_custom_column_filter', 10, 1);

if (function_exists("register_field_group")) {
    register_field_group(array(
        'id' => 'acf_crm',
        'title' => 'CRM',
        'fields' => array(
            array(
                'key' => 'field_57a85206ab3d5',
                'label' => 'Email',
                'name' => 'email',
                'type' => 'email',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_57a851c0ab3d3',
                'label' => 'Имя',
                'name' => 'name',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a851d7ab3d4',
                'label' => 'Фамилия',
                'name' => 'surname',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a852d50bdbd',
                'label' => 'Компания',
                'name' => 'company',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a852e20bdbe',
                'label' => 'Должность',
                'name' => 'position',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a853220bdbf',
                'label' => 'Телефон',
                'name' => 'telephone',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a8534b0bdc0',
                'label' => 'Skype',
                'name' => 'skype',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a8535b0bdc1',
                'label' => 'Способ оплаты',
                'name' => 'payment_type',
                'type' => 'select',
                'choices' => array(
                    'Приватбанк' => 'Приватбанк',
                    'Расчетный счет' => 'Расчетный счет',
                    'Наличные' => 'Наличные',
                ),
                'default_value' => '',
                'allow_null' => 0,
                'multiple' => 0,
            ),
            array(
                'key' => 'field_57a8535b0bec1',
                'label' => 'Вид заявки',
                'name' => 'request_type',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'html',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_57a853e39afd2',
                'label' => 'Участвовал',
                'name' => 'take_part',
                'type' => 'true_false',
                'message' => '',
                'default_value' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'crm_record',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array(
            'position' => 'normal',
            'layout' => 'default',
            'hide_on_screen' => array(),
        ),
        'menu_order' => 0,
    ));
}


