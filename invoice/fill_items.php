<?php
	for ($i=0; $i < $item_no; $i++) { 
?>
	<div class='form-group' >
	    <label for="feetype" class="col-sm-4 control-label">

	        <b>Item <?= ($i+1);?></b>

	    </label>

	    <div class="col-sm-4">

	        <?php

	            $array = array();

	            $array[0] = "Select Feetype";
	            if(count($feetypes)){
	                foreach ($feetypes as $fee) {

	                    $array[$fee->feetypeID."_0::".$fee->feetype] = $fee->feetype;

	                }
	            }
	            if(count($packages)){
	                foreach ($packages as $pack) {

	                    $array[$pack->packageID."_1::".$pack->package] = $pack->package;

	                }
	            }

	            echo form_dropdown("feetype[]", $array, set_value("feetype"), "id='feetype' class='form-control'");

	        ?>
	    </div>


	</div>

	<div class='form-group' >
		<label for="amount" class="col-sm-4 control-label">

	        <?=$this->lang->line("invoice_amount")?>

	    </label>

	    <div class="col-sm-4">

	        <input type="number" class="form-control" id="amount" name="amount[]" value="<?=set_value('amount')?>" >

	    </div>
	</div>

	<div class='form-group' >
		<label for="quantity" class="col-sm-4 control-label">

	        Quantity

	    </label>

	    <div class="col-sm-4">

	        <input type="number" class="form-control" id="quantity" name="quantity[]" value="<?=set_value('quantity')?>" >

	    </div>
	</div>

<!--	<div class='form-group' >
		<label for="tax_code" class="col-sm-4 control-label">

	        Tax Code

	    </label>

	    <div class="col-sm-4">

	        <input type="text" class="form-control" id="tax_code" name="tax_code[]" value="<?=set_value('tax_code')?>" >

	    </div>
	</div>-->
<?php
	}
?>