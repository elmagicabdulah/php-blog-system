<?php
function getPageTitle() {
    global $page_title;
    if(isset($page_title)) {
        return "| " . $page_title;
    }
}

function includeFooter() {
    echo '<footer class="footer">
    <p>All Copyrights reserved Abdo Blog &copy;</p>
</footer>';
}

function redirect($url, $msg = '', $delay = 0) {
    echo $msg;
    header('refresh:' . $delay . ';url=' . $url);
    exit();
}
