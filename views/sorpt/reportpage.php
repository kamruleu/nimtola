<style>
	.table-bordered {
		border: 1px solid #000;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		padding: 4px;
		line-height: 1;
		vertical-align: top;
		border-top: 1px solid #ddd;
	}
	.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
		border: 1px solid #000;
	}
</style>
 
 <div class="panel">
 	<div style="float: right;"><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a></div>
			<?php echo $this->breadcrumb; ?>
 	<div id="printdiv">
            <div class="panel-heading">
			
                <div style="text-align: center;">
                    <h4><strong><?php echo $this->org; ?></strong></h4>
					<h5><strong><?php echo $this->vrptname; ?></strong></h5>
					<h5><strong>From <?php echo $this->vfdate; ?> To <?php echo $this->vtdate; ?></strong></h5>	
                </div>
			</div>
            <div class="panel-body table-responsive" >
            	<?php if($this->tabletitle != ""){ ?>
					<b style="font-size:16px;"><p style="margin-bottom:10px"><?php echo $this->tabletitle ?></p></b>
				<?php } ?>
				<?php echo $this->table;?>
			</div>
		</div>
        </div>

