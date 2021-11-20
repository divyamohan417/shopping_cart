<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Products List</h1>
        </div>

        <div class="col-sm-6" align="right">
          <a class="btn btn-warning" href="<?php echo base_url('shopping/view_cart'); ?>">
            <i class="fa fa-shopping-cart"></i> Cart
            <span style="color: red;font-size: 1.5em; font-weight: bold;" id="cart_count"><?php if ($cart_cnt!=0) { echo $cart_cnt;} ?></span>
          </a>

          <a class="btn btn-success" href="<?php echo base_url('shopping/invoice_list'); ?>">
            <i class="fa fa-eye"></i> Invoice
            <span style="color: red;font-size: 1.5em; font-weight: bold;"><?php if ($invoice!=0) { echo $invoice;} ?></span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row" style="margin-left: 10em;">
          <?php $i=1; foreach ($list as $new) { 
            $quan = $this->shopping_model->cart_list($new->product_id); ?>

            <div class="col-sm-3 form-group" style="background-color: #b2d4ff; border: 1px solid #ccc; height: 220px;margin-left: 1em;" align="center">
              <h4><?= $new->product ?></h4>
              <h3 class="text-danger"><?= '$'.$new->price ?></h3><br>
              <?php if ($quan) { ?>
                <h4> Quantity : <?= $quan->quantity ?></h4>
              <?php } else { ?>
                <input type="number" class="form-group" name="quantity" id="quantity<?= $i ?>" min="1" value="1"><br>
                <span id="valid_quantity<?= $i ?>" style="color: red; font-weight: bold;"></span><br>
              <?php } ?>

              <?php if ($quan) { ?>
                <button type="button" class="form-group btn btn-warning" name="cart" id="cart">Added to Cart</button>
                <button type="button" class="form-group btn btn-danger" name="remove" id="remove" onclick="remove_cart('<?= $quan->cart_id ?>')"><i class="fa fa-trash"> Remove</i></button>
              <?php } else { ?>
                <button type="button" class="form-group btn btn-success" name="cart" id="cart" onclick="add_to_cart('<?= $new->product_id ?>','<?= $i ?>')">Add to Cart</button>
              <?php } ?>
            </div>
          <?php $i++; } ?>
        </div>
      </div>
    </div>
  </section>
</div>

<script type="text/javascript">
  function add_to_cart(product_id=null,temp=null)
  {
    var quantity = $("#quantity"+temp).val();

    if (quantity > 0) {
      $.ajax({
        'url' : '<?php echo base_url('Shopping/add_to_cart') ?>',
        'type' : "POST",
        'data' : {product_id:product_id, quantity:quantity},

        success:function(data){
          var obj = JSON.parse(data);
          // console.log(obj);
          if (obj.value == '1') {
            Swal.fire({
              allowOutsideClick: false,
              title:'Product Added to Cart',
              type:'success',
              timmer:50000
            });
            $("#cart_count").text(obj.valid);
            location.reload();
          } else if (obj.value == '3') {
            Swal.fire({
              allowOutsideClick: false,
              title:'Something Went Wrong',
              type:'error',
              timmer:50000
            });
          }
        }
      })
    } else if (quantity == 0 || quantity == "") {
      $("#valid_quantity"+temp).text("Please enter valid quantity");
    }
  }

  function remove_cart(cartid=null)
  { 
    if (cartid) {
      Swal.fire({
        title: 'Are you Sure to Remove Product?<br>Once deleted cannot be undone.',
        type: 'warning',
        showCancelButton: true,
        allowOutsideClick: false,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText:"Cancel",
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            'url' : '<?php echo base_url('Shopping/remove_cart') ?>',
            'type' : "POST",
            'data' : {cartid:cartid},

            success:function(data){
              var obj = JSON.parse(data);
              // console.log(obj);
              if (obj.value == '1') {
                Swal.fire({
                  allowOutsideClick: false,
                  title:'Product Removed from Cart',
                  type:'success',
                  timmer:50000
                });
                // $("#cart_count").text(obj.valid);
                location.reload();
              } else if (obj.value == '3') {
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