<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                	<?php
                	$db = Db::init();
					$str = $db->vod;
					$p = array(
						"_id" => new MongoId($idvod)
					);
					$acb = $str->findOne($p);
					
					echo '<h1 class="page-header">VOD Channels '.$acb['name'].'</h1>';
                	?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DataTables Advanced Tables
                        </div>
                        <a href="/vodname/add?id=<?php echo $idvod; ?>" class="btn btn-default" type="button">add</a>
                        <!-- /.panel-heading -->
                       </br>
                        <?php
						$sql = MysqlDB::init();
						$sql->where('mongoid', $idvod);
						$dql = $sql->get('users');
						
						foreach ($dql as $rr) 
						{
							echo 'user id : '.$rr['userid'].'</br>'.'host : '.$rr['host'].'</br>'.'user : '.$rr['User'];
						}
						?>
						<?php
						echo '<br />';
						echo 'nama : '.$data['name'].'<br />';
						echo 'deskripsi : '.$data['deskripsi'];
						?>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>type</th>
                                            <th>Size</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
										$curl = new Curl();
										$curl->get('http://deboxs.com/api/clientdata/listfiles', array(
										    'userid' => $_SESSION['userid'],
										    'typename' => 'vod',
										    'name' => $data['name']
										));
										$no=1;
										print_r($curl->response);
										foreach ($curl->response->result as $dt) 
										{
											echo '<tr>';
											echo '<td>'.$no.'</td>';
											echo '<td>'.$dt->name.'</td>';
											echo '<td>'.$dt->type.'</td>';
											echo '<td>'.$dt->size.'</td>';
											echo '<td>'.'</td>';
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