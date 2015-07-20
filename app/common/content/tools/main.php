<?php

use yz\navigation\FilRouge;
use yz\navigation\Actions;
use jin\output\webapp\context\Output;

?>

<div class="pageContext">
    <div class="filrouge">
        <?php
        $items = FilRouge::getAllItems();
        for($p = 0; $p < count($items); $p++){
            $item = $items[$p];
            
            echo '<div class="item">';
            if($item->isSelected()){
                echo '<a href="'.$item->getUrl().'" class="selected">'.$item->getLabel().'</a>';
            }else if($item->isLinkable()){
                echo '<a href="'.$item->getUrl().'">'.$item->getLabel().'</a>';
            }else{
                echo $item->getLabel();
            }
            echo '</div>';
            if($p < count($items)-1){
                echo '<div class="sep">></div>';
            }
        }
        ?>
    </div>
    <h1><?= Output::get('title'); ?></h1>
</div>

<div class="actions">
    <?php 
    foreach(Actions::getAllItems() AS $item){
        echo $item->render();
    } 
    ?>
</div>