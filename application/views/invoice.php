<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-sm-6"><h1>Invoice Details</h1></div>
          <div class="col-sm-6" align="right">
            <a href="<?php echo base_url() ?>" class="btn btn-warning"><i class="fa fa-home"> Home</i></a>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product(s)</th>
                  <th>Price</th>
                  <th>Invoice</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($invoice)) {
                  $i = 1;

                  foreach ($invoice as $new) {
                    $products = $this->shopping_model->get_product($new->id); ?>
                    <tr>
                      <td><?= $i; ?></td>
                      <td><?= $products->prod ?></td>
                      <td><?= '$'.$new->total ?></td>
                      <td>
                        <a href="<?php echo site_url('Shopping/invoice/'.$new->id) ?>" target="_blank"><i class="fa fa-eye"> View Invoice</i></a>
                      </td>
                    </tr>
                  <?php $i++;
                  } 
                } else {  ?>
                  <td colspan="4">No data available</td>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>