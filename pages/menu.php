<?php
// require_once "config/koneksi.php";
$q_menus = mysqli_query($config, "SELECT * FROM menus ORDER BY orders ASC");
$menus = mysqli_fetch_all($q_menus, MYSQLI_ASSOC);
// var_dump($categories);

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $q_delete = mysqli_query($config, "DELETE FROM menus WHERE id = '$id'");
  header("location:?page=menu");
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
          <h1 class="card-title">Data Menu</h1>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-end m-3">
            <a href="?page=tambah-menu" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Add Menu</a>
          </div>
          <table class="table table-bordered table-striped">
            <tr>
              <th>No</th>
              <th>Menu Name</th>
              <th>Icon</th>
              <th>Link</th>
              <th>Order</th>
              <th>Actions</th>
            </tr>
            <?php
            foreach ($menus as $key => $menu) {
            ?>
              <tr>
                <td><?php echo $key + 1 ?></td>
                <td><?php echo $menu['name'] ?></td>
                <td><?php echo $menu['icon'] ?></td>
                <td><?php echo $menu['link'] ?></td>
                <td><?php echo $menu['orders'] ?></td>
                <td class="d-flex gap-2">
                  <a class="btn btn-success" href="?page=tambah-menu&edit=<?php echo $menu['id'] ?>"><i class="bi bi-pencil"></i></a>

                  <form action="?page=menu&delete=<?php echo $menu['id'] ?>" method="post" onclick="return confirm('Apakah ingin di hapus?')">
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