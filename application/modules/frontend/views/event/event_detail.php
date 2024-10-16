<?php

function formatDate($date)
{
    $dateTime = new DateTime($date);

    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $day = $dateTime->format('d');
    $month = $months[(int)$dateTime->format('m')]; // Convert month to Indonesian
    $year = $dateTime->format('Y');

    return "$day $month $year";
}
?>

<!-- Blog Details Hero Section Begin -->
<section class="blog-hero-section set-bg" data-setbg="<?= base_url() ?>assets/frontEnd/img/blog/blog-details/blog-details-hero.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bh-text">

                    <h2><?= $row->name ?></h2>
                    <ul>
                        <li><span>By <strong>John Smith</strong></span></li>
                        <li><?= formatDate($row->date_start) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Hero Section End -->

<!-- Blog Details Section Begin -->
<section class="blog-details-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <div class="bd-text">
                    <div class="bd-title">
                        <?= $row->description ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Details Section End -->

<!-- Comment Form Section Begin -->
<div class="comment-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h3><?php echo $form['title']; ?></h3> <!-- Using dynamic title -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 m-auto">
                <form action="/form/submit_form/<?php echo $form['id']; ?>" method="POST" class="comment-form">
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <label for="">Pilih Kategori</label>
                            <select name="price" id="price" class="form-control">
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                foreach ($price as $key => $data) { ?>
                                    <option value="<?= $data->price?>"><?= $data->sub_categories?> - <?= $data->price?></option>
                                <?php }
                                ?>
                            </select>

                        </div>
                        <?php foreach ($fields as $field): ?>
                            <div class="<?php echo $field['field_type'] == 'textarea' ? 'col-lg-12' : 'col-lg-6'; ?>">
                                <div class="form-group">
                                    <label for="field-<?php echo $field['id']; ?>"><?php echo $field['field_label']; ?></label> <!-- Added Label -->

                                    <?php if ($field['field_type'] == 'text'): ?>
                                        <input type="text" id="field-<?php echo $field['id']; ?>" name="fields[<?php echo $field['id']; ?>]" class="form-control" placeholder="<?php echo $field['field_label']; ?>" required>

                                    <?php elseif ($field['field_type'] == 'textarea'): ?>
                                        <textarea id="field-<?php echo $field['id']; ?>" name="fields[<?php echo $field['id']; ?>]" class="form-control" placeholder="<?php echo $field['field_label']; ?>" required></textarea>

                                    <?php elseif ($field['field_type'] == 'select'): ?>
                                        <select id="field-<?php echo $field['id']; ?>" name="fields[<?php echo $field['id']; ?>]" class="form-control" required>
                                            <?php
                                            $options = explode(',', $field['field_options']);
                                            foreach ($options as $option): ?>
                                                <option value="<?php echo trim($option); ?>"><?php echo trim($option); ?></option>
                                            <?php endforeach; ?>
                                        </select>

                                    <?php elseif ($field['field_type'] == 'radio'): ?>
                                        <?php
                                        $options = explode(',', $field['field_options']);
                                        foreach ($options as $option): ?>
                                            <label><input type="radio" name="fields[<?php echo $field['id']; ?>]" value="<?php echo trim($option); ?>"> <?php echo trim($option); ?></label>
                                        <?php endforeach; ?>

                                    <?php elseif ($field['field_type'] == 'checkbox'): ?>
                                        <?php
                                        $options = explode(',', $field['field_options']);
                                        foreach ($options as $option): ?>
                                            <label><input type="checkbox" name="fields[<?php echo $field['id']; ?>][]" value="<?php echo trim($option); ?>"> <?php echo trim($option); ?></label>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <div class="col-lg-12 text-center">
                            <button type="submit" class="site-btn">Register</button> <!-- Change button text to "Register" -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Comment Form Section End -->

<!-- Comment Form Section End -->

<!-- Comment Form Section End -->