 <!-- Begin page content --> 
      <div class="container-fluid"> 
         
        <div class="row-fluid"> 
      		<?php $this->load->view('templates/sidebar_exa');?>
      		
      		<div class="span9"> 
    	  		<?php for($i = 0 ; $i<10 ; $i ++){ ?>
                        <div class="contaniner page-header"> 
	        				<h4>Blast </h4> 
	        				
	    					<i class="icon-filter"></i><b> VCPU 2</b>
	    					<i class="icon-hdd"></i> <b>内存 1024M</b>
	    					<i class="icon-hdd"></i><b> 磁盘 10G</b> 
	    					<i class="icon-wrench"></i>
	    					<a href="<?php echo base_url("example/add/1");?>">使用</a>
	    					<br> 	    					
	    					
	    					<i class="icon-file"></i>
	    					The Basic Local Alignment Search Tool (BLAST) finds regions of local similarity between sequences. The program compares nucleotide or protein sequences to sequence databases and calculates the statistical significance of matches. BLAST can be used to infer functional and evolutionary relationships between sequences as well as help identify members of gene families. Command: blast -p $1 -d $2 -i $3 -o $4, $1 is blastn,blastx,blastp,tblastn or tblastx; $2 is database file; $3 is input file; $4 is output file. More detail: http://blast.ncbi.nlm.nih.gov/Blast.cgi
	    				</div> 
                     <?php } ?>
		  </div>
      	
        </div>
      </div>
</div>