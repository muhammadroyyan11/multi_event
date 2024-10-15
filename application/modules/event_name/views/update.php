<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        <?=ucwords($title_module)?>
      </div>
      <div class="card-body">
          <form action="<?=$action?>" id="form" autocomplete="off">
          
          <div class="form-group">
            <label>Event Name</label>
            <input type="text" class="form-control form-control-sm" placeholder="Event Name" name="name" id="name" value="<?=$name?>">
          </div>
        
          <div class="form-group">
            <label>Date start</label>
            <input type="date" class="form-control form-control-sm" placeholder="Date start" name="date_start" id="date_start" value="<?=$date_start?>">
          </div>
        
          <div class="form-group">
            <label>Date end</label>
            <input type="date" class="form-control form-control-sm" placeholder="Date end" name="date_end" id="date_end" value="<?=$date_end?>">
          </div>
        
          <div class="form-group">
            <label>Place</label>
            <input type="text" class="form-control form-control-sm" placeholder="Place" name="place" id="place" value="<?=$place?>">
          </div>
        
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control text-editor" rows="3" data-original-label="description" name="description" id="description"><?=$description?></textarea>
          </div>
        
          <div class="form-group">
            <label>Admin id</label>
            <!--
              app_helper.php - methode is_radio
              is_radio("table", "attribute`id & name`", "value", "label", "entry_value`optional`");
            --->
            <?=is_radio("auth_user","admin_id","id_user","name","$admin_id");?>
          </div>
        
          <input type="hidden" name="submit" value="update">

          <div class="text-right">
            <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger"><?=cclang("cancel")?></a>
            <button type="submit" id="submit"  class="btn btn-sm btn-primary"><?=cclang("update")?></button>
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
