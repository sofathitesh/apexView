<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $panel_title; ?></title>

<style type="text/css">
    #page-wrap {
        width: 700px;
        margin: 0 auto;
    }
    .center-justified {
        text-align: justify;
        margin: 0 auto;
        width: 30em;
    }
    /*ini starts here*/
    .list-group {
      padding-left: 0;
      margin-bottom: 15px;
      width: auto;
    }
    .list-group-item {
      position: relative;
      display: block;
      padding: 7.5px 10px;
      margin-bottom: -1px;
      background-color: #fff;
      border: 1px solid #ddd;
      /*margin: 2px;*/
    }
    table {
      border-spacing: 0;
      border-collapse: collapse;
      font-size: 12px;
    }
    td,
    th {
      padding: 0;
    }
    @media print {
      * {
        color: #000 !important;
        text-shadow: none !important;
        background: transparent !important;
        box-shadow: none !important;
      }
      a,
      a:visited {
        text-decoration: underline;
      }
      a[href]:after {
        content: " (" attr(href) ")";
      }
      abbr[title]:after {
        content: " (" attr(title) ")";
      }
      a[href^="javascript:"]:after,
      a[href^="#"]:after {
        content: "";
      }
      pre,
      blockquote {
        border: 1px solid #999;

        page-break-inside: avoid;
      }
      thead {
        display: table-header-group;
      }
      tr,
      img {
        page-break-inside: avoid;
      }
      img {
        max-width: 100% !important;
      }
      p,
      h2,
      h3 {
        orphans: 3;
        widows: 3;
      }
      h2,
      h3 {
        page-break-after: avoid;
      }
      select {
        background: #fff !important;
      }
      .navbar {
        display: none;
      }
      .table td,
      .table th {
        background-color: #fff !important;
      }
      .btn > .caret,
      .dropup > .btn > .caret {
        border-top-color: #000 !important;
      }
      .label {
        border: 1px solid #000;
      }
      .table {
        border-collapse: collapse !important;
      }
      .table-bordered th,
      .table-bordered td {
        border: 1px solid #ddd !important;
      }
    }
    table {
      max-width: 100%;
      background-color: transparent;
      font-size: 12px;
    }
    th {
      text-align: left;
    }
    .table {
      width: 100%;
      margin-bottom: 20px;
    }
    .head {
       border-top: 0px solid #e2e7eb;
       border-bottom: 0px solid #e2e7eb;  
    }
    .table > thead > tr > th,
    .table > tbody > tr > th,
    .table > tfoot > tr > th,
    .table > thead > tr > td,
    .table > tbody > tr > td,
    .table > tfoot > tr > td {
      padding: 8px;
      line-height: 1.428571429;
      vertical-align: top;
      border-top: 1px solid #e2e7eb; 
    }
    /*ini edit default value : border top 1px to 0 px*/
    .table > thead > tr > th {
      font-size: 12px;
      font-weight: 500;
      vertical-align: bottom;
      /*border-bottom: 2px solid #e2e7eb;*/
      color: #242a30;
     
      
    }
    
    .table > caption + thead > tr:first-child > th,
    .table > colgroup + thead > tr:first-child > th,
    .table > thead:first-child > tr:first-child > th,
    .table > caption + thead > tr:first-child > td,
    .table > colgroup + thead > tr:first-child > td,
    .table > thead:first-child > tr:first-child > td {
      border-top: 0;
    }
    .table > tbody + tbody {
      border-top: 2px solid #e2e7eb;
    }
    .table .table {
      background-color: #fff;
    }
    .table-condensed > thead > tr > th,
    .table-condensed > tbody > tr > th,
    .table-condensed > tfoot > tr > th,
    .table-condensed > thead > tr > td,
    .table-condensed > tbody > tr > td,
    .table-condensed > tfoot > tr > td {
      padding: 5px;
    }
    .table-bordered {
      border: 1px solid #e2e7eb;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > tbody > tr > th,
    .table-bordered > tfoot > tr > th,
    .table-bordered > thead > tr > td,
    .table-bordered > tbody > tr > td,
    .table-bordered > tfoot > tr > td {
      border: 1px solid #e2e7eb;
    }
    .table-bordered > thead > tr > th,
    .table-bordered > thead > tr > td {
      border-bottom-width: 2px;
    }
    .table-striped > tbody > tr:nth-child(odd) > td,
    .table-striped > tbody > tr:nth-child(odd) > th {
      background-color: #f0f3f5;
    }
    .panel-title {
      margin-top: 0;
      margin-bottom: 0;
      font-size: 20px;
      color: #fff;
      padding: 0;
    }
    .panel-title > a {
      color: #707478;
      text-decoration: none;
    }
    a {
      background: transparent;
      color: #707478;
      text-decoration: none;
    }
    strong {
        color: #707478;
    }

    .total {
        float: left;
        color: #232A3F;
        margin-left: 80px;
        font-weight: 200;
    }

    .lead {
        font-size: 20px;
    }
</style>
</head>
<body>

<div id="page-wrap">
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


</body>
</html>