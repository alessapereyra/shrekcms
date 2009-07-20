<?php

$posts_per_page = $options["admin_rows"];

$url = $_SERVER['REQUEST_URI'];
$url_pos = strpos($url, "&gdsr=");
if (!($url_pos === false))
    $url = substr($url, 0, $url_pos);

$log_url = $url."&gdsr=userslog";
$url.= "&gdsr=users";

$page_id = 1;
if (isset($_GET["pg"])) $page_id = $_GET["pg"];

$number_posts = GDSRDatabase::get_valid_users_count();

$max_page = floor($number_posts / $posts_per_page);
if ($max_page * $posts_per_page != $number_posts) $max_page++;

if ($max_page > 1)
    $pager = GDSRHelper::draw_pager($max_page, $page_id, $url, "pg");

$users = array();
$pre_users = GDSRDatabase::get_valid_users();
$count = -1;
$usrid = -1;
foreach ($pre_users as $user) {
    if ($user->user_id != $usrid) $count++;
    $users[$count]["id"] = $user->user_id;
    $users[$count][$user->vote_type]["votes"] = $user->votes;
    $users[$count][$user->vote_type]["voters"] = $user->voters;
    $users[$count][$user->vote_type]["ips"] = $user->ips;
    $users[$count]["name"] = $user->user_id == 0 ? __("Visitor", "gd-star-rating") : $user->display_name;
    $users[$count]["email"] = $user->user_id == 0 ? "/" : $user->user_email;
    $users[$count]["url"] = $user->user_id == 0 ? "/" : $user->user_url;
    $usrid = $user->user_id;
}

$usr_from = ($page_id - 1) * $posts_per_page;
$usr_to = $page_id * $posts_per_page;
if ($usr_to > $number_posts) $usr_to = $number_posts;

?>

<?php if ($wpv < 27) { ?><div class="wrap" style="max-width: <?php echo $options["admin_width"]; ?>px">
<?php } else { ?><div class="wrap"><?php } ?>
<form id="gdsr-articles" method="post" action="">
<h2 class="gdptlogopage">GD Star Rating: <?php _e("Users", "gd-star-rating"); ?></h2>
<div class="tablenav">
    <div class="alignleft">
    </div>
    <div class="tablenav-pages">
        <?php echo $pager; ?>
    </div>
</div>
<br class="clear"/>

<table class="widefat">
    <thead>
        <tr>
            <th scope="col"><?php _e("Name", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("ID", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Email", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("URL", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Articles", "gd-star-rating"); ?></th>
            <th scope="col"><?php _e("Comments", "gd-star-rating"); ?></th>
        </tr>
    </thead>
    <tbody>
<?php
       
    $tr_class = "";
    for ($i = $usr_from; $i < $usr_to; $i++) {
        $row = $users[$i];
        
        $usr_url = $row["name"];
        if ($row["id"] > 0) $usr_url = '<a href="./user-edit.php?user_id='.$row["id"].'">'.$row["name"].'</a>';
        
        $ip_pst = 0;
        $r_pst = 0;
        if ($row["article"]["voters"] > 0) $r_pst = @number_format($row["article"]["votes"] / $row["article"]["voters"], 1);
        else $row["article"]["voters"] = "0";
        if ($row["article"]["ips"] > 0) $ip_pst = $row["article"]["ips"];

        if ($row["id"] == 0) $tr_class.= " visitor";
        if ($row["id"] == 1) $tr_class.= " admin";

        $ip_cmm = 0;
        $r_cmm = 0;
        if ($row["comment"]["voters"] > 0) $r_cmm = @number_format($row["comment"]["votes"] / $row["comment"]["voters"], 1);
        else $row["comment"]["voters"] = "0";
        if ($row["comment"]["ips"] > 0) $ip_cmm = $row["comment"]["ips"];

        echo '<tr id="post-'.$row["id"].'" class="'.$tr_class.' author-self status-publish" valign="top">';
        echo '<td><strong>'.$usr_url.'</strong></td>';
        echo '<td>'.$row["id"].'</td>';
        echo '<td>'.$row["email"].'</td>';
        echo '<td>'.$row["url"].'</td>';
        echo '<td>'.__("votes", "gd-star-rating").': <strong><a href="'.$log_url.'&ui='.$row["id"].'&vt=article&un='.urlencode($row["name"]).'">'.$row["article"]["voters"].'</a></strong><br />';
        echo __("rating", "gd-star-rating").': <strong style="color: red">'.$r_pst.'</strong><br />';
        echo __("unique ip's", "gd-star-rating").': <strong>'.$ip_pst.'</strong></td>';
        echo '<td>'.__("votes", "gd-star-rating").': <strong><a href="'.$log_url.'&ui='.$row["id"].'&vt=comment&un='.urlencode($row["name"]).'">'.$row["comment"]["voters"].'</a></strong><br />';
        echo __("rating", "gd-star-rating").': <strong style="color: red">'.$r_cmm.'</strong><br />';
        echo __("unique ip's", "gd-star-rating").': <strong>'.$ip_cmm.'</strong></td>';
        echo '</tr>';
        
        if ($tr_class == "")
            $tr_class = "alternate ";
        else
            $tr_class = "";
    }

?>
    </tbody>
</table>
<!--<div class="tablenav">
    <div class="alignleft">
    </div>
    <div class="tablenav-pages">
    </div>
</div>-->
<br class="clear"/>
</form>
</div>
