<?php
$bantorj = mysql_fetch_array(mysql_query("SELECT prjcolor, prjcolor2, prjcolor3, prjcolor4, prjcolor5 FROM setting"));
	$bantorjf = "#$bantorj[0]";
	$bantorjff = "#$bantorj[1]";
	$bantorjfff = "#$bantorj[2]";
	$bantorjffff = "#$bantorj[3]";
	$bantorjfffff = "#$bantorj[4]";
	
?>

<div class="box">

    <div class="box-header">

        <h3 class="box-title"><i class="fa icon-invoice"></i> <?=$this->lang->line('panel_title')?></h3>



       

        <ol class="breadcrumb">

            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>

           
			<li><span style="color: <?php echo $bantorjf;?>;"><?=$this->lang->line('menu_setfee')?></span></li>
        </ol>

    </div><!-- /.box-header -->

    <!-- form start -->

    <div class="box-body">

        <div class="row">

            <div class="col-sm-12">



                <?php

                    $usertype = $this->session->userdata("usertype");

                    if($usertype == "Admin" || $usertype == "Accountant") {

                ?>

                <h5 class="page-header">

                    <a href="<?php echo base_url('setfee/add') ?>">

                        <i class="fa fa-plus"></i> 

                        <?=$this->lang->line('add_title')?>

                    </a>

                </h5>



                <div class="col-sm-6 col-sm-offset-3 list-group">

                    <div class="list-group-item list-group-item-warning" style="background-color: <?php echo $bantorjfff;?>;">

                        <form style="" class="form-horizontal" role="form" method="post">  

                            <div class="form-group">              

                                <label for="classesID" class="col-sm-2 col-sm-offset-2 control-label">

                                    <?=$this->lang->line("setfee_classesID")?>

                                </label>

                                <div class="col-sm-6">



                                    <?php

                                        $array = array("0" => $this->lang->line("setfee_select_classes"));

                                        foreach ($classes as $classa) {

                                            $array[$classa->classesID] = $classa->classes;

                                        }

                                        echo form_dropdown("classesID", $array, set_value("classesID"), "id='classesID' class='form-control'");

                                    ?>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

                <?php } ?>





            </div>

        </div>

    </div>

</div>



<script type="text/javascript">

    $('#classesID').change(function() {

        var classesID = $(this).val();

        if(classesID == 0) {

            $('#hide-table').hide();

        } else {

            $.ajax({

                type: 'POST',

                url: "<?=base_url('setfee/setfee_list')?>",

                data: "id=" + classesID,

                dataType: "html",

                success: function(data) {

                    window.location.href = data;

                }

            });

        }

    });

</script>