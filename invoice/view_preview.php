<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $panel_title; ?></title>

<style type="text/css">
    #pdf_viewReceipt #page-wrap {
        width: 700px;
        margin: 0 auto;
    }
    #pdf_viewReceipt .center-justified {
        text-align: justify;
        margin: 0 auto;
        width: 30em;
    }
    /*ini starts here*/
    #pdf_viewReceipt .list-group {
      padding-left: 0;
      margin-bottom: 15px;
      width: auto;
    }
    #pdf_viewReceipt .list-group-item {
      position: relative;
      display: block;
      padding: 7.5px 10px;
      margin-bottom: -1px;
      background-color: #fff;
      border: 1px solid #ddd;
      /*margin: 2px;*/
    }
    #pdf_viewReceipt table {
      border-spacing: 0;
      border-collapse: collapse;
      font-size: 12px;
    }
    #pdf_viewReceipt td,
    #pdf_viewReceipt th {
      padding: 0;
    }
    @media print {
      #pdf_viewReceipt * {
        color: #000 !important;
        text-shadow: none !important;
        background: transparent !important;
        box-shadow: none !important;
      }
      #pdf_viewReceipt a,
      #pdf_viewReceipt a:visited {
        text-decoration: underline;
      }
      #pdf_viewReceipt a[href]:after {
        content: " (" attr(href) ")";
      }
      #pdf_viewReceipt abbr[title]:after {
        content: " (" attr(title) ")";
      }
      #pdf_viewReceipt a[href^="javascript:"]:after,
      #pdf_viewReceipt a[href^="#"]:after {
        content: "";
      }
      #pdf_viewReceipt pre,
      #pdf_viewReceipt blockquote {
        border: 1px solid #999;

        page-break-inside: avoid;
      }
      #pdf_viewReceipt thead {
        display: table-header-group;
      }
      #pdf_viewReceipt tr,
      #pdf_viewReceipt img {
        page-break-inside: avoid;
      }
      #pdf_viewReceipt img {
        max-width: 100% !important;
      }
      #pdf_viewReceipt p,
      #pdf_viewReceipt h2,
      #pdf_viewReceipt h3 {
        orphans: 3;
        widows: 3;
      }
      #pdf_viewReceipt h2,
      #pdf_viewReceipt h3 {
        page-break-after: avoid;
      }
      #pdf_viewReceipt select {
        background: #fff !important;
      }
      #pdf_viewReceipt .navbar {
        display: none;
      }
      #pdf_viewReceipt .table td,
      #pdf_viewReceipt .table th {
        background-color: #fff !important;
      }
      #pdf_viewReceipt .btn > .caret,
      #pdf_viewReceipt .dropup > .btn > .caret {
        border-top-color: #000 !important;
      }
      #pdf_viewReceipt .label {
        border: 1px solid #000;
      }
      #pdf_viewReceipt .table {
        border-collapse: collapse !important;
      }
      #pdf_viewReceipt .table-bordered th,
      #pdf_viewReceipt .table-bordered td {
        border: 1px solid #ddd !important;
      }
    }
    #pdf_viewReceipt table {
      max-width: 100%;
      background-color: transparent;
      font-size: 12px;
    }
    #pdf_viewReceipt th {
      text-align: left;
    }
    #pdf_viewReceipt .table {
      width: 100%;
      margin-bottom: 20px;
    }
    #pdf_viewReceipt .head {
       border-top: 0px solid #e2e7eb;
       border-bottom: 0px solid #e2e7eb;  
    }
    #pdf_viewReceipt .table > thead > tr > th,
    #pdf_viewReceipt .table > tbody > tr > th,
    #pdf_viewReceipt .table > tfoot > tr > th,
    #pdf_viewReceipt .table > thead > tr > td,
    #pdf_viewReceipt .table > tbody > tr > td,
    #pdf_viewReceipt .table > tfoot > tr > td {
      padding: 8px;
      line-height: 1.428571429;
      vertical-align: top;
      border-top: 1px solid #e2e7eb; 
    }
    /*ini edit default value : border top 1px to 0 px*/
    #pdf_viewReceipt .table > thead > tr > th {
      font-size: 12px;
      font-weight: 500;
      vertical-align: bottom;
      /*border-bottom: 2px solid #e2e7eb;*/
      color: #242a30;
     
      
    }
    
    #pdf_viewReceipt .table > caption + thead > tr:first-child > th,
    #pdf_viewReceipt .table > colgroup + thead > tr:first-child > th,
    #pdf_viewReceipt .table > thead:first-child > tr:first-child > th,
    #pdf_viewReceipt .table > caption + thead > tr:first-child > td,
    #pdf_viewReceipt .table > colgroup + thead > tr:first-child > td,
    #pdf_viewReceipt .table > thead:first-child > tr:first-child > td {
      border-top: 0;
    }
    #pdf_viewReceipt .table > tbody + tbody {
      border-top: 2px solid #e2e7eb;
    }
    #pdf_viewReceipt .table .table {
      background-color: #fff;
    }
    #pdf_viewReceipt .table-condensed > thead > tr > th,
    #pdf_viewReceipt .table-condensed > tbody > tr > th,
    #pdf_viewReceipt .table-condensed > tfoot > tr > th,
    #pdf_viewReceipt .table-condensed > thead > tr > td,
    #pdf_viewReceipt .table-condensed > tbody > tr > td,
    #pdf_viewReceipt .table-condensed > tfoot > tr > td {
      padding: 5px;
    }
    #pdf_viewReceipt .table-bordered {
      border: 1px solid #e2e7eb;
    }
    #pdf_viewReceipt .table-bordered > thead > tr > th,
    #pdf_viewReceipt .table-bordered > tbody > tr > th,
    #pdf_viewReceipt .table-bordered > tfoot > tr > th,
    #pdf_viewReceipt .table-bordered > thead > tr > td,
    #pdf_viewReceipt .table-bordered > tbody > tr > td,
    #pdf_viewReceipt .table-bordered > tfoot > tr > td {
      border: 1px solid #e2e7eb;
    }
    #pdf_viewReceipt .table-bordered > thead > tr > th,
    #pdf_viewReceipt .table-bordered > thead > tr > td {
      border-bottom-width: 2px;
    }
    .table-striped > tbody > tr:nth-child(odd) > td,
    #pdf_viewReceipt .table-striped > tbody > tr:nth-child(odd) > th {
      background-color: #f0f3f5;
    }
    #pdf_viewReceipt .panel-title {
      margin-top: 0;
      margin-bottom: 0;
      font-size: 20px;
      color: #fff;
      padding: 0;
    }
    #pdf_viewReceipt .panel-title > a {
      color: #707478;
      text-decoration: none;
    }
    a {
      background: transparent;
      color: #707478;
      text-decoration: none;
    }
    #pdf_viewReceipt strong {
        color: #707478;
    }

    #pdf_viewReceipt .total {
        float: left;
        color: #232A3F;
        margin-left: 80px;
        font-weight: 200;
    }

    #pdf_viewReceipt .lead {
        font-size: 20px;
    }
</style>
</head>
<body>
<div id="pdf_viewReceipt">
<div id="page-wrap">
<?php
  $usertype = $this->session->userdata("usertype");

  if($usertype == "Admin" || $usertype == "Accountant") { ?>
    <div class="well">
        <div class="row">

            <div class="col-sm-12">
                <button class="btn-cs btn-sm-cs" onclick="javascript:printDiv('printablediv')"><span class="fa fa-print"></span> <?=$this->lang->line('print')?> </button>
                <?php
                 echo btn_add_pdf('invoice/pdf_viewReceipt/'.$invoice->invoiceID, $this->lang->line('pdf_preview')) 
                ?>
                                
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
    <?php }
?>
<div id="printablediv">
  <table width="100%">
    <tr>
      <td width="100%" style="text-align: center;">
        <h2 >
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
        </h2>
        
            <b>Company Registeration No. 1167112A</b><br>
            <b>GST Reg. No. 1111006544</b>
            <br>
      </td>
      
    </tr>
    <tr>
      
      <td>
        <table width="100%" class="table">
          <tr>
            <td width="60%" style="border: none;"></td>
            <td width="60%" style="border: none;">
              <h5 style="margin-top:35px;"><?php  echo $this->lang->line("invoice_create_date")." : ". date("d M Y"); ?></h5>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <br /><br />

  <table width="100%">
    <tr>
      <td width="33%">
        <table >
            <tbody>
                <tr>
                    <th><?php  echo $this->lang->line("invoice_from"); ?></th>
                </tr>
                <tr>
                    <td><?=$siteinfos->sname?></td>
                </tr>
                <tr>
                  <td><?=$siteinfos->address?></td>
                </tr>
                <tr>
                  <td><?=$this->lang->line("invoice_phone"). " : ". $siteinfos->phone?></td>
                </tr>
                <tr>
                  <td><?=$this->lang->line("invoice_email"). " : ". $siteinfos->email?></td>
                </tr>
            </tbody>
          </table>

      </td>
      <td width="33%">
        <?php if(count($student) == "") { ?>
          <table >
              <tbody>
                  <tr>
                      <th><?php  echo $this->lang->line("invoice_to"); ?></th>
                  </tr>
                  <tr>
                      <td><?php  echo $this->lang->line("invoice_sremove"); ?></td>
                  </tr>
              </tbody>
          </table>
        <?php } else { ?>
          <table >
            <tbody>
                <tr>
                    <th><?php  echo $this->lang->line("invoice_to"); ?></th>
                </tr>
                <tr>
                    <td><?php  echo $student->name; ?></td>
                </tr>
                <tr>
                    <td><?php  echo $this->lang->line("invoice_roll"). " : ". $invoice->roll; ?></td>
                </tr>
                <tr>
                    <td><?php  echo $this->lang->line("invoice_classesID"). " : ". $invoice->classes; ?></td>
                </tr>
                <tr>
                  <td><?=$this->lang->line("invoice_email"). " : ". $student->email?></td>
                </tr>
            </tbody>
          </table>
        <?php } ?>
      </td>
      <td width="33%" style="vertical-align: text-top;">
        <table>
          <tbody>
            <tr>
              <td><?php echo "Receipt No : " . $invoice->invoice_no; ?></td>
            </tr>
            <?php if($invoice->paiddate) { ?>
                <tr>
                  <td>
                    <?=$this->lang->line("invoice_pdate")." : ". date("d M Y", strtotime($invoice->paiddate))?>
                  </td>
                </tr>
            <?php } ?>
            
          </tbody>
        </table>
      </td>
    </tr>
  </table>
  <br /><br />

  <table class="table table-striped">
    <thead>
      <tr>
          <th ><?=$this->lang->line('slno')?></th>
          <th ><?=$this->lang->line('invoice_feetype')?></th>
          <th >Description</th>
          <th >Quantity</th>
          <th ><?=$this->lang->line('invoice_amount')?></th>
          <th >DISC AMT</th>
          <th >Total Amount (EXCL. GST)</th>
          <th >GST</th>
          <th >Total Amount (INCL. GST)</th>
          <th >TAX CODE</th>
      </tr>
    </thead>
    <tbody>
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
              <td data-title="DISC AMT">
                  
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
              </td>
      </tr>
        <?php
                }
            }
        ?>
    </tbody>
  </table>

  <table class="table" width="100%">
    <tr>
      <td width="65%">
      </td>
      <td width="35%">
        
            <table class="table">
                    <tr>
                        <td></td>
                        <td>MYR</td>
                    </tr>
                    <tr>
                            <th class="col-sm-8 col-xs-8"><?=$this->lang->line('invoice_subtotal')?></th>
                            <td class="col-sm-4 col-xs-4"><?=$invoice->amount?></td>
                    </tr>
                        <tr>
                            <th class="col-sm-8 col-xs-8">Total Discount</th>
                            <td class="col-sm-4 col-xs-4"></td>
                        </tr>
                        <tr>
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
                        </tr>
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
          

      </td>
    </tr>
  </table>

</div>
</div>
</div>

<script type="text/javascript">
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
</script>

</body>
</html>