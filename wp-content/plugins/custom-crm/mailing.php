<?php
/**
 * @var $posts WP_Post[]
 */
require_once(ABSPATH . 'wp-admin/admin.php');

//wp_enqueue_script('inline-edit-post');
//wp_enqueue_script('heartbeat');

require_once(ABSPATH . 'wp-admin/admin-header.php');
?>

<?php if ($message): ?>
    <div id="message" class="notice notice-<?= $message_type ?> is-dismissible">
        <p><?php echo $message; ?></p>
    </div>
<?php endif ?>

<style>
    #message {
        margin-left: 2px;
    }

    #postexcerpt input,
    #postexcerpt textarea {
        width: 100%;
    }
</style>
<div class="wrap">
    <h1>Рассылка</h1>
    <form enctype="multipart/form-data" method="post" action="?action=mailing">
        <div id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    <div id="postexcerpt" class="postbox ">
                        <?php foreach ($posts as $post): ?>
                            <input type="hidden" name="crm_mail[email][]"
                                   value="<?= get_field(acf_field_key('email', 'acf_crm'), $post->ID) ?>">
                        <?php endforeach ?>
                        <h2 class="hndle ui-sortable-handle"><span>Сообщение</span></h2>
                        <div class="inside">
                            <div>
                                <label for="from">Отправитель</label>
                            </div>
                            <input name="crm_mail[from]" id="from"
                                   value="<?= get_option('admin_email') ?>"/>
                        </div>
                        <div class="inside">
                            <div>
                                <label for="subject">Тема</label>
                            </div>
                            <input name="crm_mail[subject]" id="subject"/>
                        </div>
                        <div class="inside">
                            <label for="text">Текст</label>
                            <textarea rows="10" name="crm_mail[text]"
                                      id="text"></textarea>
                        </div>

                        <div class="inside">
                            <div>
                                <label for="files">Файлы</label>
                            </div>
                            <input type="file" multiple name="crm_mail[files][]" id="files"/>
                        </div>
                    </div>
                </div>
                <button type="submit" class="button button-primary button-large">Отправить</button>
            </div>
        </div>


    </form>
</div>