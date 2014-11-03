<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Streaming Name</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Basic Form Elements
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-md-2"></div>
                                <div class="col-lg-6">
                                    <form action="<?php echo $link; ?>" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
	                                        <label>Streaming Name</label>	
	                                        <?php
												echo '<input type="text" name="name" class="form-control" value="'.$name.'"/>';
											?>  
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <span class="field">
												<textarea name="deskripsi" class="form-control" rows="3" style="margin: 0px -5.5px 0px 0px; width: 499px; height: 246px"><?php echo $deskripsi; ?></textarea>
											</span>
												
                							<?php
									        if(isset($error['deskripsi']) )
											{
									        	echo '<small class="desc">';
												foreach ($error['deskripsi'] as $message)
									            {
									                echo '<label class="error">'.$message.'</label>';
									            }
									         	echo '</small>';
											}
									        ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Status</label>
                                            <?php
									        if($status == "enable")
											{
												echo '<span class="field">';
												echo '<input type="checkbox" name="status"  checked/> Enable';
												echo '</span>';
											}
											else 
											{
												echo '<span class="field">';
												echo '<input type="checkbox" name="status" /> Enable';
												echo '</span>';
											}            
					                      ?>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-default">Submit Button</button>
                                        <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                                
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>