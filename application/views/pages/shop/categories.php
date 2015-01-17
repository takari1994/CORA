<?php if($type == 'list'): ?>
<div class="list-group cat-list-group">
  <a href="<?php echo current_url(); ?>" class="list-group-item<?php if(!isset($_GET['cat'])){ echo " active"; } ?>"><img src="img/icons/unsorted.png">&nbsp;Unsorted</a>
  <a href="<?php echo current_url(); ?>?cat=consume" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "consume") { echo " active"; } ?>"><img src="img/icons/potion.png">&nbsp;Consumables</a>
  <a href="<?php echo current_url(); ?>?cat=head" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "head") { echo " active"; } ?>"><img src="img/icons/headgear.png">&nbsp;Headgear</a>
  <a href="<?php echo current_url(); ?>?cat=weapon" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "weapon") { echo " active"; } ?>"><img src="img/icons/sword.png">&nbsp;Weapon</a><!-- Right Hand -->
  <a href="<?php echo current_url(); ?>?cat=shield" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "shield") { echo " active"; } ?>"><img src="img/icons/shield.png">&nbsp;Shield</a><!-- Left Hand -->
  <a href="<?php echo current_url(); ?>?cat=armor" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "armor") { echo " active"; } ?>"><img src="img/icons/armor.png">&nbsp;Armor</a>
  <a href="<?php echo current_url(); ?>?cat=robe" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "robe") { echo " active"; } ?>"><img src="img/icons/robe.png">&nbsp;Robe</a>
  <a href="<?php echo current_url(); ?>?cat=shoes" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "shoes") { echo " active"; } ?>"><img src="img/icons/shoes.png">&nbsp;Shoes</a>
  <a href="<?php echo current_url(); ?>?cat=accessories" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "accessories") { echo " active"; } ?>"><img src="img/icons/accessories.png">&nbsp;Accessories</a>
  <a href="<?php echo current_url(); ?>?cat=costumes" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "costumes") { echo " active"; } ?>"><img src="img/icons/costumes.png">&nbsp;Costumes</a>
  <a href="<?php echo current_url(); ?>?cat=pets" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "pets") { echo " active"; } ?>"><img src="img/icons/pets.png">&nbsp;Pets</a>
  <a href="<?php echo current_url(); ?>?cat=cards" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "cards") { echo " active"; } ?>"><img src="img/icons/cards.png">&nbsp;Cards</a>
  <a href="<?php echo current_url(); ?>?cat=misc" class="list-group-item<?php if(isset($_GET['cat']) AND $_GET['cat'] == "misc") { echo " active"; } ?>"><img src="img/icons/misc.png">&nbsp;Misc</a>
</div>
<?php elseif($type == 'select'): ?>
<form class="form-inline">
    <label>Category:</label>
    <select class="form-control" id="formCatSelect">
        <option value="<?php echo current_url(); ?>"<?php if(!isset($_GET['cat'])){ echo " selected"; } ?>>Unsorted</option>
        <option value="<?php echo current_url(); ?>?cat=consume"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "consume") { echo " selected"; } ?>>Consumables</option>
        <option value="<?php echo current_url(); ?>?cat=head"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "head") { echo " selected"; } ?>>Headgear</option>
        <option value="<?php echo current_url(); ?>?cat=weapon"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "weapon") { echo " selected"; } ?>>Weapon</option>
        <option value="<?php echo current_url(); ?>?cat=shield"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "shield") { echo " selected"; } ?>>Shield</option>
        <option value="<?php echo current_url(); ?>?cat=armor"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "armor") { echo " selected"; } ?>>Armor</option>
        <option value="<?php echo current_url(); ?>?cat=robe"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "robe") { echo " selected"; } ?>>Robe</option>
        <option value="<?php echo current_url(); ?>?cat=shoes"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "shoes") { echo " selected"; } ?>>Shoes</option>
        <option value="<?php echo current_url(); ?>?cat=accessories"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "accessories") { echo " selected"; } ?>>Accessories</option>
        <option value="<?php echo current_url(); ?>?cat=costumes"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "costumes") { echo " selected"; } ?>>Costumes</option>
        <option value="<?php echo current_url(); ?>?cat=pets"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "pets") { echo " selected"; } ?>>Pets</option>
        <option value="<?php echo current_url(); ?>?cat=cards"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "cards") { echo " selected"; } ?>>Cards</option>
        <option value="<?php echo current_url(); ?>?cat=misc"<?php if(isset($_GET['cat']) AND $_GET['cat'] == "misc") { echo " selected"; } ?>>Miscellaneous</option>
    </select>
</form>
<?php endif; ?>