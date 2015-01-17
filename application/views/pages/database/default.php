<?php

$active = "Database";
breadcrumb($crumbs,$active);

?>
<div class="container-fluid v4p-container">
    <div class="row">
        <div class="col-md-12">
            <form action="database" method="post" class="form-inline">
                <select class="form-control" name="tbl">
                    <option value="item">Item</option>
                    <option value="mob">Monster</option>
                </select>
                <input type="text" class="form-control" name="query" required />
                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
            </form>
        </div>
    </div>
</div>