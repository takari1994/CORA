<?php

$chargen = new CharacterRender();
$chargen->action = CharacterRender::ACTION_READYFIGHT;
$chargen->direction = CharacterRender::DIRECTION_SOUTHEAST;
$chargen->body_animation = 0;
$chargen->doridori = 0;

// Custom data:
$chargen->sex    = "M";
$chargen->class = 4002;
$chargen->clothes_color = 0;
$chargen->hair = 5;
$chargen->hair_color = 12;
// ... head_top, head_mid, head_bottom, robe, weapon, shield, ...

// Generate Image
$img = $chargen->render();
imagepng($img);

?>