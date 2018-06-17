<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Tasks REST API</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="jumbotron jumbotron-fluid text-center mt-5" style="padding: 32px;">
			<div class="container">
				<h1 class="jumbotron-heading">Tasks REST API</h1>
				<p class="lead text-muted">REST API for a task manager system using Laravel 4.1 and PHP 5.3</p>
				<p class="lead text-muted">(c) Dyarlen Iber - dyarlen1@gmail.com</p>
				<p class="lead text-muted" style="font-size: 0.75rem;">https://github.com/dyarleniber/laravel4.1-rest-api</p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<button type="button" class="btn btn-primary mb-2 float-right" onclick="newTask()"><i class="fas fa-plus"></i> New task</button>
			</div>

			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table text-center">
						<thead>
							<tr>
								<th scope="col">#ID</th>
								<th scope="col">Title</th>
								<th scope="col">Description</th>
								<th scope="col">Priority</th>
								<th scope="col"> </th>
							</tr>
						</thead>
						<tbody>

						<?php

							if ($tasks->count() == 0) {

						?>

							<tr>
								<td colspan="5">
									<p class="lead text-muted">No records found</p>
								</td>
							</tr>

						<?php

							} else {
								foreach ($tasks as $task) {

						?>

							<tr>
								<td><?php echo $task->id; ?></td>
								<td><?php echo $task->title; ?></td>
								<td><?php echo $task->description; ?></td>
								<td><?php echo Task::getPriorityLabel($task->priority); ?></td>
								<td class="text-center">
									<button title="Update" type="button" class="m-1 btn btn-primary" onclick="editTask(this)" data-id="<?php echo $task->id; ?>" data-title="<?php echo htmlentities($task->title); ?>" data-description="<?php echo htmlentities($task->description); ?>" data-priority="<?php echo htmlentities($task->priority); ?>"><i class="far fa-edit"></i></button>
									<button title="Delete" type="button" class="m-1 btn btn-primary" onclick="deleteTask(this)" data-id="<?php echo $task->id; ?>"><i class="far fa-trash-alt"></i></button>
								</td>
							</tr>

						<?php

								}
							}

						?>

						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-12">
		  		<nav class="text-center">
		  			<?php echo $tasks->links(); ?>
		  		</nav>
		  	</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/sweetalert2@7.22.0/dist/sweetalert2.all.js"></script>
	<script src="https://unpkg.com/promise-polyfill"></script>
	<script type="text/javascript">

		function newTask() {
			swal({
				type: 'question',
				title: 'New task',
				showCancelButton: true,
				html:
					'<div id="swal2-content" style="display: block; margin-bottom: 12px;">Fill all fields</div>' +
					'<div class="swal2-validationerror" id="swal2-validationerror-new" style="display: flex; margin-left: -20px; margin-right: -20px;"></div>' +
					'<input placeholder="Title" id="title" name="title" class="swal2-input">' +
					'<input placeholder="Description" id="description" name="description" class="swal2-input">' +
					'<select class="swal2-select" style="display: flex;" id="priority" name="priority">' +
					'<option value="1">Maximum priority</option>' +
					'<option value="2">High priority</option>' +
					'<option value="3" selected>Medium priority</option>' +
					'<option value="4">Low priority</option>' +
					'<option value="5">Minimum priority</option>' +
					'</select>',
				focusConfirm: false,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					return new Promise((resolve) => {
						$( "#swal2-validationerror-new" ).hide();

						if (! document.getElementById('title').value) {
							swal.getContent().querySelector('#swal2-validationerror-new').textContent = "Enter title";
							$( "#swal2-validationerror-new" ).show();
							resolve();
						} else if (! document.getElementById('description').value) {
							swal.getContent().querySelector('#swal2-validationerror-new').textContent = "Enter description";
							$( "#swal2-validationerror-new" ).show();
							resolve();
						} else if (! document.getElementById('priority').value) {
							swal.getContent().querySelector('#swal2-validationerror-new').textContent = "Enter priority";
							$( "#swal2-validationerror-new" ).show();
							resolve();
						} else {
							$.ajax({
		                        method: "POST",
		                        dataType: "json",
		                        url: "<?php echo route('tasks_store'); ?>",
		                        data: {
		                        	title: document.getElementById('title').value,
		                        	description: document.getElementById('description').value,
		                        	priority: document.getElementById('priority').value
		                        }
		                    }).done(function (data, textStatus, xhr) {
		                        if (xhr.status == 201) {
				                   	swal({type: 'success', title: 'Success', text: 'New task successfully stored!'}).then(function (result) {
										window.location.replace("<?php echo route('uiexample'); ?>");
									});
		                        } else {
		                            swal({type: 'error', title: 'Error', text: 'Error storing new task.'});
		                        }
		                    }).fail(function () {
		                        swal({type: 'error', title: 'Error', text: 'Error storing new task.'});
		                    });
						}
					});
				},
				allowOutsideClick: () => !swal.isLoading()
			});
		}

		function editTask(element) {
			var id = $(element).data("id");
			var title = htmlEntities($(element).data("title"));
			var description = htmlEntities($(element).data("description"));
			var priority = htmlEntities($(element).data("priority"));

			swal({
				type: 'question',
				title: 'Update task',
				showCancelButton: true,
				html:
					'<div id="swal2-content-edit" style="display: block; margin-bottom: 12px;">Update task</div>' +
					'<div class="swal2-validationerror" id="swal2-validationerror-edit" style="display: flex; margin-left: -20px; margin-right: -20px;"></div>' +
					'<input type="hidden" id="id-edit" name="id-edit" value="'+id+'">' +
					'<input placeholder="Title" id="title-edit" name="title-edit" value="'+title+'" class="swal2-input">' +
					'<input placeholder="Description" id="description-edit" name="description-edit" value="'+description+'" class="swal2-input">' +
					'<select class="swal2-select" style="display: flex;" id="priority-edit" name="priority-edit">' +
					'<option value="1" '+(priority == '1' ? 'selected' : '' )+'>Maximum priority</option>' +
					'<option value="2" '+(priority == '2' ? 'selected' : '' )+'>High priority</option>' +
					'<option value="3" '+(priority == '3' ? 'selected' : '' )+'>Medium priority</option>' +
					'<option value="4" '+(priority == '4' ? 'selected' : '' )+'>Low priority</option>' +
					'<option value="5" '+(priority == '5' ? 'selected' : '' )+'>Minimum priority</option>' +
					'</select>',
				focusConfirm: true,
				showLoaderOnConfirm: true,
				preConfirm: () => {
					return new Promise((resolve) => {
						$( "#swal2-validationerror-edit" ).hide();

						if (! document.getElementById('title-edit').value) {
							swal.getContent().querySelector('#swal2-validationerror-edit').textContent = "Enter title";
							$( "#swal2-validationerror-edit" ).show();
							resolve();
						} else if (! document.getElementById('description-edit').value) {
							swal.getContent().querySelector('#swal2-validationerror-edit').textContent = "Enter description";
							$( "#swal2-validationerror-edit" ).show();
							resolve();
						} else if (! document.getElementById('priority-edit').value) {
							swal.getContent().querySelector('#swal2-validationerror-edit').textContent = "Enter priority";
							$( "#swal2-validationerror-edit" ).show();
							resolve();
						} else {
							$.ajax({
		                        method: "PUT",
		                        dataType: "json",
		                        url: "<?php echo route('tasks_update'); ?>",
		                        data: {
		                        	id: document.getElementById('id-edit').value,
		                        	title: document.getElementById('title-edit').value,
		                        	description: document.getElementById('description-edit').value,
		                        	priority: document.getElementById('priority-edit').value
		                        }
		                    }).done(function (data, textStatus, xhr) {
		                        if (xhr.status == 200) {
				                   	swal({type: 'success', title: 'Success', text: 'Task changed successfully!'}).then(function (result) {
										window.location.replace("<?php echo route('uiexample'); ?>");
									});
		                        } else {
		                            swal({type: 'error', title: 'Error', text: 'Error changing task.'});
		                        }
		                    }).fail(function () {
		                        swal({type: 'error', title: 'Error', text: 'Error changing task.'});
		                    });
						}
					});
				},
				allowOutsideClick: () => !swal.isLoading()
			});
		}

	    function deleteTask(element)
	    {
			var id = $(element).data("id");

	        swal({
	            title: 'Delete task',
	            text: 'Are you sure you want to remove the task?',
	            type: 'question',
	            showCancelButton: true,
	            showLoaderOnConfirm: true,
	            preConfirm: function (value) {
	            	if (value) {
		                return new Promise(function (resolve) {
							$.ajax({
		                        method: "DELETE",
		                        dataType: "json",
		                        url: "<?php echo route('tasks_delete'); ?>",
		                        data: { id: id }
		                    }).done(function (data, textStatus, xhr) {
		                        if (xhr.status == 200) {
				                   	swal({type: 'success', title: 'Success', text: 'Task successfully removed!'}).then(function (result) {
										window.location.replace("<?php echo route('uiexample'); ?>");
									});
		                        } else {
		                            swal({type: 'error', title: 'Error', text: 'Error removing task.'});
		                        }
		                    }).fail(function () {
		                        swal({type: 'error', title: 'Error', text: 'Error removing task.'});
		                    });
		                });
	                }
	            },
				allowOutsideClick: () => !swal.isLoading()
	        });
	    }

		function htmlEntities(str) {
		    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
		}

	</script>
</body>
</html>
