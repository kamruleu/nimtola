 <div class="panel">
 	<div style="float: right;"><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a></div>
			<?php echo $this->breadcrumb; ?>
 	<div id="printdiv">
            <div class="panel-heading">
			
                <div style="text-align: center;">
                    <h4><strong><?php echo $this->org; ?></strong></h4>
					<h5><strong><?php echo $this->vrptname; ?></strong></h5>
					<h5><strong>Date <?php echo $this->vfdate; ?></strong></h5>	
                </div>
			</div>
            <div class="panel-body table-responsive" >
				<?php echo $this->table;?>
			</div>
				<br/>
				<div style="float: left;width: 33%;text-align:center; ">
					Prepared By_____________	
                </div>
				<div style="float: left;width: 33%; text-align:center;">
					Checked By_____________	
                </div>
				<div style="float: left;width: 33%; text-align:center">
					Approved By_____________
										
                </div>
		</div>
        </div>

