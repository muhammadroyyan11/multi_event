<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?=ucwords($title_module)?></h4>
          <div class="pull-right">
                          <a href="<?=url("event_name/add")?>" class="btn btn-success btn-flat"><i class="fa fa-file btn-icon-prepend"></i> Add</a>
                                      <button type="button" id="filter-show" class="btn btn-primary btn-flat"><i class="mdi mdi-backup-restore btn-icon-prepend"></i> Filter</button>
                      </div>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <form autocomplete="off" class="content-filter">
              <div class="row">
                                  <div class="form-group col-md-6">
                                          <input type="text" id="name" class="form-control form-control-sm" placeholder="Event Name" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="date" id="date_start" class="form-control form-control-sm" placeholder="Date start" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="date" id="date_end" class="form-control form-control-sm" placeholder="Date end" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="place" class="form-control form-control-sm" placeholder="Place" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="description" class="form-control form-control-sm" placeholder="Description" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <label class="mb-0">Admin id</label>
                      <!--
                          app_helper.php - methode is_radio
                          is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
                        --->
                      <?=is_radio_filter("auth_user","admin_id","id_user","name");?>
                                      </div>

                              </div>
              <div class="pull-right">
                <button type='button' class='btn btn-default btn-sm' id="filter-cancel"><?=cclang("cancel")?></button>
                <button type="button" class="btn btn-primary btn-sm" id="filter">Filter</button>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table display" name="table" id="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
							<th>Event Name</th>
							<th>Date start</th>
							<th>Date end</th>
							<th>Place</th>
							<th>Description</th>
							<th>Admin id</th>
                    <th>#</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




<script type="text/javascript">
  $(document).ready(function() {
    var table;
    //datatables
    table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      "ordering": true,
      "searching": false,
      "info": true,
      "bLengthChange": false,
      oLanguage: {
        sProcessing: '<i class="fa fa-spinner fa-spin fa-fw"></i> Loading...'
      },

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= url("event_name/json")?>",
        "type": "POST",
         "data": function(data) {
                                          data.name = $("#name").val();
                                                        data.date_start = $("#date_start").val();
                                                        data.date_end = $("#date_end").val();
                                                        data.place = $("#place").val();
                                                        data.description = $("#description").val();
                                                        data.admin_id = $("#admin_id:checked").val();
                                    }
              },

      //Set column definition initialisation properties.
      "columnDefs": [
        
					{
            "targets": 0,
            "orderable": false
          },

					{
            "targets": 1,
            "orderable": false
          },

					{
            "targets": 2,
            "orderable": false
          },

					{
            "targets": 3,
            "orderable": false
          },

					{
            "targets": 4,
            "orderable": false
          },

					{
            "targets": 5,
            "orderable": false
          },

        {
          "className": "text-center",
          "orderable": false,
          "targets": 6
        },
      ],
    });

    $("#reload").click(function() {
                        $("#name").val("");
                  $("#date_start").val("");
                  $("#date_end").val("");
                  $("#place").val("");
                  $("#description").val("");
                  $("#admin_id").val("");
                    table.ajax.reload();
    });

          $(document).on("click", "#filter-show", function(e) {
        e.preventDefault();
        $(".content-filter").slideDown();
      });

      $(document).on("click", "#filter", function(e) {
        e.preventDefault();
        $("#table").DataTable().ajax.reload();
      })

      $(document).on("click", "#filter-cancel", function(e) {
        e.preventDefault();
        $(".content-filter").slideUp();
      });
    
    $(document).on("click", "#delete", function(e) {
      e.preventDefault();
      $('.modal-dialog').addClass('modal-sm');
      $("#modalTitle").text('<?=cclang("confirm")?>');
      $('#modalContent').html(`<p class="mb-4"><?=cclang("delete_description")?></p>
                              <div class="pull-right">
  														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
  	                          <button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=` + $(this).attr('alt') + `  data-url=` + $(this).attr('href') + `><?=cclang("delete_action")?></button>
  														</div>`);
      $("#modalGue").modal('show');
    });


    $(document).on('click', '#ya-hapus', function(e) {
      $(this).prop('disabled', true)
        .text('Processing...');
      $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        success: function(json) {
          $('#modalGue').modal('hide');
          swal(json.msg, {
            icon: json.type_msg
          });
          $('#table').DataTable().ajax.reload();
        }
      });
    });


  });
</script>