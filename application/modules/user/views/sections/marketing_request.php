<link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/libraries/grocery_crud/themes/flexigrid/css/flexigrid.css') ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/libraries/grocery_crud/css/jquery_plugins/jquery.ui.datetime.css') ?>" />
<link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/libraries/grocery_crud/css/jquery_plugins/jquery-ui-timepicker-addon.css') ?>" />
<script type="text/javascript" src="<?php echo site_url('assets/libraries/grocery_crud/js/jquery_plugins/jquery-ui-timepicker-addon.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/libraries/grocery_crud/js/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-fr.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/libraries/grocery_crud/js/jquery_plugins/ui/i18n/timepicker/jquery-ui-timepicker-fr.js') ?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/libraries/grocery_crud/js/jquery_plugins/config/jquery-ui-timepicker-addon.config.js') ?>"></script>
<script type="text/javascript">
    var js_date_format = 'dd/mm/yy';
    $(function () {
        $("#add-row").on('click', function () {
            var children = $("#search-form > .filter-wrapper > .filters").children().last().clone();
            $("#search-form > .filter-wrapper > .filters").append(children);
            $("#search-form > .filter-wrapper > .filters").children().last().removeClass('first-row');
        });
        $("#drop-row").on('click', function () {
            if (confirm("Voulez-vous vraiment supprimer la dernière ligne de condition?")) {
                if ($("#search-form > .filter-wrapper > .filters .row-condition").length > 1) {
                    $("#search-form > .filter-wrapper > .filters .row-condition").last().remove();
                } else {
                    alert("Vous ne pouvez pas supprimer cette condition");
                }
            }
        });
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
                        $('.get_action_toogle_search').hide();
                    }, 2000);
                },
                error: function () {
                    alert("Erreur pendant le chargement...");
                }
            });
        });
        $("#search-form").on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                url: "<?php echo site_url('user/ajax/save_query') ?>",
                type: "post",
                dataType: "json",
                data: $("#search-form").serialize(),
                success: function (data) {
                    $('#ajax-loader').show();
                    setTimeout(function () {
                        $('#ajax-loader').hide();
                        $('#search-results').html('<p class="alert alert-success"><strong>' + data.state + '</strong></p>');
                    }, 2000);
                },
                error: function () {
                    $('#ajax-loader').show();
                    setTimeout(function () {
                        $('#ajax-loader').hide();
                        $('#search-results').html('<p class="alert alert-warning"><strong>Une erreur est survenue pendant l\'enregistrement...</strong></p>');
                    }, 2000);
                }
            });
        });
    });

    function check_date_filter() {
        var filter = ($(".table_field").val());
        if (filter == 'dt_start' || filter == 'dt_end') {
            $(".table_value").addClass("datetime-input");
            $('.table_value').datetimepicker({
                timeFormat: 'HH:mm:ss',
                dateFormat: js_date_format,
                showButtonPanel: true,
                changeMonth: true,
                changeYear: true
            });
        } else {
            $(".table_value").removeClass("datetime-input");
            $(".table_value").removeClass("hasDatepicker");
            $('.table_value').unbind();
        }
    }

    function show_field_label(table, field_name) {
        var tables = JSON.parse('<?php echo $request_tables ?>');

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

    function load_filters(n, get_total = false) {
        $('#search-form .row-condition').hide();
        $('#search-form .form-bottom').hide();
        $('#search-results').html();
        $('#ajax-loader').show();
        setTimeout(function () {
            $('#ajax-loader').hide();
            var tables = JSON.parse('<?php echo $request_tables ?>');
            var conditions = JSON.parse('<?php echo $request_conditions ?>');

            $.each(tables, function (k, item) {
                if (k === n) {
                    display_filters(item, conditions, get_total);
                }
            });
        }, 2000);
    }

    function display_filters(item, conditions, get_total) {
        $('#search-form .form-bottom').show();
        var template = '<div class="row-condition first-row">';
        template += '   <div class="col-sm-1 operator">';
        template += '       <select class="table_operator" name="table_operator[]">';
        template += '           <option value="and">ET</option>';
        template += '           <option value="or">OU</option>';
        template += '       </select>';
        template += '   </div>';
        template += '   <div class="col-sm-3">';
        template += '       <input type="hidden" name="table_selection[]" class="table_selection" value="' + item.name + '"/>';
        template += '       <select onchange="check_date_filter()" class="table_field" name="table_field[]">';
        $.each(item.fields, function (k, field) {
            template += '       <option value="' + field.name + '">' + field.display_as + '</option>';
        });
        template += '       </select>';
        template += '   </div>';
        template += '   <div class="col-sm-3">';
        template += '       <select class="table_condition" name="table_condition[]">';
        $.each(conditions, function (k, condition) {
            template += '       <option value="' + condition.condition + '">' + condition.display_as + '</option>';
        });
        template += '       </select>';
        template += '   </div>';
        template += '   <div class="col-sm-3">';
        template += '       <input type="text" name="table_value[]" class="table_value" placeholder="" />';
        template += '   </div>';
        template += '</div>';
        template += ''
        $("#search-form > .filter-wrapper > .filters").html(template);
    }
	
	 $(document).ready(function () {
        $("input[type='radio'][name='switch-alert']").on("change",function () {
		
		
            if ($(this).val() == 1 || $(this).val() == "1") {
                
            } else {
              
            }
        });
		
		$(".switch-label").on("click",function(){
				alert("fdfdffffff");
		});
    });

</script>
<div id="ajax-loader">
    <img width="60" src="<?php echo site_url('assets/frontend/design/icons/loader.gif') ?>" alt="loader" />
</div>
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/dashboard') ?>">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="<?php echo site_url('user/marketing/request') ?>">Marketing</a></li>
    <li class="breadcrumb-item active">Outils de requ&ecirc;te</li>
</ol>
<?php echo isset($output) ? $output : ''; ?>
<div class="flexigrid content-wrapper">
    <div class="mDiv">
        <div class="ftitle">
            <div class="ftitle-left">Outil de requ&ecirc;tage</div>
            <div class="clear"></div>
        </div>
    </div>
    <div class="form-div">
        <form id="search-form" class="form-inline" action="<?php echo site_url('user/ajax/save_query') ?>" method="post">
            <div class="row">
                <h2>Sur quoi porte votre requ&ecirc;te ?</h2>
                <p>Veuillez choisir le domaine de votre recherche pour commencer.</p>
                <div class="search-by-topic col-xs-12 col-sm-6 col-md-4">
                    <ul>
                        <li><a onclick="load_filters(0);" href="javascript:void(0)">Client en particulier ?</a></li>
                        <li><a onclick="load_filters(1);" href="javascript:void(0)">Rendez-vous ?</a></li>
                        <li><a onclick="load_filters(2);" href="javascript:void(0)">Produits rattach&eacute;s &agrave; un rendez-vous ?</a></li>
                    </ul>
                </div>
                <div class="search-by-topic col-xs-12 col-sm-6 col-md-4">
                    <ul>
                        <li><a onclick="load_filters(2, true);" href="javascript:void(0)">Produit par client ?</a></li>
                        <li><a onclick="load_filters(3, true);" href="javascript:void(0)">Nombre de chien par client ?</a></li>
                        <li><a onclick="load_filters(3);" href="javascript:void(0)">Chiens ?</a></li>
                    </ul>
                </div>
            </div>
            <div class="request-row col-sm-12">
                <label for="request_name">Nommer la requ&ecirc;te</label><input id="request_name" name="request_name" type="text" required="required" />
            </div>
            <div class="filter-wrapper">
                <div class="filters"></div>
            </div>
            <div class="clear"></div>
            <div class="col-sm-12">
                <ul class="form-bottom">
                    <li><span class="btn btn-large" id="add-row"><i class="fa fa-plus-square">&nbsp;</i>Ajouter une condition</span></li>
                    <li><span class="btn btn-large" id="drop-row"><i class="fa fa-minus-square">&nbsp;</i>Retirer la derni&egrave;re condition</span></li>
                    <li><span class="btn btn-large" id="search-row"><i class="fa fa-search">&nbsp;</i>Tester la requ&ecirc;te</span></li>
                </ul>
            </div>
            <div class="clear"></div>
            <div class="col-sm-12">
                <input type="submit" name="save-row" id="save-row" value="Enregistrer"/>
            </div>
            <div class="clear"></div>
        </form>
        <div class="result-wrapper">
            <div id="search-results"></div>
			
			<div id="list_chien"></div>
        </div>
		
		
    </div>
    <div class="clear"></div>
</div>
<style type="text/css">
    .btn {
        background: #65bd63 !important;
        background-color: #65bd63 !important;
        color: #ffffff !important;
        border: none !important;
    }
    .btn:hover, .btn:hover, .btn:hover {
        box-shadow: 0 5px 11px 0 rgba(0,0,0,0.18),0 4px 15px 0 rgba(0,0,0,0.15) !important;
        background-color: #65bd63 !important;
    }
	.switch {
		position: relative;
		height: 27px;
		width: 120px;
		margin: 20px auto;
		background: #fff;
		border: 1px solid #ddd;
		border-radius: 3px;
	}
</style>