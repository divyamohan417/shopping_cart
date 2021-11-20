<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Tax</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="btn-group pull-right">
            <button type="button" class="btn btn-primary" onclick="add_tax()"><i class="fa fa-plus"></i> Add Tax</button>
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
                  <th>Tax</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($list)) {
                  $i= 1;
                  foreach ($list as $new) { ?>
                    <tr>
                      <td><?= $i ?></td>
                      <td><?= $new->tax.'%' ?></td> 
                      <td>
                        <button type="button" class="btn btn-primary" onclick="edit_tax('<?= $new->tax_id ?>','<?= $new->tax ?>')"><i class="fa fa-edit"></i></button>
                        <button type="button" class="btn btn-danger" onclick="delete_tax('<?= $new->tax_id ?>')"><i class="fa fa-trash"></i></button>
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
          <h4 class="modal-title"><b>Add Tax</b></h4>
          <button type="button" class="close" data-dismiss="modal" style="color: #000;">&times;</button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="row form-group">
                <div class="col-sm-6">
                  <label>Tax (in %):<span style="color: red">*</span></label>
                  <input type="number" class="form-control" name="tax" id="tax">
                  <span style="color: red" id="valid_tax"></span>
                </div>
                <div class="col-sm-6">
                  <button type="button" style="margin-top: 2em;" id="save" class="btn btn-success form-control" onclick="save_tax()">Add</button>

                  <button type="button" style="margin-top: 2em;display: none;" id="update" class="btn btn-warning form-control" onclick="update_tax()">Update</button>
                  <input type="hidden" name="tax_id" id="tax_id">
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
  function add_tax()
  {
    $('#myModal').modal('show');
    $("#tax").val('');
  }

  function save_tax()
  {
    var tax = $("#tax").val();

    $("#valid_tax").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/save_tax') ?>',
      'type' : "POST",
      'data' : {tax:tax},

      success:function(data){
        var obj = JSON.parse(data);

        if (obj.value == '1') {
          Swal.fire({
            allowOutsideClick: false,
            title:'Tax Added',
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

  function delete_tax(id=null) 
  {
    if (id) {
      Swal.fire({
        title: 'Are you Sure to Delete Tax?<br>Once deleted cannot be undone.',
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
            'url' : '<?php echo base_url('Shopping/delete_tax') ?>',
            'type' : "POST",
            'data' : {id:id},

            success:function(data){

              var obj = JSON.parse(data);

              if (obj.value == '1') {
                Swal.fire({
                  allowOutsideClick: false,
                  title:'Tax Removed',
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

  function edit_tax(id=null,tax=null)
  {
    if (id) {
      $('#myModal').modal('show');
      $("#tax").val(tax);
      $("#tax_id").val(id);
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

  function update_tax()
  {
    var tax = $("#tax").val();
    var tax_id = $("#tax_id").val();

    $("#valid_tax").text("");
    $("#valid_tax_id").text("");
    $.ajax({
      'url' : '<?php echo base_url('Shopping/edit_tax') ?>',
      'type' : "POST",
      'data' : {tax:tax, tax_id:tax_id},

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