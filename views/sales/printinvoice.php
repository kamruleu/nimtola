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

			<div style="float: right;"><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a></div>
			<?php echo $this->breadcrumb; ?>
			<div id="printdiv">
                <div style="text-align: center;">
                    <h2><strong><?php echo $this->org; ?></strong></h2>
					<h5><strong>Proprietor Md. Shabuj Miaji, Head Office: <?php echo Session::get('sbizadd'); ?><br/ > Phone : <?php echo Session::get('bizmobile'); ?></strong></h5>			
                </div>
				<div style="text-align: center;">                    
					<h4><strong><table style="margin: auto; float: center;" border="1"><tbody><tr><td><?php echo $this->vrptname; ?></td></tr></tbody></table></strong></h4>
					<br/>
                </div>
				<div style="float: left;">
                    <p>Invoice/Bill No: <?php echo $this->sono; ?></p>
					<p>Customer: <?php echo $this->cus."-".$this->xorg;  ?></p>
					<p>Address: <?php echo $this->xadd.". Mobile: ".$this->xmobile; ?></p>
					
                </div>
				<div style="float: right;">
                    <p>Date: <?php echo $date = date('d/m/Y', strtotime($this->xdate)); ?></p>
					
                </div>
				<div>
                    <table class="table table-bordered table-striped">
						<thead>
							<th>Sl.</th><th>Itemcode</th><th>Description</th><th style="text-align:right">Bundle</th><th style="text-align:right">Qty</th><th>UOM</th><th style="text-align:right">Rate</th><th style="text-align:right">Tax</th><th style="text-align:right">Total</th>
						</thead>
						<tbody>
						<?php foreach($this->vrow as $key=>$val){ ?>
							<tr>
								<td><?php echo $val['xrow']; ?></td>
								<td>
									<?php echo $val['xitemcode']; ?>
								</td>
								<td>
									<?php echo $val['xitemdesc']; ?>
								</td>
								<td align="right"><?php echo $val['xextqty']; ?></td>
								
								<td align="right"><?php echo number_format($val['xqty'],2); ?></td>
								
								<td align="right"><?php echo $val['xunitsale']; ?></td>
								<td align="right"><?php echo $val['xrate']; ?></td>
								
								<td align="right"><?php echo number_format($val['xtaxtotal'],2); ?></td>
								
								<?php $tot = ($val['xqty']*$val['xrate'])+$val['xtaxtotal']-$val['xdisctotal'];?>
								<td align="right"><?php echo number_format($tot,2); ?></td>
							</tr>
						<?php } ?>	
						</tbody>
						<tfoot>
							<!-- <td align="right"><strong><?php echo $this->totqty; ?></strong></td> -->
							<tr>
								<td colspan="6" align="right"><strong>Total</strong></td><td align="right"><strong><td align="right"><strong><?php echo number_format($this->taxamt,2); ?></strong></td></td><td align="right"><strong><?php echo number_format($this->total,2); ?></strong></td>
							</tr>
							<tr>
								<td colspan="8" align="right"><strong>Fixed Discount</strong></td><td align="right"><strong><?php echo $this->grossdisc; ?></strong></td>
							</tr>
							<?php $nettotal = $this->total-$this->grossdisc; ?>
							<tr>
								<td colspan="8" align="right"><strong>Invoice Total</strong></td><td align="right"><strong><?php echo number_format($nettotal,2); ?></strong></td>
							</tr>
							
							<?php $netdue = ($nettotal-$this->rcvamt)+$this->pcusbal; ?>
							<?php $total = ($netdue-$this->truckfair); ?>
							<tr>
								<td colspan="8" align="right"><strong>Prev. Due</strong></td><td align="right"><strong><?php echo number_format($this->pcusbal,2); ?></strong></td>
							</tr>
							<tr>
								<td colspan="8" align="right"><strong>Paid</strong></td><td align="right"><strong><?php echo number_format($this->rcvamt,2); ?></strong></td>
							</tr>
							<!--<tr>-->
							<!--	<td colspan="8" align="right"><strong>Total Due</strong></td><td align="right"><strong><?php echo $netdue; ?></strong></td>-->
							<!--</tr>-->
							<tr>
								<td colspan="8" align="right"><strong>Truc Fair</strong></td><td align="right"><strong><?php echo $this->truckfair; ?></strong></td>
							</tr>
							<tr>
								<td colspan="8" align="right"><strong>Total Balance</strong></td><td align="right"><strong><?php echo number_format($total,2); ?></strong></td>
							</tr>
							<tr>
								<td colspan="9"><strong><?php echo  $this->narration; ?></strong></td>
							</tr>
							<tr>
								<td colspan="9"><strong>Notes : <?php echo  $this->notes; ?></strong></td>
							</tr>
							
							<tr>
								<td colspan="9"><strong><?php $cur = new Currency(); echo "In Words: ". $cur->get_bd_amount_in_text($netdue); ?></strong></td>
							</tr>
						</tfoot>
					</table>
						
                </div>
				<br/>
				<br/>
				<br/>
				<br/>
				<div style="float: left;width: 33%;text-align:center; ">
					Customer_____________	
                </div>
				<div style="float: left;width: 33%; text-align:center;">
					Checked By_____________	
                </div>
				<div style="float: left;width: 33%; text-align:center">
					Authorised_____________
										
                </div>	
			</div>
            
        

