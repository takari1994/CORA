<?php

if(null != uri_string()) {
    $uri = explode('/',uri_string());
    if(2 > count($uri))
        $active = "Post";
    else {
        $active = $uri[1];
    }
} else {
    $active = "Home";    
}

?>
<ul class="nav nav-tabs">
    <li<?php if($active == "Home" OR $active == "Post"){ echo ' class="active"'; } ?>>
        <a href="post">All</a>
    </li>
    <li<?php if($active == "news"){ echo ' class="active"'; } ?>>
        <a href="post/news">News</a>
    </li>
    <li<?php if($active == "events"){ echo ' class="active"'; } ?>>
        <a href="post/events">Events</a>
    </li>
</ul>
<?php

breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th class="center">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(null == $posts): ?>
                    <tr>
                        <td style="font-style:italic;">No post found</td>
                        <td>-</td>
                        <td class="center">-</td>
                    </tr>
                    <?php else: foreach($posts as $post): ?>
                    <tr>
                        <td>
                            <?php
                                
                            switch($post->type) {
                                case 1:
                                    echo '<div class="label label-primary">News</div>'; break;
                                case 2:
                                    echo '<div class="label label-warning">Event</div>'; break;
                                case 3:
                                    echo '<div class="label label-info">Logs</div>';
                            }
                                
                            ?>
                            <a title="<?php echo $post->title; ?>" href="<?php echo base_url().'post/view?id='.$post->post_id; ?>"><?php echo character_limiter($post->title,30); ?></a>
                        </td>
                        <td style="font-style: italic"><?php echo $post->userid; ?></td>
                        <td class="center">
                            <?php
                            
                            $date = date_create( $post->date );
                            echo $date->format('m/d/y h:iA')
                            
                            ?>
                        </td>
                    </tr>
                    <?php endforeach;endif; ?>
                </tbody>
            </table>
            <?php
            
            if(null != $posts) {
                $curpage = (isset($_GET['page'])?$_GET['page']:1);
                //Pagination
                pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
            }
            
            ?>
        </div>
    </div>
</div>