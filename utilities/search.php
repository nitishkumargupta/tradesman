<?php
function search($dbc, $category, $date, $postal_code)
{
  try {
    $q = "SELECT * from users where user_id in (select user_id from us_address  where post_code like '$postal_code%' intersect SELECT user_id from us_skill where cat_id = '$category') and active = true and type = 'tradesman' order by is_professional desc";
    $r = $dbc->query($q);
    $rowcount = $r->num_rows;
    if ($rowcount) {
      return array('success' => true, 'data' => $r);
    } else {
      return array('success' => false, 'message' => 'No Data Found');
    }
  } catch (Exception $e) {
    return array('success' => false, 'message' => 'Internal Server Error');
  }
}
?>