
			
          <div class="header clearfix">		
			<ul class="nav-tabs nav ">
		
			  <li class="active"><a data-toggle="tab" href="javascript:void(0)" onclick="loadIframe('helpframe','<?php echo URL;?>smscls/smsentry')"><strong>SMS</strong></a></li>
			  <li class=""><a data-toggle="tab" href="javascript:void(0)" onclick="loadIframe('helpframe','#')"><strong>SMS List</strong></a></li>
			  
            </ul>
			<div id="result"></div>
            <div class="tab-content">
				
				<iframe id="helpframe" src="<?php echo URL;?>smscls/smsentry" style="margin:0; width:100%; height:150px; border:none; overflow:hidden;" scrolling="no" onload="AdjustIframeHeightOnLoad()"></iframe>
				
			</div>
           </div>
        