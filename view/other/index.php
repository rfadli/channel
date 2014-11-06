<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Other Channels</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    Area Chart Example
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-area-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                           </br>
                        <a href="/other/add" class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span>Add New</a>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Other Name</th>
                                            <th>Status</th>
                                            <th>Created Time</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	$no = 1;
                                    	foreach($data as $dat)
                                    	{
                                    		echo '<tr>';
											echo '<td>'.$no.'</td>';
											echo '<td>'.$dat['name'].'</td>';
											echo '<td>'.$dat['status'].'</td>';
											echo '<td>'.date('d/m/Y', $dat['time_created']).'</td>';
											echo '<td>'.'<center>';
											echo '<a href="/other/edit?id='.$dat['_id'].'" class="fa fa-fw fa-pencil"></a>&nbsp';
											echo '<a href="/other/delete?id='.$dat['_id'].'" onclick="return confirm(\' Anda Yakin?\')" class="fa fa-fw fa-trash-o"></a>';
											echo '</center>'.'</td>';
											echo '</tr>';
											$no++;
                                    	}
                                    	?>
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->