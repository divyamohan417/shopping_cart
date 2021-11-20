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
        <h1>Order Details</h1>
        <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product</th>
                  <th>Unit Price </th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                $sub_total = 0;
                foreach ($cart_products as $new) { ?>
                  <tr>
                    <td><?= $i; ?></td>
                    <td><?= $new->product ?></td>
                    <td><?= '$'.$new->price ?></td>
                    <td><?= $new->quantity ?></td>
                    <td>
                      <?php 
                        $total = $new->price * $new->quantity;
                        $sub_total = $sub_total + ($new->price * $new->quantity);
                        echo '$'.$total;
                      ?>
                    </td>
                  </tr>
                <?php $i++;
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="col-sm-6">
              <table class="table table-bordered table-striped">
                <tr>
                  <th>Subtotal:</th>
                  <td>
                    <span><?= '$'.$order_details->without_tax ?></span>    
                  </td>
                </tr>

                <tr>
                  <th>Tax (<?= $order_details->tax_per ?>%):</th>
                  <td>
                    <span><?= '$'.$order_details->tax ?></span>   
                  </td>
                </tr>

                <tr>
                  <th>Subtotal With tax:</th>
                  <td>
                    <span><?= '$'.$order_details->with_tax ?></span>   
                  </td>
                </tr>

                <tr>
                  <th>Discount (<?= $order_details->discount_per ?>%):</th>
                  <td>
                    <span><?= '$'.$order_details->discount ?></span>   
                  </td>
                </tr>

                <tr>
                  <th>Grand Total:</th>
                  <td>
                    <span style="color: red; font-weight: bold;font-size: 1.5em;"><?= '$'.$order_details->total ?></span>  
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <button type="button" class="btn btn-warning" onclick="continue_purchase()">Home</button>

        <button type="button" class="btn btn-success" title="Generate Invoice" onclick="continue_purchase(1)"><i class="fa fa-print"> Generate Invoice</i></button>

        <form method="POST" id="generate" action="<?php echo site_url('Shopping/invoice/'.$order_id) ?>" target="_blank">
        </form>
        
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">

  function continue_purchase(temp=null)
  {
    if (temp) {
      $("#generate").submit();
      window.location.href = "<?php echo base_url() ?>";
    } else {
      window.location.href = "<?php echo base_url() ?>";
    }
  }
</script>