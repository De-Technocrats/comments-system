<?php

// set or include db.php file
include 'db.php';

// init output
$output = '';

// do a select query with order by to sort the new comments on tbl_comment
$query = "SELECT * FROM tbl_comment WHERE parent_id = 0 ORDER BY id DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

// looping the data
while ($row = $res->fetch_assoc()) {

  // do join output
  $output .= '
  <div class="card border border-1 p-3 mb-2 me-1 bg-white text-dark">
      <i class="bi bi-person-circle" style="font-size:30px;"> <span class="fst-normal fw-bold" style="font-size:19px;">' .$row["name"] . '</span></i>
    <div class="card-body">
      <p>' . $row["comment"] . '</p>
    </div>
      <div class="col-se-5 mt-5">
      <i class="bi bi-clock"> ' . $row["comment_date"] . '</i> 
      <button type="button" class="btn btn-primary float-end reply" id="' . $row["id"] . '">Reply</button>
      </div>
  </div>
';

  $output .= get_reply($db, $row["id"]);
}

// show the results
echo $output;


// function get_reply is used to reply to user comments
function get_reply($db, $parent_id = 0)
{
  $output = '';
  $query = "SELECT * FROM tbl_comment WHERE parent_id=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $parent_id);
  $stmt->execute();
  $res = $stmt->get_result();
  $count = $res->num_rows;

  if ($count > 0) {
    while ($row = $res->fetch_assoc()) {
      $output .= '
        <div class="card border border-1 p-3 mb-2 bg-white text-dark me-2" style="margin-left:30px;">
        <i class="bi bi-person-circle" style="font-size:30px;"> <span class="fst-normal fw-bold" style="font-size:19px;">' .$row["name"] . '</span></i>
          <div class="card-body">
              <p>' . $row["comment"] . '</p>
            </div>
            <div class="col-se-5 mt-5">
            <i class="bi bi-clock"> ' . $row["comment_date"] . '</i> 
            <button type="button" class="btn btn-primary float-end reply" id="' . $row["id"] . '">Reply</button>
          </div>   
        </div>   
        ';

      $output .= get_reply($db, $row["id"]);
    }
  }

  return $output;
}


?>