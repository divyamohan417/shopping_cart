<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Discount</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary" onclick="add_discount()"><i class="fa fa-plus"></i> Add Discount</button>
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
                  <th>Discount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($list)) {
                  $i= 1;
                  foreach ($list as $new) { ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $new->discount.'%' ?></td> 
                      <td>
                        <button type="button" class="btn btn-primary" onclick="edit_discount('<?= $new->discount_id ?>','<?= $new->discount ?>')"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="delete_discount('<?= $new->discount_id ?>')"><i class="fa fa-trash"></i></button>
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
          <h4 class="modal-title"><b>Add Discount</b></h4>
          <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="row form-group">
                <div class="col-sm-6">
                  <label>Discount (in %):<span style="color: red">*</span></label>
                  <input type="number" class="form-control" name="discount" id="discount">
                  <span style="color: red" id="valid_discount"></span>
                </div>
                <div class="col-sm-6">
                  <button type="button" style="margin-top: 2em;" id="save" class="btn btn-success form-control" onclick="save_discount()">Add</button>

                  <button type="button" style="margin-top: 2em;display: none;" id="update" class="btn btn-warning form-control" onclick="update_discount()">Update</button>
                  <input type="hidden" name="discount_id" id="discount_id">
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
  function add_discount()
  {
    $('#myModal').modal('show');
    $("#discount").val('');
  }

  function save_discount()
  {
    var discount = $("#discount").val();

    $("#valid_discount").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/save_discount') ?>',
      'type' : "POST",
      'data' : {discount:discount},

      success:function(data){
        var obj = JSON.parse(data);

        if (obj.value == '1') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Discount Added',
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

  function delete_discount(id=null) 
  {
    if (id) {
      Swal.fire({
        title: 'Are you Sure to Delete Discount?<br>Once deleted cannot be undone.',
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
            'url' : '<?php echo base_url('Shopping/delete_discount') ?>',
            'type' : "POST",
            'data' : {id:id},

            success:function(data){

              var obj = JSON.parse(data);

              if (obj.value == '1') {
                Swal.fire({
                  allowOutsideClick: false,
                  title:'Discount Removed',
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

  function edit_discount(id=null,discount=null)
  {
    if (id) {
      $('#myModal').modal('show');
      $("#discount").val(discount);
      $("#discount_id").val(id);
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

  function update_discount()
  {
    var discount = $("#discount").val();
    var discount_id = $("#discount_id").val();

    $("#valid_discount").text("");
    $("#valid_discount_id").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/edit_discount') ?>',
      'type' : "POST",
      'data' : {discount:discount, discount_id:discount_id},

      success:function(data){
        var obj = JSON.parse(data);

        if (obj.value == '1') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Discount Updated',
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