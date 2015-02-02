<ul class="nav nav-pills fr">
    <li class="active">
        <a href="dashboard/settings/general">General</a>
    </li>
    <li>
        <a href="dashboard/settings/account">Account</a>
    </li>
    <li>
        <a href="dashboard/settings/mailing">Mailing</a>
    </li>
    <li>
        <a href="dashboard/settings/admin">Admin</a>
    </li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="dashboard/settings/general?action=update" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Website theme</label>
                <select class="form-control block" name="theme">
                <?php $themes = directory_map(APP_PATH.'/views/layouts/',1); foreach($themes as $theme): if('dashboard' != $theme): ?>
                    <option value="<?php echo $theme; ?>"<?php if($theme == $settings[0]->theme){ echo ' selected';} ?>><?php echo $theme; ?></option>
                <?php endif; endforeach; ?>
                </select>
                <span class="help-block">Choose your website&rsquo;s theme.</span>
            </div>
            <div class="form-group">
                <label>Home Page</label>
                <select class="form-control block" name="homepage">
                    <option value="0"<?php if(0 == $settings[0]->homepage){ echo ' selected'; } ?>>Default (News Page)</option>
                    <option value="-1"<?php if(-1 == $settings[0]->homepage){ echo ' selected'; } ?>>Custom (index.php)</option>
                    <?php foreach($pages as $page): ?>
                    <option value="<?php echo $page->page_id; ?>"<?php if($page->page_id == $settings[0]->homepage){ echo ' selected'; } ?>><?php echo $page->title; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block">Choose your website&rsquo;s home page.</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Emulator</label>
                <select class="form-control block" name="emulator">
                    <option value="e"<?php if('e' == $settings[0]->emulator){ echo ' selected'; } ?>>eAthena Based</option>
                    <option value="h"<?php if('h' == $settings[0]->emulator){ echo ' selected'; } ?>>Hercules Based</option>
                    <option value="r"<?php if('r' == $settings[0]->emulator){ echo ' selected'; } ?>>rAthena Based</option>
                </select>
                <span class="help-block">Select what emulator your server is using.</span>
            </div>
            <div class="form-group">
                <label>TOS Page</label>
                <select class="form-control block" name="tospage">
                    <option value="0"<?php if(0 == $settings[0]->tospage){ echo ' selected'; } ?>>None</option>
                    <?php foreach($pages as $page): ?>
                    <option value="<?php echo $page->page_id; ?>"<?php if($page->page_id == $settings[0]->tospage){ echo ' selected'; } ?>><?php echo $page->title; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="help-block">Choose your website&rsquo;s terms of service page.</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Server name</label>
                <input type="text" class="form-control" name="serv_name" value="<?php echo $settings[0]->serv_name; ?>" />
                <span class="help-block">Use the name of your server as value. Example: <strong>NameRO</strong>, <strong>Name Ragnarok Online</strong></span>
            </div>
            <div class="form-group">
                <label>ReCaptcha Public Key</label>
                <input type="text" class="form-control" name="capt_pub_key" value="<?php echo $settings[0]->capt_pub_key; ?>" />
                <span class="help-block">Use the public key provided by Google&rsquo;s reCaptcha.</span>
            </div>
            <div class="form-group">
                <label>ReCaptcha Private Key</label>
                <input type="text" class="form-control" name="capt_pvt_key" value="<?php echo $settings[0]->capt_pvt_key; ?>" />
                <span class="help-block">Use the private key provided by Google&rsquo;s reCaptcha.</span>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="const_mode" value="1"<?php if(1 == $settings[0]->const_mode){ echo " checked"; } ?> /> Enable Construction Mode.
                </label>
                <span class="help-block inline"><strong>Note:</strong> Change your "under construction" page in /cora/application/views/pages/construction.php.</span>
            </div>
            <div class="spacer"></div>
            <div class="right">
                <input type="submit" class="btn btn-primary" name="submit" value="Save Changes">
                <input type="reset" class="btn btn-default" value="Cancel" />
            </div>
        </div>
    </div>
</form>