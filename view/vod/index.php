<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">VOD Channel</h1>
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
            
            <form action='/vod/index/' class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <input type="text" class="smallinput" name="search" value="<?php echo $search; ?>" />
            <button class="radius3">Search</button>
            </form>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                            </br>
                            <a href="/vod/add" class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span>Add New</a>
                        </div>
                        
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>VOD</th>
                                            <th>Status</th>
                                            <th>Created Time</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	$no = 1;
                                    	foreach($data as $dk)
                                    	{
                                    		echo '<tr>';
											echo '<td>'.$no.'</td>';
											echo '<td>'.$dk['name'].'</td>';
											echo '<td>'.$dk['status'].'</td>';
											echo '<td>'.date('d/m/Y', $dk['time_created']).'</td>';
											echo '<td>'.'<center>';
											echo '<a href="/vod/edit?id='.$dk['_id'].'" class="fa fa-fw fa-pencil"></a>&nbsp';
											echo '<a href="#" link="/vod/delete?id='.trim($dk['_id']).'" controller="Vod" name="'.$dk['name'].'" title="Hapus" class="hapus"><i class="fa fa-times"></i></a>';
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