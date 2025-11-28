  <?php
  $query = mysqli_query($config, "SELECT * FROM services s ORDER BY s.id DESC");
  $services = mysqli_fetch_all($query, MYSQLI_ASSOC);

  if (isset($_GET['delete'])) {
    $id     = $_GET['delete'];
    $delete = mysqli_query($config, "DELETE FROM services WHERE id = $id");
    // redirect
    if ($delete) {
      header("location:?page=service");
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
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Services</h3>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-end p-2">
              <a href="?page=tambah-service" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Add</a>
            </div>
            <table class="table table-bordered table-striped">
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Actions</th>
              </tr>
              <?php
              foreach ($services as $key => $value) {
              ?>
                <tr>
                  <td><?php echo $key + 1 ?></td>
                  <td><?php echo $value['name'] ?></td>
                  <td><?php echo "Rp." . number_format($value['price'], 2, ",", ".") ?></td>
                  <td><?php echo $value['description'] ?></td>
                  <td>
                    <a href="?page=tambah-service&edit= <?= $value['id'] ?>" class="btn btn-success btn-sm">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="?page=service&delete=<?= $value['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Ingin delete?')">
                      <i class="bi bi-trash"></i>
                    </a>
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