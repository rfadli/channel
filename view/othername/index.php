<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                	<?php
                	$db = Db::init();
					$sts = $db->other;
					$p = array(
						"_id" => new MongoId($idother)
					);
					$acd = $sts->findOne($p);
					echo '<h1 class="page-header">Other Channel '.$acd['name'].'</h1>';
					
                	?>
                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables</br>
                            <a href="/othername/edit?id=<?php echo $idother; ?>" class="btn btn-default" type="button"><span class="glyphicon glyphicon-wrench"></span> Edit</a>
                        </div>
                        <!-- /.panel-heading -->
                        <br />
                        <?php
						$sql = MysqlDB::init();
						$sql->where('mongoid', $idother);
						$dql = $sql->get('users');
						
						foreach ($dql as $rr) 
						{
							echo '<ul class="list-group">';
							echo '<li class="list-group-item list-group-item-success">'.'User Id : '.$rr['userid'].'</li>';
							echo '<li class="list-group-item list-group-item-info">'.'User :  '.$rr['User'].'</li>';
							echo '<li class="list-group-item list-group-item-warning">'.'Host :  '.$rr['host'].'</li>';
							echo '<li class="list-group-item list-group-item-success">'.'Password :  '.$rr['Password'].'</li>';
						}
						
						echo '<li class="list-group-item list-group-item-info">'.'Name :  '.$data['name'].'</li>';
						echo '<li class="list-group-item list-group-item-warning">'.'Deskripsi :  '.$data['deskripsi'].'</li>';
						echo '</ul>';
						?>
                        
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Created Time</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
                                    	$curl = new Curl();
										$curl->get('http://www.deboxs.com/api/clientdata/listfiles', array(
										    'userid' => $_SESSION['userid'],
										    'typename' => 'others',
										    'name' => $data['name']
										));
										$no=1;
										//echo 'response : ' .$curl->response;
										//print_r($curl->response);
										foreach ($curl->response->result as $dt) 
										{
											echo '<tr>';
											echo '<td>'.$no.'</td>';
											echo '<td>'.$dt->name.'</td>';
											echo '<td>'.$dt->type.'</td>';
											echo '<td>'.$dt->size.'</td>';
											echo '<td>'.'<a href="#" link="/othername/delete?idother='.trim($data['_id']).'" controller="Other" name="'.$dt->name.'" title="Hapus" class="hapus"><i class="fa fa-times"></i></a>'.'</td>';
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