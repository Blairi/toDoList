document.addEventListener('DOMContentLoaded', () => {
	menu();
	editar();
	validar();
	nuevaTarea();
});

const nuevaTarea = () => {
	btnNuevo = document.querySelector('.btn-nueva-tarea');
	btnNuevo.addEventListener('click', popUp);
}

const popUp = () => {
	const tarea = document.querySelector('.crear-tarea');
	tarea.classList.remove('ocultar');

	//Cuando se da click en cancelar
	const btnCancelar = document.querySelector('#boton-cancelar');
	btnCancelar.onclick = function(){
		tarea.classList.add('ocultar');
		body.classList.remove('fijar-body');
	}

	//Mostar HTML
	const body = document.querySelector('body');
	body.classList.add('fijar-body');
}

const validar = () =>{
	const inputTarea = document.querySelectorAll('#tarea');
	const inputDescripcion = document.querySelectorAll('#tarea-descripcion');

	const btnGuardar = document.querySelectorAll('.guardar');

	for(let i = 0; i < inputDescripcion.length; i++){
		inputTarea[i].addEventListener('input', e => {
			//Eliminamos los espacios del final y los del inicio
			const tituloTarea = e.target.value.trim();

			//Comprobamos si el input tiene algo
			if(tituloTarea === '' || tituloTarea.length < 4){
				//En i le pasamos la posicion donde debe mostrarse la alerta
				mostrarAlerta('Nombre de Tarea no valido', 'error', i);

				//Si NO tiene nada agregamos los atributos y clases
				btnGuardar[i].setAttribute('disabled', 'true');
				btnGuardar[i].classList.add('deshabilitado');

				
			}else{
				//Si SÍ tiene algo eliminamos los atributos y clases
				btnGuardar[i].classList.remove('deshabilitado');
				btnGuardar[i].removeAttribute('disabled', 'false');

				//Si tampoco NO tiene nada el input descripcion 
				//agregamos los atributos y clases
				if(inputDescripcion[i].value === '' || inputDescripcion[i].value.length < 15){
					btnGuardar[i].classList.add('deshabilitado');
					btnGuardar[i].setAttribute('disabled', 'true');
				}
			}
		});

		inputDescripcion[i].addEventListener('input', e => {
			const descripcionTarea = e.target.value.trim();
			if(descripcionTarea === '' || descripcionTarea.length < 15){
				//En i le pasamos la posicion donde debe mostrarse la alerta
				mostrarAlerta('Descripcion de Tarea no valida', 'error', i);

				//Si NO tiene nada agregamos los atributos y clases
				btnGuardar[i].setAttribute('disabled', 'true');
				btnGuardar[i].classList.add('deshabilitado');

				
			}else{
				//Si SÍ tiene algo eliminamos los atributos y clases
				btnGuardar[i].classList.remove('deshabilitado');
				btnGuardar[i].removeAttribute('disabled', 'false');

				//Si tampoco NO tiene nada el input tarea 
				//agregamos los atributos y clases
				if(inputTarea[i].value === '' || inputTarea[i].value.length < 4){
					btnGuardar[i].classList.add('deshabilitado');
					btnGuardar[i].setAttribute('disabled', 'true');
				}
			}
		});
	}
}

function mostrarAlerta(mensaje, tipo, numeroDeDIV){
	//Si hay alerta previa no crear nd
	const alertaPrevia = document.querySelector('.alerta');
	if(alertaPrevia){
		return;
	}
	//Crear alerta
	const alerta = document.createElement('DIV');
	alerta.textContent = mensaje;
	alerta.classList.add('alerta');
	if(tipo === 'error'){
		alerta.classList.add('error');
	}

	//insertar en el HTML
	const mostrarAlertasDIV = document.querySelectorAll('.mostrar-alertas');

	//Le añadimos el hijo en el div que exista el error
	mostrarAlertasDIV[numeroDeDIV].appendChild(alerta);

	//Eliminar alerte despues de 3 seg
	setTimeout(()=>{
		alerta.remove();
	},3000)
}

const menu = () =>{
	const btnMenu = document.getElementById('btn-menu');
	const menu = document.getElementById('menu');
	btnMenu.addEventListener('click', () => {
		menu.classList.toggle('ocultar');
	});
}
const editar = () =>{
	const btnEditar = document.querySelectorAll('.btn-editar');
	const btnNoConfirmar = document.querySelectorAll('.no-confirmar');
	const btnCancelar = document.querySelectorAll('.cancelar');
	const btnEliminarTarea = document.querySelectorAll('.eliminar-tarea');

	const tarea = document.querySelectorAll('.vista-tarea');
	const formularioEditar = document.querySelectorAll('.editar-tarea');
	const confirmar = document.querySelectorAll('.confirmar-tarea');
	

	//Mostrar edicion
	for(let i = 0; i < btnEditar.length; i++){
		btnEditar[i].addEventListener('click', () =>{
			formularioEditar[i].classList.toggle('ocultar');
			tarea[i].classList.toggle('ocultar');
		});
	}

	//Cancelar edicion
	for(let e = 0; e < btnCancelar.length; e++){
		btnCancelar[e].addEventListener('click', () => {
			tarea[e].classList.remove('ocultar');
			formularioEditar[e].classList.add('ocultar');
		});
	}

	//Mostrar confirmacion
	for(let o = 0; o < btnEliminarTarea.length; o++){
		btnEliminarTarea[o].addEventListener('click', () => {
			confirmar[o].classList.remove('ocultar');
			tarea[o].classList.add('ocultar');
		});
	}

	//Cancelar confirmar tarea
	for(let a = 0; a < btnNoConfirmar.length; a++){
		btnNoConfirmar[a].addEventListener('click', () => {
			tarea[a].classList.remove('ocultar');
			confirmar[a].classList.add('ocultar');
		});
	}
}