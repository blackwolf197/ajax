<script type="text/javascript">
	$(document).ready(function(){

		mostrarAlumnos();

		function mostrarAlumnos(){
			$.ajax({
				type: 'ajax',
				url: '<?= base_url('alumnoC/get_alumno') ?>',
				dataType: 'json',

				success: function(datos){
					var tabla = '';
					var i;
					var n=1;

					for(i=0;i<datos.length;i++){
						tabla += '<tr>'+
						'<td>'+n+'</td>'+
						'<td>'+datos[i].nombres+' '+datos[i].apellidos+'</td>'+
						'<td>'+datos[i].nombre_sexo+'</td>'+
						'<td>'+datos[i].nombre_curso+'</td>'+
						'<td>'+'<a href="javascript:;" class="btn btn-danger btn-sm borrar" data="'+datos[i].id_alumno+'">Eliminar</a>'+
						'</td>'+
						'<td>'+'<a href="javascript:;" class="btn btn-info btn-sm item-edit" data="'+datos[i].id_alumno+'">Editar</a>'+
						'</td>'+
						'</tr>';
						n++;
					}
					$('#tabla_alumnos').html(tabla);
				}
			});
		};//Fin de función mostrar alumnos


		//Eliminar alumno

		$('#tabla_alumnos').on('click','.borrar', function(){
			$id = $(this).attr('data');//Para capturar el dato según el boton que demos click

			$('#modalBorrar').modal('show'); //Para mostrar el modal

			$('#btnBorrar').unbind().click(function(){
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: '<?= base_url('alumnoC/eliminar') ?>',
					data: {id:$id},
					dataType: 'json',

					success: function(respuesta){
						 $('#modalBorrar').modal('hide');//Escondemos el modal
						 if (respuesta==true) {
						 	alertify.notify('Eliminado exitosamente', 'success',10,null);
						 	mostrarAlumnos();
						 }else{
						 	alertify.notify('Error al eliminar', 'error',10,null);
						 }
					}
				});
			});

		});

//Ingresar alumno
		$('#nueAlu').click(function(){
			$('#alumno').modal('show');
			$('#alumno').find('.modal-title').text('Nuevo alumno');
			$('#formAlumno').attr('action','<?= base_url('alumnoC/ingresar') ?>');
		});

		get_sexo();//llamado a la función
		function get_sexo(){
			$.ajax({
				type:'ajax',
				url: '<?= base_url('alumnoC/get_sexo') ?>',
				dataType: 'json',

				success: function(datos){
					var op= '';
					var i;
					op+="<option value=''>--Selecione una opción--</option>";
					for (i=0;i<datos.length;i++){
						op+="<option value='"+datos[i].id_sexo+"'>"+datos[i].nombre_sexo+"</option>";
					}
					$('#sexo').html(op);
				}
			});
		}//Fin select sexo

		get_curso();//llamado a la función
		function get_curso(){
			$.ajax({
				type:'ajax',
				url: '<?= base_url('alumnoC/get_curso') ?>',
				dataType: 'json',

				success: function(datos){
					var op= '';
					var i;
						op+="<option value=''>--Selecione una opción--</option>";
					for (i=0;i<datos.length;i++){
						op+="<option value='"+datos[i].id_curso+"'>"+datos[i].nombre_curso+"</option>";
					}
					$('#curso').html(op);
				}
			});
		}//Fin select sexo


		$('#btnGuardar').click(function(){
			$url=$('#formAlumno').attr('action');
			$data=$('#formAlumno').serialize();
			$.ajax({
				type: 'ajax',
				method: 'post',
				url: $url,
				data: $data,
				dataType: 'json',

				success: function(respuesta){
					$('#alumno').modal('hide');
					if (respuesta=='add') {
						alertify.notify('¡Ingresado exitosamente!','success',10,null);
					}else if(respuesta=='edi'){
						alertify.notify('Actualizado exitosamente!','success',10,null);
					}else{
						alertify.notify('¡Error al ingresar!','error',10,null);
					}
					$('#formAlumno')[0].reset();
					mostrarAlumnos();
				}
			});
		});//Termina

		//Actualizar
		$('#tabla_alumnos').on('click','.item-edit', function(){
			$id= $(this).attr('data');

			$('#alumno').modal('show');
			$('#alumno').find('.modal-title').text('Editar alumno');
			$('#formAlumno').attr('action','<?= base_url('alumnoC/actualizar') ?>');

			$.ajax({
				type:'ajax',
				method: 'post',
				url: '<?= base_url('alumnoC/get_datos') ?>',
				data: {id:$id},
				dataType: 'json',

				success: function(datos){
					$('#id').val(datos.id_alumno);
					$('#nombre').val(datos.nombres);
					$('#apellido').val(datos.apellidos);
					$('#sexo').val(datos.id_sexo);
					$('#curso').val(datos.id_curso);
				}
			});
		});


	});
</script>