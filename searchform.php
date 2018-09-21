<?php
/**
 * Created by PhpStorm.
 * User: игорь
 * Date: 20.09.2018
 * Time: 23:40
 */
//todo: сделать верстку формы
?>

<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ) ?>" >
    <label class="screen-reader-text" for="s">Поиск: </label>
    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="найти" />
    <input type="hidden" value="portfolio" name="post_type" id="post_type" />
    <input type="hidden" value="stock" name="categories" id="categories" />
</form>
