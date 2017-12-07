<script type="text/javascript">
    $(function () {
        $('#filters').insertAfter('#request_name_field_box');
        $("#search-row").on('click', function () {
            $('#search-results').html('recherche en cours');
            $.ajax({
                url: "<?php echo site_url('user/ajax/query_simulation') ?>",
                type: "post",
                data: $("#search-form").serialize(),
                success: function (html) {
                    $html = html;
                    $('#ajax-loader').show();
                    setTimeout(function () {
                        $('#ajax-loader').hide();
                        $('#search-results').html($html);
                    }, 2000);
                },
                error: function () {
                    alert("Erreur pendant le chargement...");
                }
            });
        });
    });
    function show_field_label(table, field_name) {
        var tables = JSON.parse('<?php echo json_encode($request_tables) ?>');
        switch (table) {
            case 'client':
                n = 0;
                break;
            case 'rdv':
                n = 1;
                break;
            case 'prd_rdv':
                n = 2;
                break;
        }

        var current_field_name = field_name;
        var display = current_field_name;

        $.each(tables, function (k, item) {
            if (k === n) {
                $.each(item.fields, function (k, field) {
                    if (field.name === current_field_name) {
                        display = field.display_as;
                    }
                });
            }
        });

        return "<strong>" + display + "</strong>";
    }
</script>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Outils de requ&ecirc;te</li>
</ol>
<?php echo isset($output) ? $output : ''; ?>
<div id="search-results"></div>



<div id="list_chien"></div>




<?php if (isset($request)): ?>
    <div class="form-field-box odd" id="filters">
        <form id="search-form" class="form-inline" method="post" action="<?php echo site_url('user/ajax/query_simulation') ?>">
			<input type="hidden" id="namesearch" name="namesearch" value="" />
			<input type="hidden" id="namesearchval" name="namesearchval" value="" />
			<input type="hidden" id="sort_col" name="sort_col" value="" />
<input type="hidden" id="sort_val" name="sort_val" value="" />
            <div class="filter-wrapper">
                <div class="filters">
                    <?php $data = json_decode($request->data_posted);
                    ?>
                    <?php $table_size = sizeof($data->table_selection); ?>
                    <?php $i = 0; ?>
                    <?php while ($i < 2): ?>
                        <div class="row-condition<?php echo $i == 0 ? ' first-row' : ''; ?>">
                            <div class="col-sm-1 operator">
                                <select class="table_operator" name="table_operator[]" readonly>
                                    <option value="and"<?php echo isset($data->table_operator[$i]) && $data->table_operator[$i] == 'and' ? ' selected="selected"' : ''; ?>>ET</option>
                                    <option value="or"<?php echo isset($data->table_operator[$i]) && $data->table_operator[$i] == 'or' ? ' selected="selected"' : ''; ?>>OU</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="hidden" name="table_selection[]" class="table_selection" value="<?php echo isset($data->table_selection[$i]) ? $data->table_selection[$i] : '' ?>"/>
                                <?php
                                $value = isset($data->table_field[$i]) ? $data->table_field[$i] : '';
                                $display_as = $value;
                                if (isset($request_tables)) {
                                    foreach ($request_tables AS $table) {
                                        if (isset($table['fields'])) {
                                            foreach ($table['fields'] AS $fields) {
                                                if ($fields['name'] == $value) {
                                                    $display_as = $fields['display_as'];
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                                <select class="table_field" name="table_field[]">
                                    <option value="<?php echo $value ?>"><?php echo $display_as ?></option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <?php
                                $value = isset($data->table_condition[$i]) ? $data->table_condition[$i] : '';
                                $display_as = $value;
                                if (isset($request_conditions)) {
                                    foreach ($request_conditions AS $condition) {
                                        if ($condition['condition'] == $value) {
                                            $display_as = $condition['display_as'];
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <select class="table_condition" name="table_condition[]">
                                    <option value="<?php echo $value ?>"><?php echo $display_as ?></option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="table_value[]" class="table_value" value="<?php echo isset($data->table_value[$i]) ? $data->table_value[$i] : ''; ?>" readonly="readonly"/>
                            </div>
                        </div>
                        <?php if (isset($data->table_field[$i + 1]) && !empty($data->table_field[$i + 1])): ?>
                            <?php $i++; ?>
                        <?php else: ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
                
				
				<span class="btn btn-large" id="search-row"><i class="fa fa-search"> Ex&eacute;cuter</i>
            </div>
        </form>
    </div>
<?php endif; ?>
