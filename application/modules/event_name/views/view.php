<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card-header bg-primary text-white">
      <?=ucwords("Create Form")?>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
        <tr>
          <td>Event Name</td>
          <td><?=$name?></td>
        </tr>
      <tr>
        <td>Date start</td>
        <td><?=$date_start != "" ? date('d-m-Y',strtotime($date_start)):""?></td>
      </tr>
      <tr>
        <td>Date end</td>
        <td><?=$date_end != "" ? date('d-m-Y',strtotime($date_end)):""?></td>
      </tr>
        <tr>
          <td>Place</td>
          <td><?=$place?></td>
        </tr>
        <tr>
          <td>Description</td>
          <td><?=$description?></td>
        </tr>
        <tr>
          <td>Admin id</td>
          <td><?=$admin_id?></td>
        </tr>
        </table>

        <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger mt-3"><?=cclang("back")?></a>
      </div>
    </div>
  </div>
</div>
