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
                                        echo form_dropdown("month", $array, set_value("month",$month), "id='month' class='form-control'");
                                    ?>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>

                <div class="clearfix"></div>


                <div id="hide-table">

                    <table id="example1" class="table table-striped table-bordered table-hover dataTable no-footer">

                        <thead>

                            <tr>

                                <th><?=$this->lang->line('slno')?></th>

                                <th><?=$this->lang->line('invoice_feetype')?></th>

                                <th><?=$this->lang->line('invoice_date')?></th>

                                <th><?=$this->lang->line('invoice_status')?></th>

                                <th><?=$this->lang->line('invoice_student')?></th>

                                <th><?=$this->lang->line('invoice_paymentmethod')?></th>

                                <th><?=$this->lang->line('invoice_amount')?> (EXCL. GST)</th>

                                <th>GST 6%</th>

                                <th><?=$this->lang->line('invoice_amount')?> (INCL. GST)</th>

                                <th><?=$this->lang->line('invoice_due')?></th>

                                <th>Tax Code</th>

                                <th><?=$this->lang->line('action')?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php 
                                $negst = 0;
                                $total_gst = 0;
                                if(count($invoices)) {$i = 1; 
                                foreach($invoices as $invoice) { 
                                    
                                ?>

                                <tr>

                                    <td data-title="<?=$this->lang->line('slno')?>">

                                        <?php echo $i; ?>

                                    </td>

                                    <td data-title="<?=$this->lang->line('invoice_feetype')?>">

                                        <?php 
                                            $feetype_ar = @unserialize($invoice->feetype); 
                                            if($feetype_ar!==false){
                                                echo implode(',', $feetype_ar);
                                            }else{
                                                echo $invoice->feetype;
                                            }
                                        ?>

                                    </td>



                                    <td data-title="<?=$this->lang->line('invoice_date')?>">

                                        <?php echo $invoice->date; ?>

                                    </td>

       

                                    <td data-title="<?=$this->lang->line('invoice_status')?>">

                                        <?php 



                                            $st1 = $status = $invoice->status;

                                            $setstatus = '';

                                            if($status == 0) {

                                                $status = $this->lang->line('invoice_notpaid');

                                            } elseif($status == 1) {
                                                // $negst += $invoice->paidamount;
                                                // $total_gst += ($invoice->paidamount * 6)/100;
                                                $status = $this->lang->line('invoice_partially_paid');

                                            } elseif($status == 2) {
                                                $negst += $invoice->amount;
                                                $total_gst += ($invoice->amount * 6)/100;
                                                $status = $this->lang->line('invoice_fully_paid');

                                            }


                                            if($st1==0){
                                                echo "<button class='btn btn-danger btn-xs ' onclick=\"addPaym('".$invoice->invoiceID."');\">".$status."</button>";
                                            }else if($st1==1){
                                                echo "<button class='btn btn-info btn-xs ' onclick=\"addPaym('".$invoice->invoiceID."');\">".$status."</button>";
                                            }else{
                                                echo "<button class='btn btn-success btn-xs'>".$status."</button>";
                                            }



                                        ?>

                                    </td>



                                    <td data-title="<?=$this->lang->line('invoice_student')?>">

                                        <?php echo $invoice->student; ?>

                                    </td>



                                    <td data-title="<?=$this->lang->line('invoice_paymentmethod')?>">

                                        <?php echo $invoice->paymenttype; ?>

                                    </td>



                                    <td data-title="<?=$this->lang->line('invoice_amount')?>">

                                        <?php echo $siteinfos->currency_symbol. $invoice->amount; ?>

                                    </td>

                                    <td>
                                        <?= number_format(($invoice->amount * 6)/100,2);?>
                                    </td>

                                    <td>
                                        <?= number_format($invoice->amount + ($invoice->amount * 6)/100,2);?>
                                    </td>

                                    <td data-title="<?=$this->lang->line('invoice_due')?>">

                                        <?php echo $siteinfos->currency_symbol.number_format((($invoice->amount + ($invoice->amount * 6)/100) - $invoice->paidamount),2); ?>

                                    </td>


                                    <td><?= $invoice->tax_code;?></td>
                                    

                                    <td data-title="<?=$this->lang->line('action')?>">

                                        <?php //echo btn_view('invoice/view/'.$invoice->invoiceID, $this->lang->line('view')) ?>
                                        <a data-original-title="<?= $this->lang->line('view');?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-xs mrg" href="javascript:viewD('<?= $invoice->invoiceID; ?>');"><i class="fa fa-check-square-o"></i></a>

                                        <?php if($usertype == "Admin" || $usertype == "Accountant") { ?>
                                        <a class="btn btn-warning btn-xs mrg" data-original-title="<?=  $this->lang->line('edit');?>" data-toggle="tooltip" data-placement="top"  href="javascript:mEdit('<?= $invoice->invoiceID;?>');"><i class="fa fa-edit"></i></a>
                                        <?php //echo btn_edit('invoice/edit/'.$invoice->invoiceID, $this->lang->line('edit')) ?>

                                        <?php echo btn_delete('invoice/delete/'.$invoice->invoiceID."/".$month, $this->lang->line('delete'));

                                           if($st1==2) {
                                        ?>  

                                            <a data-original-title="<?= $this->lang->line('view');?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-xs mrg" href="javascript:viewReceipt('<?= $invoice->invoiceID; ?>');"><i class="fa fa-file-text "></i></a>
                                            <?php } ?>

                                            <a class="btn btn-primary btn-xs mrg" data-original-title="Clone"  data-toggle="modal" data-target="#myModal<?= $invoice->invoiceID;?>" data-placement="top" href="javascript:void(0);">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                            <!-- Modal -->
                                            <div id="myModal<?= $invoice->invoiceID;?>" class="modal fade" role="dialog">
                                              <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Clone Invoice</h4>
                                                  </div>
                                                  <div class="modal-body">
                                                    <input type="text" class="datepick" id="invoice_date_<?= $invoice->invoiceID;?>" name="invoice_date" value="" >
                                                    <a class="btn btn-primary btn-xs mrg" data-original-title="Clone" data-toggle="tooltip" data-placement="top" href="javascript:cloneInvoice('<?= $invoice->invoiceID;?>');">
                                                        Accept Clone
                                                    </a>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>
                                            <!-- ** -->
                                        <?php
                                            if($invoice->paymenttype=="Bank Transfer"){
                                        ?>
                                            <a class="btn btn-info btn-xs mrg" data-original-title="Clone"  data-toggle="modal" data-target="#myModal_img<?= $invoice->invoiceID;?>" data-placement="top" href="javascript:void(0);">
                                                <i class="fa fa-picture-o"></i>
                                            </a>
                                            
                                            <!-- Modal -->
                                            <div id="myModal_img<?= $invoice->invoiceID;?>" class="modal fade" role="dialog">
                                              <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Photo</h4>
                                                  </div>
                                                  <div class="modal-body text-center">
                                                    <?php $array = array(
                                                                    "src" => base_url('uploads/images/'.$invoice->image),
                                                                    

                                                                );
                                                                echo img($array);
                                                            ?>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                  </div>
                                                </div>

                                              </div>
                                            </div>
                                            <!-- ** -->
                                        <?php
                                            }
                                        ?>

                                        <?php } ?>


                                    </td>

                                </tr>

                            <?php $i++; }} ?>

                        </tbody>

                    </table>

                    <div class="row">
                        <div class="table-footer">
                            <div class="col-md-12">
                                <div class="col-md-9">&nbsp;</div>
                                <div class="col-md-3 text-left">
                                    <br>
                                    <p>Net Excluding GST (RM) : <?= number_format($negst,2);?></p>
                                    <p>Total GST (RM) : <?= number_format($total_gst,2);?></p>
                                    <p>Net Payable (0M) : <?= number_format($negst+$total_gst,2);?></p>
                                </div>
                            </div>
                        </div> <!-- /.table-footer -->
                    </div> <!-- /.row -->

                </div>

            </div>

        </div>

    </div>

</div>

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

        <div class="modal fade" id="profile_d">

          <div class="modal-dialog md-modal">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>


                </div>

                <div class="modal-body" id="profileview">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                   
                </div>

            </div>

          </div>

        </div>

        <div class="modal fade" id="m_add_payment">

          <div class="modal-dialog ml-modal">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>


                </div>

                <div class="modal-body" id="m_add_payment_body">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                   
                </div>

            </div>

          </div>

        </div>

        <div class="modal fade" id="view_Receipt">

          <div class="modal-dialog md-modal">

            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>


                </div>

                <div class="modal-body" id="m_view_Receipt_body">

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                   
                </div>

            </div>

          </div>

        </div>

        <style type="text/css">
            .s-full {
                background-color: #BC0000;
                border: 1px solid #2d2d2d;
                color: #fff;
            }
        </style>

<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css"
    rel="stylesheet" type="text/css" />
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
    type="text/javascript"></script>

    <script src="<?php echo base_url('assets/js/bootstrap-tabcollapse.js'); ?>"></script> 

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

    function viewReceipt(pid){
        $("body").addClass("pl-wait");
        $.ajax({

            type: 'POST',

            url: "<?=base_url('invoice/viewReceipt')?>/"+pid,

            dataType: "html",

            success: function(data) {
              $("#m_view_Receipt_body").html(data);
              $('#view_Receipt').modal("show");
            },
            complete: function(){
              $("body").removeClass("pl-wait");
            }

        });
    }

    function viewD(pid){
        $("body").addClass("pl-wait");
        $.ajax({

            type: 'POST',

            url: "<?=base_url('invoice/view')?>/"+pid,

            dataType: "html",

            success: function(data) {
              $("#profileview").html(data);
              $('#profile_d').modal("show");
            },
            complete: function(){
              $("body").removeClass("pl-wait");
            }

        });
    }

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

    $('.datepick').each(function(){
        $(this).datepicker({ startView: 0 ,dateFormat: 'dd-mm-yy', });
    });


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

    function cloneInvoice(inid){
        var date_in = $("#invoice_date_"+inid).val();
        $.ajax({

            type: 'POST',

            url: "<?=base_url('invoice/cloneInvoice')?>",

            data: "id=" + inid+"&date="+date_in,

            dataType: "html",

            success: function(data) {

                window.location.reload();

            }

        });
    }

    function mEdit(pid){
    $("body").addClass("pl-wait");
    $.ajax({

        type: 'POST',

        url: "<?=base_url('invoice/edit')?>/"+pid,

        dataType: "html",

        success: function(data) {
          $("#m_edit_body").html(data);
          $('#m_edit').modal("show");
        },
        complete: function(){
          $("body").removeClass("pl-wait");
        }

    });
  }

  function btn_edit(pid){
    $("body").addClass("pl-wait");
    var formData = new FormData($("#edit_frm")[0]);
    $.ajax({

        type: 'POST',

        url: "<?=base_url('invoice/edit')?>/"+pid,

        data: formData,

        dataType: "html",

        processData: false,
        contentType: false,

        success: function(data) {
          if(data=="ok"){
                location.reload();
          }else{
            // alert("some error occured");
            $("#m_edit_body").html(data);
          }
        },
        complete: function(){
          $("body").removeClass("pl-wait");
        }

    });
  }

function addPaym(rid){
    $("body").addClass("pl-wait");
    $.ajax({

        type: 'POST',

        url: "<?=base_url('invoice/add_payment')?>",

        dataType: "html",

        data : 'invoiceID='+rid,

        success: function(data) {
          $("#m_add_payment_body").html(data);
          $('#m_add_payment').modal("show");
        },
        complete: function(){
          $("body").removeClass("pl-wait");
        }

    });
}
function btn_add_payment(type){
    
    $("body").addClass("pl-wait");
    var formData = new FormData($("#add_frm_"+type)[0]);
    $.ajax({

        type: 'POST',

        url: "<?=base_url('invoice/add_payment_info')?>",

        data: formData,

        dataType: "html",

        processData: false,
        contentType: false,

        success: function(data) {
            if(data=="ok"){
                location.reload();
            }
        },
        complete: function(){
          $("body").removeClass("pl-wait");
        }
    });
}
</script>

