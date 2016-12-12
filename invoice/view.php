
<?php 
    if(count($invoice)) {
        $usertype = $this->session->userdata("usertype");
        if($usertype == "Admin" || $usertype == "Accountant" || $usertype == "Student" || $usertype == "Parent") {
?>
	<?php if($usertype == "Admin" || $usertype == "Accountant") { ?>
    <div class="well">
        <div class="row">

            <div class="col-sm-12">
                <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?=$this->lang->line('print')?> </button>
                <?php
                 echo btn_add_pdf('invoice/print_preview/'.$invoice->invoiceID, $this->lang->line('pdf_preview')) 
                ?>
                <?php
                    /*if($invoice->paidamount != $invoice->amount) {
                        echo btn_payment('invoice/payment/'.$invoice->invoiceID, $this->lang->line('payment')); 
                    }*/
                ?>
                <button class="btn-cs btn-sm-cs" data-toggle="modal" data-target="#mail"><span class="fa fa-envelope-o"></span> <?=$this->lang->line('mail')?></button>                
            </div>

            <!-- <div class="col-sm-6">
                <ol class="breadcrumb">
                    <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                    <li><a href="<?=base_url("invoice/index")?>"><?=$this->lang->line('menu_invoice')?></a></li>
                    <li class="active"><?=$this->lang->line('view')?></li>
                </ol>
            </div> -->
        </div>
    </div>
    <?php } elseif($usertype == "Student" || $usertype == "Parent") { ?>
        <?php if($invoice->paidamount != $invoice->amount) { ?>
        <div class="well">
            <div class="row">
                <div class="col-sm-6">
                    <?=btn_payment('invoice/payment/'.$invoice->invoiceID, $this->lang->line('payment')); ?>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li><a href="<?=base_url("dashboard/index")?>"><i class="fa fa-laptop"></i> <?=$this->lang->line('menu_dashboard')?></a></li>
                        <li><a href="<?=base_url("invoice/index")?>"><?=$this->lang->line('menu_invoice')?></a></li>
                        <li class="active"><?=$this->lang->line('view')?></li>
                    </ol>
                </div>
            </div>
        </div>
        <?php } ?>
    <?php } ?>

<div id="printablediv">
	<section class="content invoice" >
		<!-- title row -->
		<div class="row">
		    <div class="col-xs-12 text-center">
		        <h2 class="page-header">
		            <?php
	                    if($siteinfos->photo) {
		                    $array = array(
		                        "src" => base_url('uploads/images/'.$siteinfos->photo),
		                        'width' => '70px',
		                        'class' => 'img-circle'
		                    );
		                    echo img($array);
		                } 
	                ?>
                    <br>
	                <?php  echo $siteinfos->sname; ?>
		            <!-- <small class="pull-right"><?=$this->lang->line('invoice_create_date').' : '.date('d M Y')?></small> -->
		        </h2>
                <address>
                    <!--<strong><?=$siteinfos->sname?></strong><br>-->
                    <?=$siteinfos->address?><br>
                    <?=$this->lang->line("invoice_phone"). " : ". $siteinfos->phone?><br>
                    <?=$this->lang->line("invoice_email"). " : ". $siteinfos->email?><br>
                </address>
                <!--<b>Company Registeration No. 1167112A</b><br>
                <b>GST Reg. No. 1111006544</b>-->
       
		    </div><!-- /.col -->
		</div>
		<!-- info row -->
		<div class="row invoice-info">
            </div><!-- /.col -->
            <div class="col-sm-12 invoice-col">
                
                <b><center>Yuarn <?= date("M-Y",strtotime($invoice->date));?></center></b>
            </div><!-- /.col -->
		    <div class="col-sm-6 invoice-col">
		        <?php if(count($student) == "") { ?>
                    <?=$this->lang->line("invoice_to")?>
                    <address>
                        <?=$this->lang->line("invoice_sremove")?>
                    </address>
                <?php } else { ?>
                    
                    <address>
                        <strong><?=$student->name?></strong><br>
                        <?=$this->lang->line("invoice_roll"). " : ". $invoice->roll?><br>
                        <?=$this->lang->line("invoice_classesID"). " : ". $invoice->classes?><br>
                        <!--<?=$this->lang->line("invoice_email"). " : ". $student->email?><br>-->
                    </address>
                    <!--<p><b>ATTN : </b></p>
                    <p><b>TEL : </b><?= $parentes->phone;?></p>
                    <p><b>FAX. : </b></p>
                    <p><b>GST NO. : </b></p>
                    <p><b>A/C NO. : </b><?= $invoice->account_no;?></p>-->
                <?php } ?>
                </div>
		    <div class="col-sm-offset-4 col-sm-2 invoice-col">

		        <h4>TAX INVOICE</h4>
                <p><b>NO. : </b>#<?= $invoice->invoiceID;?></p>
                <p><b>Date : </b><?= date("d M Y");?></p>
                <!--<p><b>Term : </b></p>
                <p><b>Currency : </b>MYR @ <?= $invoice->amount;?></p>
                <p><b>Agent : </b></p>
                <p><b>Page : </b>1</p>
                <p><b>Printed On : </b><?= date("d M Y");?></p>
                <p><b>Printed By : </b><?= $usertype;?></p>-->

		</div><!-- /.row -->

		<!-- Table row -->
        <br />
		<div class="row">
			<div class="col-xs-12" id="hide-table">
		        <table>
		            <thead style="border:1px solid black;border-left-style:none;border-right-style: none">
		                <tr>
		                    <th class="col-sm-1"><?=$this->lang->line('slno')?></th>
                            <th class="col-sm-1"><?=$this->lang->line('invoice_feetype')?></th>
                            <th class="col-sm-1">Description</th>
                            <th class="col-sm-1">Quantity</th>
                            <th class="col-sm-1"><?=$this->lang->line('invoice_amount')?></th>
                            <!--<th class="col-sm-1">DISC AMT</th>
                            <th class="col-sm-1">Total Amount (EXCL. GST)</th>
                            <th class="col-sm-1">GST</th>
		                    <th class="col-sm-1">Total Amount (INCL. GST)</th>
		                    <th class="col-sm-1">TAX CODE</th>-->
		                </tr>
		            </thead>
		            <tbody style="border:1px solid black;border-left-style:none;border-right-style: none;border-top-style: none;">
                        <?php
                            
                            if($invoice->invoce_data!=""){
                                $invoce_data = unserialize($invoice->invoce_data);
                                $item_no = $invoice->item_no;
                                for ($i=0; $i < $item_no; $i++) { 
                                   
                        ?>  
		                <tr>
		                    <td data-title="<?=$this->lang->line('slno')?>">
		                        <?php echo ($i+1); ?>
		                    </td>
		                    <td data-title="<?=$this->lang->line('invoice_feetype')?>">
		                        <?php 
                                    if($invoce_data["feetype_arr"][$i]!=""){
                                        $ft_ar = explode("::", $invoce_data["feetype_arr"][$i]);
                                        echo $ft_ar[1];
                                    }
                                ?>
		                    </td>
                            <td data-title="Description">
                                <?php echo $invoce_data["fp_arr"][$i]; ?>
                            </td>
		                    <td data-title="Quantity">
                                <?php echo $invoce_data["quantity_arr"][$i]; ?>
		                    </td>
                            <td data-title="<?=$this->lang->line('invoice_amount')?>">
                                <?php echo $invoce_data["amount_arr"][$i]; ?>
                            </td>
                            <!--<td data-title="DISC AMT">
                                
                            </td>
                            <td data-title="Total Amount (EXCL. GST)">
                                <?php echo $invoce_data["amount_arr"][$i]; ?>
                            </td>
                            <td data-title="GST">
                                <?= number_format(((($invoce_data["amount_arr"][$i]*$invoce_data["quantity_arr"][$i]) * 6 )/100),2);?>
                            </td>
                            <td data-title="Total Amount (INCL. GST)">
                                <?php echo number_format(($invoce_data["amount_arr"][$i]*$invoce_data["quantity_arr"][$i])+((($invoce_data["amount_arr"][$i]*$invoce_data["quantity_arr"][$i]) * 6 )/100),2); ?>
                            </td>
                            <td data-title="TAX CODE">
                                <?php echo $invoce_data["tax_code_arr"][$i]; ?>
                            </td>-->
		                </tr>
                        <?php
                                }
                            }
                        ?>
		            </tbody>
		        </table>
		    </div>
		</div><!-- /.row -->
        <?php
            function to_word($number){
                $no = round($number);
                $point = round($number - $no, 2) * 100;
                $hundred = null;
                $digits_1 = strlen($no);
                $i = 0;
                $str = array();
                $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
                $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                while ($i < $digits_1) {
                 $divider = ($i == 2) ? 10 : 100;
                 $number = floor($no % $divider);
                 $no = floor($no / $divider);
                 $i += ($divider == 10) ? 1 : 2;
                 if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                        " " . $digits[$counter] . $plural . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        . $digits[$counter] . $plural . " " . $hundred;
                 } else $str[] = null;
                }
                $str = array_reverse($str);
                $result = implode('', $str);
                $points = ($point) ?
                "." . $words[$point / 10] . " " . 
                      $words[$point = $point % 10] : '';
                return ucwords($result);
            }
        ?>
		<div class="row">
		    <!-- accepted payments column -->
            <!--<br>
            <br>
            <div class="col-sm-12">
                <h4>NOTICE PERINGATAN YURAN : <?= to_word($invoice->amount);?></h4>
            </div>
            <div class="col-sm-6">
                <p>Yuran bulanan perlu dijelaskan sebelum atau pada 6 haribulan maka,</p>
                <p>para pelajar tidakdibenarkan memasuki kelas sehingga bayaran dijelaskan.</p>
            </div>-->
            <div class="clearfix"></div>
            <br>
            <br>
            <!--<div class="col-sm-12">
            <b>RINGGIT MALAYSIA</b>
            <hr>
            <div class="col-sm-6">
                <p>Tuan/Pian digalakkan membuat bayaran secara pemindahan elektronik (Transfer) ke akaun kami</p>
                <p>IDEA UNGGUL BHD:</p>
                <p>MAYBANK : 5122 6851 0707</p>
                <p>CIMB : 8602 19 2737</p>
                <p>Email Transaksi ke : yuran_ptiu@yahoo.com.my</p>
                <p>Atau. Whatsapp ke : 016-350 2600 / 019-300 2600</p>
            </div><!-- /.col -->
            <div class="col-xs-12 col-sm-6 col-lg-6 col-md-18" style="float:right;">
		        <div class="table-responsive">
		            <table style="border:1px solid black;border-left-style:none;border-right-style: none;width:100%">
                        <!--<tr>
                            <td></td>
                            <td>MYR</td>
                        </tr>-->
		                <tr style="border:1px solid black;border-left-style:none;border-right-style: none;">
                            <th class="col-sm-8 col-xs-8"><?=$this->lang->line('invoice_subtotal')?></th>
                            <td class="col-sm-4 col-xs-4"><?=$invoice->amount?></td>
		                </tr>
                        <tr style="border:1px solid black;border-left-style:none;border-right-style: none">
                            <th class="col-sm-8 col-xs-8">Total Discount</th>
                            <td class="col-sm-4 col-xs-4"></td>
                        </tr>
                        <!--<tr>
                            <th class="col-sm-8 col-xs-8">Total Excluding GST</th>
                            <td class="col-sm-4 col-xs-4"><?=$invoice->amount?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-8 col-xs-8">Add GST</th>
                            <td class="col-sm-4 col-xs-4"><?= number_format(($invoice->amount * 6 )/100,2);?></td>
                        </tr>
                        <tr>
                            <th class="col-sm-8 col-xs-8">Add GST</th>
                            <td class="col-sm-4 col-xs-4"><?= number_format(($invoice->amount)+(($invoice->amount * 6 )/100),2);?></td>
                        </tr>-->
		            </table>
                    <?php
                    $amto = $invoice->amount;
                    $invoice->amount = number_format(($invoice->amount)+(($invoice->amount * 6 )/100),2);
                    ?>
                    <?php if(empty($invoice->paidamount) && $invoice->paidamount == 0) { ?>
                        <table class="table">
                            <tr>
                                <th class="col-sm-8 col-xs-8">TOTAL PAYABLE INCL GST</th>
                                <td class="col-sm-4 col-xs-4"><?=$siteinfos->currency_symbol." ".$invoice->amount?></td>
                            </tr>
                        </table>
                    <?php } else { if($invoice->amount == $invoice->paidamount && $invoice->status == 2) { ?>
                        <table class="table">
                            <tr>
                                <th class="col-sm-8 col-xs-8">TOTAL PAYABLE INCL GST</th>
                                <td class="col-sm-4 col-xs-4"><?=$siteinfos->currency_symbol." ".$invoice->amount?></td>
                            </tr>
                        </table>
                    <?php } elseif($invoice->amount > $invoice->paidamount && $invoice->status == 1) { ?>
                        <table class="table">
                            <tr>
                                <th class="col-sm-8 col-xs-8"><?=$this->lang->line('invoice_made');?></th>
                                <td class="col-sm-4 col-xs-4"><?=$invoice->paidamount?></td>
                            </tr>
                        </table>

                        <table class="table">
                            <tr>
                                <th class="col-sm-8 col-xs-8"><?=$this->lang->line('invoice_due')." (".$siteinfos->currency_code.")";?></th>
                                <?php $due = $invoice->amount-$invoice->paidamount; ?>
                                <td class="col-sm-4 col-xs-4"><?=$siteinfos->currency_symbol." ".$due?></td>
                            </tr>
                        </table>
                    <?php } else { ?>
                    <table class="table">
                        <tr>
                            <th class="col-sm-8 col-xs-8"><?=$this->lang->line('invoice_due')." (".$siteinfos->currency_code.")";?></th>
                            <?php $due = $invoice->amount-$invoice->paidamount; ?>
                            <td class="col-sm-4 col-xs-4"><?=$siteinfos->currency_symbol." ".$due?></td>
                        </tr>
                    </table>
                    <?php } } ?>

		        </div>
            </div><!-- /.col -->
		    </div><!-- /.col -->
<!--            <div class="col-md-12">
                <h5>*Bayaran Perlu dijelaskan sebelum " 6 <?= date("M-Y");?>"</h5>
                <br>
                <div class="col-md-3">
                </div>
                <div class="col-md-6">
                <div class="">
                    <table class="table">
                        <tr>
                            <th>GST Summary</th>
                            <th>Amount</th>
                            <th>GST Amount</th>
                        </tr>
                        <tr>
                            <td><?= $invoice->tax_code;?> 6%</td>
                            <td><?= $invoice->amount;?></td>
                            <td><?= ($amto * 6)/100;?></td>
                        </tr>
                    </table>
                </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
		</div><!-- /.row -->

		<!-- this row will not appear when printing -->
	</section><!-- /.content -->
</div>
<!-- email modal starts here -->
<form class="form-horizontal" role="form" action="<?=base_url('teacher/send_mail');?>" method="post">
    <div class="modal fade" id="mail">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title"><?=$this->lang->line('mail')?></h4>
            </div>
            <div class="modal-body">
            
                <?php 
                    if(form_error('to')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                ?>
                    <label for="to" class="col-sm-2 control-label">
                        <?=$this->lang->line("to")?>
                    </label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control" id="to" name="to" value="<?=set_value('to')?>" >
                    </div>
                    <span class="col-sm-4 control-label" id="to_error">
                    </span>
                </div>

                <?php 
                    if(form_error('subject')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                ?>
                    <label for="subject" class="col-sm-2 control-label">
                        <?=$this->lang->line("subject")?>
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="subject" name="subject" value="<?=set_value('subject')?>" >
                    </div>
                    <span class="col-sm-4 control-label" id="subject_error">
                    </span>

                </div>

                <?php 
                    if(form_error('message')) 
                        echo "<div class='form-group has-error' >";
                    else     
                        echo "<div class='form-group' >";
                ?>
                    <label for="message" class="col-sm-2 control-label">
                        <?=$this->lang->line("message")?>
                    </label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="message" name="message" style="resize: vertical;" value="<?=set_value('message')?>" ></textarea>
                    </div>
                </div>

            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="margin-bottom:0px;" data-dismiss="modal"><?=$this->lang->line('close')?></button>
                <input type="button" id="send_pdf" class="btn btn-success" value="<?=$this->lang->line("send")?>" />
            </div>
        </div>
      </div>
    </div>
</form>
<!-- email end here -->
<script language="javascript" type="text/javascript">
    function printDiv(divID) {
        //Get the HTML of div
        var divElements = document.getElementById(divID).innerHTML;
        //Get the HTML of whole page
        var oldPage = document.body.innerHTML;

        //Reset the page's HTML with div's HTML only
        document.body.innerHTML = 
          "<html><head><title></title></head><body>" + 
          divElements + "</body>";

        //Print Page
        window.print();

        //Restore orignal HTML
        document.body.innerHTML = oldPage;
    }
    function closeWindow() {
        location.reload(); 
    }

    function check_email(email) {
        var status = false;     
        var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
        if (email.search(emailRegEx) == -1) {
            $("#to_error").html('');
            $("#to_error").html("<?=$this->lang->line('mail_valid')?>").css("text-align", "left").css("color", 'red');
        } else {
            status = true;
        }
        return status;
    }


    $("#send_pdf").click(function(){
        var to = $('#to').val();
        var subject = $('#subject').val();
        var message = $('#message').val();
        var id = "<?=$invoice->invoiceID;?>";
        var error = 0;

        if(to == "" || to == null) {
            error++;
            $("#to_error").html("");
            $("#to_error").html("<?=$this->lang->line('mail_to')?>").css("text-align", "left").css("color", 'red');
        } else {
            if(check_email(to) == false) {
                error++
            }
        } 

        if(subject == "" || subject == null) {
            error++;
            $("#subject_error").html("");
            $("#subject_error").html("<?=$this->lang->line('mail_subject')?>").css("text-align", "left").css("color", 'red');
        } else {
            $("#subject_error").html("");
        }

        if(error == 0) {
            $.ajax({
                type: 'POST',
                url: "<?=base_url('invoice/send_mail')?>",
                data: 'to='+ to + '&subject=' + subject + "&id=" + id+ "&message=" + message,
                dataType: "html",
                success: function(data) {
                    location.reload();
                }
            });
        }
    });
    
</script>
<?php }} ?>
