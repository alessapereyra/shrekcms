<?php

    $votes_articles = GDSRDB::front_page_article_totals();
    $votes_comments = GDSRDB::front_page_comment_totals();
    $moderation = GDSRDB::front_page_moderation_totals();

    $moderation_articles = 0;
    $moderation_comments = 0;

    if (is_array($moderation)) {
        foreach ($moderation as $m) {
            if ($m->vote_type == 'article')
                $moderate_articles = $m->queue;
            else
                $moderation_comments = $m->queue;
        }
    }
?>

<div id="gdpt_server" class="postbox gdrgrid frontleft">
    <h3 class="hndle"><span><?php _e("Quick Rating Facts", "gd-star-rating"); ?></span></h3>
    <div class="inside">
        <p class="gdptyouhave" style="font-size:13px;">
        <?php
            printf(__("Registered users rated %s articles with average rating of %s and %s comments with average rating of %s. Visitors rated %s articles with average rating of %s and %s comments with average rating of %s.", "gd-star-rating"),
                '<strong>'.$votes_articles->votersu.'</strong>',
                '<strong><span style="color: red">'.@number_format($votes_articles->votesu / $votes_articles->votersu, 1).'</span></strong>',
                '<strong>'.$votes_comments->votersu.'</strong>',
                '<strong><span style="color: red">'.@number_format($votes_comments->votesu / $votes_comments->votersu, 1).'</span></strong>',
                '<strong>'.$votes_articles->votersv.'</strong>',
                '<strong><span style="color: red">'.@number_format($votes_articles->votesv / $votes_articles->votersv, 1).'</span></strong>',
                '<strong>'.$votes_comments->votersv.'</strong>',
                '<strong><span style="color: red">'.@number_format($votes_comments->votesv / $votes_comments->votersv, 1).'</span></strong>'
            );
            if ($options["moderation_active"] == 1)
                printf(__(" There are %s article and %s comments ratings waiting in moderation queue.", "gd-star-rating"),
                    '<strong><span style="color: red">'.$moderation_articles.'</span></strong>',
                    '<strong><span style="color: red">'.$moderation_comments.'</span></strong>'
                );
        ?>
        </p>
    </div>
</div>
<div id="gdpt_server" class="postbox gdrgrid frontleft">
        <small style="float: right; margin-right:6px; margin-top:6px;">
            <a target="_blank" href="http://www.gdstarrating.com/"><?php _e("See All", "gd-star-rating"); ?></a> | <a href="http://feeds2.feedburner.com/GdStarRating">RSS</a>
        </small>
        <h3 class="hndle"><span><?php _e("Latest News", "gd-star-rating"); ?></span></h3>
        <div class="gdsrclear"></div>
    <div class="inside">
        <?php

          if ($options["news_feed_active"] == 1) {
              $rss = fetch_rss('http://www.gdstarrating.com/feed/');
              if (isset($rss->items) && 0 != count($rss->items))
              {
                echo '<ul>';
                $rss->items = array_slice($rss->items, 0, 3);
                foreach ($rss->items as $item)
                {
                ?>
                  <li>
                  <div class="rssTitle">
                    <a target="_blank" class="rsswidget" title='' href='<?php echo wp_filter_kses($item['link']); ?>'><?php echo wp_specialchars($item['title']); ?></a>
                    <span class="rss-date"><?php echo human_time_diff(strtotime($item['pubdate'], time())); ?></span>
                    <div class="gdsrclear"></div>
                  </div>
                  <div class="rssSummary"><?php echo '<strong>'.date("F, jS", strtotime($item['pubdate'])).'</strong> - '.$item['description']; ?></div></li>
                <?php
                }
                echo '</ul>';
              }
              else
              {
                ?>
                <p><?php printf(__("An error occured while loading newsfeed. Go to the %sfront page%s to check for updates.", "gd-star-rating"), '<a href="http://www.gdstarrating.com/">', '</a>') ?></p>
                <?php
              }
          }
          else {
            ?>
            <p><?php _e("Newsfeed update is disabled. You can enable it on settings page.", "gd-star-rating"); ?></p>
            <?php
          }

        ?>
    </div>
</div>
