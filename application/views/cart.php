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
          <div class="col-sm-6"><h1>Order Details</h1></div>
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
                  <th>Product</th>
                  <th>Unit Price </th>
                  <th>Quantity</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (!empty($cart_products)) {
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
                  } 
                } else { ?>
                  <td colspan="5">No data available</td>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
 
    <?php if (!empty($cart_products)) { ?>
      <div class="row">
        <div class="col-sm-12">
          <div class="row form-group">
            <div class="col-sm-6">
              <label>Tax:</label>
              <select class="form-control" name="tax" id="tax" onchange="calculate('<?= $sub_total ?>')">
                <option value="">-- Select Tax --</option>
                <?php foreach ($tax as $new1) { ?>
                  <option value="<?= $new1->tax ?>"><?= $new1->tax.'%' ?></option>
                <?php } ?>
              </select>
              <span style="color: red;" id="valid_tax"></span>
            </div>

            <div class="col-sm-6">
              <label>Discount:</label>
              <select class="form-control" name="discount" id="discount" onchange="calculate('<?= $sub_total ?>')">
                <option value="">-- Select Discount --</option>
                <?php foreach ($discount as $new2) { ?>
                  <option value="<?= $new2->discount ?>"><?= $new2->discount.'%' ?></option>
                <?php } ?>
              </select>
              <span style="color: red;" id="valid_discount"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="display: none;" id="total_price">
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="col-sm-6">
                <table class="table table-bordered table-striped">
                  <tr>
                    <th>Subtotal:</th>
                    <td>
                      <?= '$'.$sub_total ?>
                      <input type="hidden" class="form-control" name="total" id="total" value="<?= $sub_total ?>">    
                    </td>
                  </tr>

                  <tr>
                    <th>Tax<span id="taxx"></span>:</th>
                    <td>
                      <span class="sub_tax"></span>
                      <input type="hidden" class="form-control" id="sub_taxx" value="">   
                    </td>
                  </tr>

                  <tr>
                    <th>Subtotal With tax:</th>
                    <td>
                      <span class="total_wtax"></span>
                      <input type="hidden" class="form-control" id="wtax" value="">   
                    </td>
                  </tr>

                  <tr>
                    <th>Discount<span id="disc"></span>:</th>
                    <td>
                      <span class="sub_disc"></span>
                      <input type="hidden" class="form-control" id="sub_discount" value="">   
                    </td>
                  </tr>

                  <tr>
                    <th>Grand Total:</th>
                    <td>
                      <span class="grant" style="color: red; font-weight: bold;font-size: 1.5em;"></span>
                      <input type="hidden" class="form-control" id="grant_total" value="">   
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row" style="display: none;" id="total_price1">
        <div class="col-sm-12">
          <button type="button" class="btn btn-danger" onclick="clear_cart()">Clear Cart</button>
          <button type="button" class="btn btn-warning" onclick="continue_purchase()">Continue Purchase</button>
          <button type="button" class="btn btn-success" onclick="confirm_order()">Confirm Order</button>
          <button type="button" class="btn btn-success" id="invoice" style="display: none;">Generate Invoice</button>
        </div>
      </div>
    <?php } ?>
  </section>
</div>

<script type="text/javascript">

  function calculate(total=null) 
  {
    var tax = $("#tax").val();
    var discount = $("#discount").val();
    // alert(total+' | '+tax+' | '+discount);
    $("#valid_tax").text("");
    $("#valid_discount").text("");
    $("#total_price").hide();
    $("#total_price1").hide();

    if (!tax) {
      $("#valid_tax").text("Tax is required");
    }
    if (!discount) {
      $("#valid_discount").text("Discount is required");
    }
    if (total && tax && discount) {

      var tax_rate = (tax / 100) * total;

      $("#taxx").text("("+tax+"%)");
      $(".sub_tax").text('$'+tax_rate);
      $("#sub_taxx").val(tax_rate);

      var wtax = parseInt(tax_rate) + parseInt(total);

      $(".total_wtax").text('$'+wtax);
      $("#wtax").val(wtax);

      var discount_rate = (discount / 100) * total;

      $("#disc").text("("+discount+"%)");
      $(".sub_disc").text('$'+discount_rate);
      $("#sub_discount").val(discount_rate);

      var tot_price = wtax - discount_rate;

      $(".grant").text('$'+tot_price);
      $("#grant_total").val(tot_price);

      $("#total_price").show();
      $("#total_price1").show();
    }
  }

  function clear_cart()
  {
    Swal.fire({
      title: 'Are you Sure to Clear Cart?',
      type: 'warning',
      showCancelButton: true,
      allowOutsideClick: false,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText:"Cancel",
      confirmButtonText: 'Clear'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          'url' : '<?php echo base_url('Shopping/clear_cart') ?>',
          'type' : "POST",
          'data' : {},

          success:function(data){

            if (data == '1') {
              Swal.fire({
                allowOutsideClick: false,
                title:'Cart Cleared',
                type:'success',
                timmer:50000
              }).then((result) => {
                if (result.value) {
                  window.location.href = "<?php echo base_url() ?>";
                }
              })
            } else if (data == '2') {
              Swal.fire({
                allowOutsideClick: false,
                title:'Something Went Wrong',
                type:'error',
                timmer:50000
              });
            }
          }
        })
      }
    });
  }

  function continue_purchase()
  {
    window.location.href = "<?php echo base_url() ?>";
  }

  function confirm_order()
  {
    var total = $("#total").val();
    var sub_taxx = $("#sub_taxx").val();
    var wtax = $("#wtax").val();
    var sub_discount = $("#sub_discount").val();
    var grant_total = $("#grant_total").val();
    var discount = $("#discount").val();
    var tax = $("#tax").val();

    if (total && sub_taxx && wtax && sub_discount && grant_total && discount && tax) {
      $.ajax({
        'url' : '<?php echo base_url('Shopping/confirm_order') ?>',
        'type' : "POST",
        'data' : {total:total, sub_taxx:sub_taxx, wtax:wtax, sub_discount:sub_discount, grant_total:grant_total, discount:discount, tax:tax},

        success:function(data){
          var obj = JSON.parse(data);
          if (obj.value == '1') {
            Swal.fire({
              allowOutsideClick: false,
              title:'Order Confirmed!',
              type:'success',
              timmer:50000
            }).then((result) => {
              if (result.value) {
                window.location.href = "<?php echo base_url('Shopping/order_details/') ?>"+obj.order_id;
              }
            })
          } else if (obj.value == '2') {
            Swal.fire({
              allowOutsideClick: false,
              title:'Something Went Wrong',
              type:'error',
              timmer:50000
            });
          }
        }
      })
    } else {
      Swal.fire({
        allowOutsideClick: false,
        title:'Something Went Wrong',
        type:'error',
        timmer:50000
      });
    }
  }
</script>