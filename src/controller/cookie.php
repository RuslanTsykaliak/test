<?php
function getCreatorId()
{
    if (isset($_COOKIE['creator_id'])) {
        return $_COOKIE['creator_id'];
    } else {
        $creatorId = uniqid();
        setcookie('creator_id', $creatorId, time() + (86400 * 365), '/');
        return $creatorId;
    }
}
?>
