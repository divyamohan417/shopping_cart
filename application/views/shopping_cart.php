<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Products</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary" onclick="add_product()"><i class="fa fa-plus"></i> Add Product</button>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="content">
    <div class="row" style="margin-top: 1em;">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sl No.</th>
                  <th>Product</th>
                  <th>Unit Price</th>
                  <!-- <th>Tax</th> -->
                  <th>Staus</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($list)) {
                  $i= 1;
                  foreach ($list as $new) { ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $new->product ?></td>
                      <td><?= $new->price ?></td>
                      <!-- <td><?= $new->tax ?></td> -->
                      <td><?php if ($new->status == 1) { echo "Active"; } else { echo "Not Active"; }  ?></td>
                      <td>
                        <button type="button" class="btn btn-primary" onclick="edit_product('<?= $new->product_id ?>','<?= $new->product ?>','<?= $new->price ?>','<?= $new->status ?>')"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="delete_product('<?= $new->product_id ?>')"><i class="fa fa-trash"></i></button>
                      </td>
                    </tr>
                  <?php  $i++; }
                } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<div class="container">
  <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #1ba32cbf;">
          <h4 class="modal-title"><b>Add Product</b></h4>
          <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="row form-group">
                <div class="col-sm-6">
                  <label>Product Name:<span style="color: red">*</span></label>
                  <input type="text" name="product" id="product" class="form-control">
                  <span style="color: red" id="valid_product"></span>
                </div>
                <div class="col-sm-6">
                  <label>Unit Price (in $):<span style="color: red">*</span></label>
                  <input type="number" name="price" id="price" class="form-control">
                  <span style="color: red" id="valid_price"></span>
                </div>
              </div>
              <div class="row form-group">
                <!-- <div class="col-sm-6">
                  <label>Tax (in %):<span style="color: red">*</span></label>
                  <select class="form-control" name="tax" id="tax">
                    <option value="">-- Select Tax --</option>
                    <option value="5">5</option>
                  </select>
                  <span style="color: red" id="valid_tax"></span>
                </div> -->
                <div class="col-sm-6">
                  <label>Status:<span style="color: red">*</span></label>
                  <select class="form-control" name="status" id="status">
                    <option value="">-- Select Status --</option>
                    <option value="1">Active</option>
                    <option value="2">Not Active</option>
                  </select>
                  <span style="color: red" id="valid_status"></span>
                </div>
                <div class="col-sm-6">
                  <button type="button" style="margin-top: 2em;" id="save" class="btn btn-success form-control" onclick="save_product()">Add</button>

                  <button type="button" style="margin-top: 2em;display: none;" id="update" class="btn btn-warning form-control" onclick="update_product()">Update</button>
                  <input type="hidden" name="product_id" id="product_id">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  function add_product()
  {
    $('#myModal').modal('show');
    $("#product").val('');
    $("#price").val('');
    $("#status").val('');
  }

  function save_product()
  {
    var product = $("#product").val();
    var price = $("#price").val();
    var status = $("#status").val();
    // var tax = $("#tax").val();

    $("#valid_product").text("");
    $("#valid_price").text("");
    $("#valid_status").text("");
    // $("#valid_tax").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/save_product') ?>',
      'type' : "POST",
      'data' : {product:product, price:price, status:status},/*, tax:tax*/

      success:function(data){
        var obj = JSON.parse(data);

        if (obj.value == '1') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Product Added',
            type:'success',
            timmer:50000
          });
          location.reload();
        } else if (obj.value == '3') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Something Went Wrong',
            type:'error',
            timmer:50000
          });
        } else if(obj.value == '2') {
          $.each(obj.valid, function(index, value){
            $('#valid_'+index).text(value);
          });
        }
      }
    })
  }

  function delete_product(id=null) 
  {
    if (id) {
      Swal.fire({
        title: 'Are you Sure to Delete Product?<br>Once deleted cannot be undone.',
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
            'url' : '<?php echo base_url('Shopping/delete_product') ?>',
            'type' : "POST",
            'data' : {id:id},

            success:function(data){

              var obj = JSON.parse(data);

              if (obj.value == '1') {
                Swal.fire({
                  allowOutsideClick: false,
                  title:'Product Removed',
                  type:'success',
                  timmer:50000
                });
                location.reload();
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
        }
      });
    } else {
      Swal.fire({
        allowOutsideClick: false,
        title:'Something Went Wrong',
        type:'error',
        timmer:50000
      });
    }
  }

  function edit_product(id=null,product=null,price=null,status=null)
  {
    if (id) {
      $('#myModal').modal('show');
      $("#product").val(product);
      $("#price").val(price);
      $("#status").val(status);
      $("#product_id").val(id);
      $("#save").hide();
      $("#update").show();
    } else {
      Swal.fire({
        allowOutsideClick: false,
        title:'Something Went Wrong',
        type:'error',
        timmer:50000
      });
    }
  }

  function update_product()
  {
    var product = $("#product").val();
    var price = $("#price").val();
    var status = $("#status").val();
    var product_id = $("#product_id").val();

    $("#valid_product").text("");
    $("#valid_price").text("");
    $("#valid_status").text("");
    $("#valid_product_id").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/edit_product') ?>',
      'type' : "POST",
      'data' : {product:product, price:price, status:status, product_id:product_id},

      success:function(data){
        var obj = JSON.parse(data);

        if (obj.value == '1') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Product Updated',
            type:'success',
            timmer:50000
          });
          location.reload();
        } else if (obj.value == '3') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Something Went Wrong',
            type:'error',
            timmer:50000
          });
        } else if(obj.value == '2') {
          $.each(obj.valid, function(index, value){
            $('#valid_'+index).text(value);
          });
        }
      }
    })
  }
</script>