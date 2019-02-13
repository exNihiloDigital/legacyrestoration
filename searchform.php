
<form method="get" action="<?php echo home_url('/') ?>" class="searchform">
  <input type="search" name="s" placeholder="Search ..." value="<?php echo get_search_query() ?>"/>
  <button type="submit" value=""><i class="fa fa-search"></i></button>
</form>