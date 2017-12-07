<script type="text/javascript">








    $(document).ready(function () {
        var cities = new Array();
        if ($("input#field-cp").length) {
            $('#field-cp').autocomplete({
                source: function (request, response) {
                    $.getJSON("<?php echo site_url('user/ajax/search_cities') ?>?criteria=" + request.term, function (data) {
                        response($.map(data, function (item) {
                            cities[item.postal_code] = item.name
                            return item.postal_code;
                        }));
                    });
                },
                minLength: 2,
                delay: 100,
                select: function (event, ui) {
                    selected = ui.item.value;
                    $('#field-ville').val(cities[ui.item.value]);
                }
            });
        }
        $('.export-anchor').attr('data-url', '<?php echo site_url('user/client/export_all') ?>');
        <?php if (isset($action_read) && $action_read) : ?>
        $('input[type="text"], textarea').attr('readonly', 'readonly');
        $('input[type="radio"], select').attr('disabled', 'disabled');
        <?php endif; ?>
		
    });
</script>

<?php echo isset($output) ? $output : ''; ?>
