<?php
$id   = isset($_GET['edit']) ? $_GET['edit'] : '';
$query  = mysqli_query($config, "SELECT * FROM taxs WHERE id = '$id' ");
$rowEdit  = mysqli_fetch_assoc($query);
// var_dump($product);

if (isset($_POST['simpan'])) {
  $percent           = $_POST['percent'];
  $is_active         = $_POST['is_active'];

  $insert  = mysqli_query($config, "INSERT INTO taxs (percent, is_active) VALUES ('$percent', '$is_active')");

  if ($insert) {
    header("location:?page=tax");
  }
}

if (isset($_POST['update'])) {
  $id             = $_GET['edit'];
  $percent           = $_POST['percent'];
  $is_active         = $_POST['is_active'];

  $update         = mysqli_query($config, "UPDATE taxs SET percent='$percent', is_active='$is_active' WHERE id = $id");
  if ($update) {
    header("location:?page=tax");
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <div class="card">
    <div class="card-body">
      <h3 class="card-title"><?php echo isset($_GET['edit']) ? 'Edit' : 'Create' ?> Tax</h3>
    </div>
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="w-50">
          <div class="mb-3">
            <label for="" class="form-label">Percent</label>
            <input class="form-control" type="number" name="percent"
              value="<?php echo $rowEdit ? $rowEdit['percent'] : '' ?>" required>
          </div>

          <div class="mb-3">
            <label for="" class="form-label">Is Active</label>
            <br>
            <input type="radio" name="is_active" <?php echo $rowEdit ? $rowEdit == 0 ? 'checked' : '' : '' ?> value="0"> Draft <br>
            <input type="radio" name="is_active" <?php echo $rowEdit ? $rowEdit == 1 ? 'checked' : '' : '' ?> value="1"> Active
          </div>

          <button type="submit" name="<?php echo isset($_GET['edit']) ? 'update' : 'simpan' ?>" class="btn btn-primary mt-2">
            <?php echo isset($_GET['edit']) ? 'Edit' : 'ADD' ?></button>
        </div>
      </form>
    </div>
  </div>
</body>

</html>