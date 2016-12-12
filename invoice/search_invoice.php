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
        <h3 class="box-title"><i class="fa icon-sattendance"></i> <?=$this->lang->line('panel_title')?></h3>

       
        <ol class="breadcrumb">
            <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
            
            <li><span style="color: <?php echo $bantorjf;?>;"><?=$this->lang->line('menu_invoice')?></span></li>
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

                    <a href="javascript:mAdd();">

                        <i class="fa fa-plus"></i> 

                        <?=$this->lang->line('add_title')?>

                    </a>

                </h5>

                <?php } ?>

                <div class="col-sm-6 col-sm-offset-3 list-group">
                    <div class="list-group-item list-group-item-warning" style="background-color: <?php echo $bantorjfff;?>;">
                        <form style="" class="form-horizontal" role="form" method="post" onsubmit="return false;">  
                            
                            <div class="form-group">              
                                <label for="month" class="col-sm-2 col-sm-offset-2 control-label">
                                    Month
                                </label>
                                <div class="col-sm-6">
                                    <?php
                                        $array = array("0" => "Select Month",1=>'January - '.date("Y"),2=>'February - '.date("Y"),3=>'March - '.date("Y"),4=>'April - '.date("Y"),5=>'May - '.date("Y"),6=>'June - '.date("Y"),7=>'July - '.date("Y"),8=>'August - '.date("Y"),9=>'September - '.date("Y"),10=>'October - '.date("Y"),11=>'November - '.date("Y"),12=>'December - '.date("Y"));
                                        echo form_dropdown("month", $array, set_value("month"), "id='month' class='form-control'");
                                    ?>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div> <!-- col-sm-12 -->
        </div><!-- row -->
    </div><!-- Body -->
</div><!-- /.box -->

        <div class="modal fade" id="m_add">

          <div class="modal-dialog ml-modal">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>


                </div>

                <div class="modal-body" id="m_add_body">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                   
                </div>

            </div>

          </div>

        </div>

        <div class="modal fade" id="m_edit">

          <div class="modal-dialog md-modal">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>


                </div>

                <div class="modal-body" id="m_edit_body">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                   
                </div>

            </div>

          </div>

        </div>

<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>

<script type="text/javascript">
    $('#month').change(function() {
        var month = $(this).val();
        if(month == 0) {
            $('#hide-table').hide();
            $('.nav-tabs-custom').hide();
        } else {
            $.ajax({
                type: 'POST',
                url: "<?=base_url('invoice/invoice_list')?>",
                data: "month=" + month,
                dataType: "html",
                success: function(data) {
                   window.location.href = data;
                }
            });
        }

    });
    function mAdd(){
        $("body").addClass("pl-wait");
        $.ajax({

            type: 'POST',

            url: "<?=base_url('invoice/add')?>",

            dataType: "html",

            success: function(data) {
              $("#m_add_body").html(data);
              $('#m_add').modal("show");
            },
            complete: function(){
              $("body").removeClass("pl-wait");
            }

        });
    }
    function btn_add(){
        $("body").addClass("pl-wait");
        var formData = new FormData($("#add_frm")[0]);
        $.ajax({

            type: 'POST',

            url: "<?=base_url('invoice/add')?>",

            data: formData,

            dataType: "html",

            processData: false,
            contentType: false,

            success: function(data) {
              if(data=="ok"){
                    location.reload();
              }else{
                // alert("some error occured");
                $("#m_add_body").html(data);
              }
            },
            complete: function(){
              $("body").removeClass("pl-wait");
            }

        });
    }
</script>


