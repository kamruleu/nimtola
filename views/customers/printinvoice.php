<style>
				.table-bordered {
					border: 5px solid #000;
				}
				.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
					padding: 4px;
					line-height: 1.2;
					vertical-align: top;
					border-top: 1px solid #ddd;
				}
				
				.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
					border: 5px solid #000;
				}
</style>
			<div style="float: right;"><a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();" role="button"><span class="glyphicon glyphicon-print"></span>&nbsp;Print</a></div>
			<?php echo $this->breadcrumb; ?>
			<div id="printdiv">
                <div style="text-align: center;">
                   
                </div>
				<div style="text-align: center;">                    
					
                </div>
				
				
				<div>
                    <table class="table table-bordered table-striped" style="font-size: 17px;">
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
						</br>
					<div style="float: left; margin-bottom: 20px;">
                    		<p style="font-size: 20px; border: 1px solid #000;">&nbsp;No: <?php echo $this->cus; ?>&nbsp;</p>
					
                	</div>
						<tbody>
						
							<tr>
								<td><strong>1.Name of Customer</strong></td>
								
								<td colspan="7"><?php echo $this->name; ?></td>
							</tr>
							<tr>
								<td><strong>2.Name of Father/Husband</strong></td>
							
								<td colspan="7"><?php echo $this->fname; ?></td>
							</tr>
							<tr>
								<td><strong>3.Mothers Name</strong></td>
								
								<td colspan="7"><?php echo $this->mname; ?></td>
							</tr>
							<tr>
								<td><strong>4.Present Address</strong></td>
								
								<td colspan="7"><?php echo $this->pradd; ?></td>
							</tr>
							<tr>
								<td><strong>5.Permanent Address</strong></td>
								
								<td colspan="7"><?php echo $this->paradd; ?></td>
							</tr>
							<tr>
								<td><strong>6.Occupation</strong></td>
							
								<td colspan="2"><?php echo $this->occupation; ?></td>
								<td style="text-align:center"><strong>Nationality </strong></td>
								<td colspan="4"><?php echo $this->nationality; ?></td>
							</tr>
							<tr>
								<td><strong>7.Date of Birth</strong></td>
							
								<td colspan="2"><?php echo date('d-m-Y', strtotime($this->dob)); ?></td>
								<td style="text-align:center"><strong>NID </strong></td>
								<td colspan="4"><?php echo $this->nid; ?></td>
							</tr>
							<tr>
								<td><strong>8.Mobile</strong></td>
							
								<td colspan="2"><?php echo $this->xmobile; ?></td>
								<td style="text-align:center"><strong>Religion </strong></td>
								<td colspan="4"><?php echo $this->religion; ?></td>
							</tr>
							<tr>
								<td><strong>9.Name of Nominee</strong></td>
							
								<td colspan="7"><?php echo $this->noname; ?></td>
							</tr>
							<tr>
								<td></td>
							
								<td><strong>Relation </strong></td>
								<td><?php echo $this->norelation; ?></td>
								<td style="text-align:center"><strong>Date Of Birth </strong></td>
								<td colspan="4"><?php echo date('d-m-Y', strtotime($this->noage)); ?></td>
							</tr>
							<tr>
								<td><strong>10.Name of Father/ Husband</strong></td>
							
								<td colspan="7"><?php echo $this->nofather; ?></td>
							</tr>
							<tr>
								<td><strong>11.Address</strong></td>
							
								<td colspan="7"><?php echo $this->noadd; ?></td>
							</tr>
							<tr>
								<td><strong>12.Name of Project</strong></td>
							
								<td colspan="7">Nimtola Abason</td>
							</tr>
							<tr>
								<td><strong>13.Amount of Plot</strong></td>
							
								<td style="text-align: center;"><?php echo $this->katha; ?> Katha</td>
								<td style="text-align:center"><strong>Block No </strong></td>
								<td style="text-align: center;"><?php echo $this->block; ?></td>
								<td style="text-align:center"><strong>Road No </strong></td>
								<td><?php echo $this->rod; ?></td>
								<td style="text-align:center"><strong>Plot No </strong></td>
								<td>
									<?php 
									foreach ($this->getplot as $key => $value) {
									?>
									<i><?php echo $value['xplot']; ?>,</i>
									<?php 
									}
									?>
										
								</td>
							</tr>
							<tr>
								<td><strong>14.Beyond The Price of Plot</strong></td>
							
								<td colspan="7"><?php echo $this->totrate; ?>/=</td>
							</tr>
							<tr>
								<td></td>
							
								<td colspan="7">In Words :<?php echo $this->inwordtotal; ?></td>
							</tr>
							<tr>
								<td><strong>15.Rules of Sales Agreement</strong></td>
							
								<td colspan="2">Installment</td>
								<td colspan="1" style="text-align:center"><strong>Month </strong></td>
								<td colspan="4"><?php echo $this->insmonth; ?></td>
							</tr>
							<?php
							if($this->downpay>0){
							?>
							<tr>
								<td><strong>16.Down Payment</strong></td>
							
								<td colspan="7"><?php echo $this->downpay; ?>/=</td>
							</tr>
							<tr>
								<td></td>
							
								<td colspan="7">In Words :<?php echo $this->inworddown; ?></td>
							</tr>
							<?php
							}elseif($this->bookpay>0){
							?>
							<tr>
								<td><strong>16.Booking Payment</strong></td>
							
								<td colspan="7"><?php echo $this->bookpay; ?>/=</td>
							</tr>
							<tr>
								<td></td>
							
								<td colspan="7">In Words :<?php echo $this->inword; ?></td>
							</tr>
							<?php
							}
							?>
							<tr>
								<td></td>
							
								<td><strong>Cheque No </strong></td>
								<td><?php echo $this->chequeno; ?></td>
								<td style="text-align:center"><strong>Date </strong></td>
								<td colspan="4"><?php echo date('d-m-Y', strtotime($this->chequedate)); ?></td>
							</tr>
							
						
						</tbody>
						
					</table>
						
                </div>
				
			</div>
            
        

