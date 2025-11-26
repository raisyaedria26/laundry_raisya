<?php
// include;
// include_once;
// require_once;
// require;
// require_once 'config/koneksi.php';

$query = mysqli_query($config, "SELECT l.name as level_name, u.* FROM users u
LEFT JOIN levels l ON l.id = u.level_id ORDER BY u.id DESC");
$users = mysqli_fetch_all($query, mode: MYSQLI_ASSOC);

// disini parameter delete
// $_GET 
// isset, empty
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $delete = mysqli_query($config, "DELETE FROM users WHERE id = $id");
  // redirect
  header("location:?page=user&hapus=berhasil");
}
?>

<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">Data User</h3>
        <div class="mb-3" align="right">
          <a href="?page=tambah-user" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add User
          </a>
          <a href="?page=user-restore" class="btn btn-primary">
            <i class="bi bi-arrow-counterclockwise"></i> Restore user
          </a>
        </div>
        <table class="table table-bordered table-striped datatable">
          <thead>
            <tr>
              <th>No</th>
              <th>Level</th>
              <th>Name</th>
              <th>Email</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $key => $value): ?>
              <tr>
                <td><?php echo $key += 1 ?></td>
                <td><?php echo $value['level_name'] ?></td>
                <td><?php echo $value['name'] ?></td>
                <td><?php echo $value['email'] ?></td>
                <td>
                  <a class="btn btn-success btn-sm" href="?page=tambah-user&edit=<?php echo $value['id'] ?>"><i class="bi bi-pencil"></i></a>
                  <a class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"
                    href="?page=user&delete=<?php echo $value['id'] ?>">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>