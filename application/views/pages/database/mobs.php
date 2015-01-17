<?php

$active = "Monsters";
breadcrumb($crumbs,$active);

?>
<div class="container-fluid v4p-container">
    <div class="row">
        <div class="col-md-12">
            <form action="database" method="post" class="form-inline">
                <select class="form-control" name="tbl">
                    <option value="item">Item</option>
                    <option value="mob" selected>Monster</option>
                </select>
                <input type="text" class="form-control" name="query" required />
                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
            </form>
            <div class="spacer"></div>
            <?php if(null != $mobs): foreach($mobs as $mob): ?>
            <table class="table table-bordered">
                <tr>
                    <td colspan="5">
                        <strong><?php echo $mob->kName; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" style="width:30%;" class="center">
                        <img src="<?php echo base_url().'ROChargen/monster/'.$mob->ID; ?>" class="mob-img" />
                    </td>
                    <td style="width:17.5%"><strong>ID</strong></td>
                    <td style="width:17.5%"><?php echo $mob->ID; ?></td>
                    <td style="width:17.5%"><strong>HP</strong></td>
                    <td style="width:17.5%"><?php echo $mob->HP; ?></td>
                </tr>
                <tr>
                    <td style="width:17.5%"><strong>Level</strong></td>
                    <td style="width:17.5%"><?php echo $mob->LV; ?></td>
                    <td style="width:17.5%"><strong>SP</strong></td>
                    <td style="width:17.5%"><?php echo $mob->SP; ?></td>
                </tr>
            </table>
            <?php endforeach; else: ?>
            <em>No result found!</em>
            <?php endif; ?>
            <div class="spacer"></div>
            <?php
            
            if(null != $mobs) {
                $curpage = (isset($_GET['page'])?$_GET['page']:1);
                //Pagination
                pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
            }
            
            ?>
        </div>
    </div>
</div>