<?php

/* @var $this yii\web\View */

$this->title = $page->title;
?>
<div class="contacts">
    <div class="container contacts-info">
        <?php
        if(sizeof($contacts) > 0 && sizeof($contactTypes)){
            foreach ($contactTypes as $keyType => $type) {
                ?>
                <div>
                    <?php
                        foreach ($contacts as $keyContact => $contact) {
                            if($contact->type == $type->id){
                            ?>
                            <p>
                                <?php 
                                echo $type->icon . "&nbsp;";
                                echo $contact->value . "&nbsp;"; 
                                ?>
                            </p>
                             <?php
                            }
                        }
                    ?>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="content">
    <div class="container">
        <?=$page->text;?>
    </div>
</div>