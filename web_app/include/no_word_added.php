<?php
if(sizeof($word_arr_select)==0 && $no_of_pages == 0)
{
    if($high_check_bool)
    {
        $message = 'No word starting with this letter in this category';
    }
    else
    {
        $message = 'You have not added any word in this category yet.';
    }
?>
<div class="row">
    <div class="large-12 small-11 small-centered columns card" style="padding-top:80px;min-height:200px;text-align:center">
        <h3><?php echo $message; ?></h3>
    </div>
</div>
<?php
}
else if(sizeof($word_arr_select)==0 && $no_of_pages >0)
{
    if($high_check_bool)
    {
        $message = 'Page '.$page.' doesn\'t exist for this category.';
    }
    else
    {
        $message = 'Page '.$page.' doesn\'t exist for this category.';
    }
?>
<div class="row">
    <div class="large-12 small-11 small-centered columns card" style="padding-top:80px;min-height:200px;text-align:center">
        <h3><?php echo $message; ?></h3>
    </div>
</div>
<?php
}
?>