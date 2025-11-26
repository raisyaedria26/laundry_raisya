<?php
// require_once "config/koneksi.php";
$q_levels = mysqli_query($config, "SELECT * FROM levels");
$levels = mysqli_fetch_all($q_levels, MYSQLI_ASSOC);
// var_dump($categories);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $q_delete = mysqli_query($config, "DELETE FROM levels WHERE id = '$id'");
  header("location:?page=level");
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
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <h1 class="card-title">Data Level</h1>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-end m-3">
            <a href="?page=tambah-level" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Add Level</a>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th>No</th>
              <th>Level Name</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($levels as $key => $level) {
            ?>
              <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo $level['name'] ?></td>
                <td class="d-flex gap-2">
                  <a class="btn btn-warning" href="?page=add-role-menu&edit=<?php echo $level['id'] ?>"><i class="bi bi-plus"></i></a>

                  <a class="btn btn-primary" href="?page=tambah-level&edit=<?php echo $level['id'] ?>"><i class="bi bi-pencil"></i></a>


                  <form action="?page=level&delete=<?php echo $level['id'] ?>" method="post" onclick="return confirm('Apakah ingin di hapus?')">
                    <button class="btn btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            <?php
            }
            ?>
          </table>
        </div>
      </div>
    </div>
  </div>



</body>

</html>