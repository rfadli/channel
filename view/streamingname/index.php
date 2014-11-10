<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                	<?php
                	$db = Db::init();
					$str = $db->channel;
					$p = array(
						"_id" => new MongoId($idchanel)
					);
					$acr = $str->findOne($p);
					echo '<h1 class="page-header">Streaming channel '.$acr['name'].'</h1>';
					
                	?>
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables<br />
                            <a href="/streamingname/add?id=<?php echo $idchanel; ?>" class="btn btn-default" type="button"><span class="glyphicon glyphicon-plus"></span>Add New</a>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Streaming Name</th>
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
											echo '<a href="/streamingname/edit?id='.$dat['_id'].'" class="fa fa-fw fa-pencil"></a>&nbsp';
											echo '<a href="#" link="/streamingname/delete?id='.trim($dat['_id']).'" controller="Streaming Name" name="'.$dat['name'].'" title="Hapus" class="hapus"><i class="fa fa-times"></i></a>';
											//echo '<a href="/streamingname/delete?id='.$dat['_id'].'" onclick="return confirm(\' Anda Yakin?\')" class="fa fa-fw fa-trash-o"></a>';
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