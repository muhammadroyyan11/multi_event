<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        <?=ucwords($title_module)?>
      </div>
      <div class="card-body">
          <form action="<?=$action?>" id="form" autocomplete="off">

          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control form-control-sm" placeholder="Name" name="name" id="name">
          </div>

          <div class="form-group">
            <label>Date start</label>
            <input type="date" class="form-control form-control-sm" placeholder="Date start" name="date_start" id="date_start">
          </div>

          <div class="form-group">
            <label>Date end</label>
            <input type="date" class="form-control form-control-sm" placeholder="Date end" name="date_end" id="date_end">
          </div>

          <div class="form-group">
            <label>Place</label>
            <input type="text" class="form-control form-control-sm" placeholder="Place" name="place" id="place">
          </div>

          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control text-editor" rows="3" data-original-label="description" name="description"></textarea>
            <div id="description"></div>
          </div>

          <div class="form-group">
            <label>Foto sampul</label>
            <input type="file" name="img" class="file-upload-default" data-id="foto_sampul" style="display: none;"/>
            <div class="input-group col-xs-12">
              <input type="hidden" class="file-dir" name="file-dir-foto_sampul" data-id="foto_sampul"/>
              <input type="text" class="form-control form-control-sm file-upload-info file-name" data-id="foto_sampul" placeholder="Foto sampul" readonly name="foto_sampul" />
            <span class="input-group-append">
              <button class="btn-remove-image btn btn-danger btn-sm" type="button" data-id="foto_sampul" style="display:<?=$foto_sampul!=''?'block':'none'?>;"><i class="ti-trash"></i></button>
              <button class="file-upload-browse btn btn-primary btn-sm" data-id="foto_sampul" type="button">Select File</button>
            </span>
            </div>
            <div id="foto_sampul"></div>
          </div>

          <div class="form-group">
            <label>Categories</label>
            <!--
              app_helper.php - methode is_select
              is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            <?=is_select("categories","categories_id","id","name");?>
          </div>

          <div class="form-group">
            <label>Admin</label>
            <!--
              app_helper.php - methode is_select
              is_select("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            <?=is_select("auth_user","admin_id","id_user","name");?>
          </div>

          <input type="hidden" name="submit" value="add">

          <div class="text-right">
            <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger"><?=cclang("cancel")?></a>
            <button type="submit" id="submit"  class="btn btn-sm btn-primary"><?=cclang("save")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$("#form").submit(function(e){
e.preventDefault();
var me = $(this);
$("#submit").prop('disabled',true).html('Loading...');
$(".form-group").find('.text-danger').remove();
$.ajax({
      url             : me.attr('action'),
      type            : 'post',
      data            :  new FormData(this),
      contentType     : false,
      cache           : false,
      dataType        : 'JSON',
      processData     :false,
      success:function(json){
        if (json.success==true) {
          location.href = json.redirect;
          return;
        }else {
          $("#submit").prop('disabled',false)
                      .html('<?=cclang("save")?>');
          $.each(json.alert, function(key, value) {
            var element = $('#' + key);
            $(element)
            .closest('.form-group')
            .find('.text-danger').remove();
            $(element).after(value);
          });
        }
      }
    });
});
</script>
