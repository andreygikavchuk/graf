<?php
if ( in_category('2') ) {
    include(TEMPLATEPATH . '/single_news.php'); }
else {
    include(TEMPLATEPATH . '/single_flat.php');
}
?>