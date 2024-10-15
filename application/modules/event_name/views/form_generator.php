<div class="row">
    <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
        <div class="card-header bg-primary text-white">
            <?= ucwords($title_module) ?>
        </div>
        <div class="card">
            <div class="card-body">


                <h1>Create Form</h1>
                <form action="<?php echo site_url('cpanel/event_name/save_form'); ?>" method="POST">

                    <input type="text" name="event_id" value="<?php echo $event['id']; ?>">
                    <div class="form-group">
                        <label for="title">Form Title</label>
                        <input type="text" class="form-control" name="title" id="title" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description"></textarea>
                    </div>

                    <h3>Add Fields</h3>
                    <div id="fields-container"></div>

                    <button type="button" id="add-text" class="btn btn-info">Add Text Field</button>
                    <button type="button" id="add-radio" class="btn btn-info">Add Radio Field</button>
                    <button type="button" id="add-checkbox" class="btn btn-info">Add Checkbox Field</button>
                    <button type="button" id="add-textarea" class="btn btn-info">Add Textarea Field</button>
                    <button type="button" id="add-select" class="btn btn-info">Add Select Field</button> <!-- New Select Option Button -->

                    <br><br>
                    <button type="submit" class="btn btn-success">Save Form</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        let fieldCount = 0;

        $('#add-text').click(function() {
            $('#fields-container').append(`
            <div class="form-group">
                <label>Text Field Label</label>
                <input type="text" name="fields[${fieldCount}][label]" class="form-control" required>
                <input type="hidden" name="fields[${fieldCount}][type]" value="text">
            </div>
        `);
            fieldCount++;
        });

        $('#add-radio').click(function() {
            $('#fields-container').append(`
            <div class="form-group">
                <label>Radio Field Label</label>
                <input type="text" name="fields[${fieldCount}][label]" class="form-control" required>
                <input type="hidden" name="fields[${fieldCount}][type]" value="radio">
                <label>Options (comma separated)</label>
                <input type="text" name="fields[${fieldCount}][options]" class="form-control" required>
            </div>
        `);
            fieldCount++;
        });

        $('#add-checkbox').click(function() {
            $('#fields-container').append(`
            <div class="form-group">
                <label>Checkbox Field Label</label>
                <input type="text" name="fields[${fieldCount}][label]" class="form-control" required>
                <input type="hidden" name="fields[${fieldCount}][type]" value="checkbox">
                <label>Options (comma separated)</label>
                <input type="text" name="fields[${fieldCount}][options]" class="form-control" required>
            </div>
        `);
            fieldCount++;
        });

        $('#add-textarea').click(function() {
            $('#fields-container').append(`
            <div class="form-group">
                <label>Textarea Field Label</label>
                <input type="text" name="fields[${fieldCount}][label]" class="form-control" required>
                <input type="hidden" name="fields[${fieldCount}][type]" value="textarea">
            </div>
        `);
            fieldCount++;
        });

        $('#add-select').click(function() { // For Select Field
            $('#fields-container').append(`
            <div class="form-group">
                <label>Select Field Label</label>
                <input type="text" name="fields[${fieldCount}][label]" class="form-control" required>
                <input type="hidden" name="fields[${fieldCount}][type]" value="select">
                <label>Options (comma separated)</label>
                <input type="text" name="fields[${fieldCount}][options]" class="form-control" required>
            </div>
        `);
            fieldCount++;
        });
    });
</script>