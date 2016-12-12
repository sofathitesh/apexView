

<div class="box">

    <div class="box-header">

        <h3 class="box-title"><i class="fa icon-routine"></i>Payment</h3>

    </div><!-- /.box-header -->

    <!-- form start -->

    <div class="box-body">

        <div class="row">

            <div class="col-md-12">

            <ul class="nav nav-tabs sidebar-tabs" id="sidebar" role="tablist">
                <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Cash Payment</a></li>
                <li><a href="#tab-2" role="tab" data-toggle="tab">Bank Transfer</a></li>
                <li><a href="#tab-3" role="tab" data-toggle="tab">Credit Card</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tab-1">
                    <form class="form-horizontal" role="form" method="post" id="add_frm_cash" onsubmit="return false;">
                        <br>
                        <div class='form-group'>

                            <label for="room" class="col-sm-3 control-label">
                                Amount
                            </label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control" id="amount" name="amount" value="<?=set_value('amount',($amount+($amount*6)/100)-$paidamount)?>" >

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-sm-offset-2 col-sm-8">

                                <input type="hidden" name="invoiceID" value="<?= $invoiceID;?>">
                                <input type="hidden" name="paymenttype" value="Cash Payment">

                                <input type="submit" class="btn btn-primary" onclick="btn_add_payment('cash');" value="Confirm & pay" >

                            </div>

                        </div>

                    </form>
                </div><!--/.tab-pane -->
                <div class="tab-pane" id="tab-2">
                    <form class="form-horizontal" role="form" method="post" id="add_frm_bank" onsubmit="return false;">
                        <br>
                        <div class='form-group'>

                            <label for="room" class="col-sm-3 control-label">
                                Amount
                            </label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control" id="amount" name="amount" value="<?=set_value('amount',($amount+($amount*6)/100)-$paidamount)?>" >

                            </div>

                        </div>

                        <div class='form-group'>

                            <label for="room" class="col-sm-3 control-label">
                                Photo
                            </label>

                            <div class="col-sm-8">
                                <div class="col-sm-8">
                                    <input class="form-control"  id="uploadFile" placeholder="Choose File" disabled />
                                </div>
                                <div class="col-sm-4">
                                    <div class="fileUpload btn btn-success form-control">

                                        <span class="fa fa-repeat"></span>

                                        <span><?=$this->lang->line("upload")?></span>

                                        <input id="uploadBtn" type="file" class="upload" name="image" />

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-sm-offset-2 col-sm-8">

                                <input type="hidden" name="invoiceID" value="<?= $invoiceID;?>">
                                <input type="hidden" name="paymenttype" value="Bank Transfer">

                                <input type="submit" class="btn btn-primary" onclick="btn_add_payment('bank');" value="Confirm & pay" >

                            </div>

                        </div>

                    </form>
                </div><!--/.tab-pane -->
                <div class="tab-pane" id="tab-3">
                   <form class="form-horizontal" role="form" method="post" id="add_frm_credit" onsubmit="return false;">
                        <br>
                        <div class='form-group'>

                            <label for="room" class="col-sm-3 control-label">
                                Amount
                            </label>

                            <div class="col-sm-8">

                                <input type="text" class="form-control" id="amount" name="amount" value="<?=set_value('amount',($amount+($amount*6)/100)-$paidamount)?>" >

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-sm-offset-2 col-sm-8">

                                <input type="hidden" name="invoiceID" value="<?= $invoiceID;?>">
                                <input type="hidden" name="paymenttype" value="Credit Card">

                                <input type="submit" class="btn btn-primary" onclick="btn_add_payment('credit');" value="Confirm & pay" >

                            </div>

                        </div>

                    </form>
                </div><!--/.tab-pane -->
                
            </div>

                
            </div>

        </div>

    </div>

</div>

<script type="text/javascript">

document.getElementById("uploadBtn").onchange = function() {

    document.getElementById("uploadFile").value = this.value;

};
  $(document).ready(function() {

        // DEPENDENCY: https://github.com/flatlogic/bootstrap-tabcollapse


        // if the tabs are in a narrow column in a larger viewport
        $('.sidebar-tabs').tabCollapse({
            tabsClass: 'visible-tabs',
            accordionClass: 'hidden-tabs'
        });

        // if the tabs are in wide columns on larger viewports
        $('.content-tabs').tabCollapse();

        // initialize tab function
        $('.nav-tabs a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // slide to top of panel-group accordion
        $('.panel-group').on('shown.bs.collapse', function() {
            var panel = $(this).find('.in');
            $('html, body').animate({
                scrollTop: panel.offset().top + (-60)
            }, 500);
        });

    });
</script>